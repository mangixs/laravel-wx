<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\libraries\classes\FormCheck;
use App\models\admin\article;
use DB;
use Illuminate\Http\Request;
use App\libraries\classes\search;

class ArticleController extends Controller
{
    private $rule = [
        'article_form' => [
            'title' => ['name' => 'title', 'preg' => ':notnull', 'notice' => '请输入标题!'],
            'type' => ['name' => 'type', 'preg' => ':number', 'notice' => '请选择文章类型!'],
            'content' => ['name' => 'content', 'preg' => ':notnull', 'notice' => '请输入详情!'],
            'show_place' => ['name' => 'show_place', 'preg' => '/^[1|2]{1}$/', 'notice' => '请选择展示位置'],
            'first_img' => ['name' => 'first_img', 'preg' => ':image', 'notice' => '请上传新闻首图'],
            'is_show' => ['name' => 'is_show', 'preg' => '/^[1|2]{1}$/', 'notice' => '请选择是否展示'],
        ],
    ];
    public function index()
    {
        $data['title'] = '文章管理';
        $data['key'] = $this->authKey('article');
        return view('admin.article.index', $data);
    }
    public function pageData(Request $request)
    {
        $m = new search();
		$db=DB::table('article');
        $m->setSearch($db,$request);
        $db->where(['article.valid'=>1]);
		$ret['page'] =$m->setPage($db,$request);
		$ret['data'] = $db->select('article.id', 'article.title', 'article_type.named as type', 'article.update_at', 'article.first_img', 'article.sort')
            ->leftJoin('article_type', 'article_type.id', '=', 'article.type')
            ->orderBy('article.update_at', 'desc')
            ->where('article.valid', 1)
            ->get();
		foreach ($ret['data'] as  &$v) {
			$v->update_at=date('Y-m-d H:i:s',$v->update_at);
		}
		return response()->json($ret);
    }
    public function add()
    {
        $data['action'] = 'add';
        $data['articleType'] = $this->articleType();
        return view('admin.article.add', $data);
    }
    public function edit($id, $act)
    {
        $data['data'] = article::find($id);
        $data['action'] = $act;
        $data['articleType'] = $this->articleType();
        return view('admin.article.add', $data);
    }
    private function articleType()
    {
        $tmp = DB::table('article_type')->select('id', 'named')->get();
        return $tmp;
    }
    public function save(Request $request)
    {
        $data['title'] = $request->post('title');
        $data['type'] = $request->post('type');
        $data['content'] = $request->post('content');
        $data['show_place'] = $request->post('show_place');
        $data['summary'] = $request->post('summary');
        $data['first_img'] = $request->post('first_img');
        $data['is_show'] = $request->post('is_show');
        $data['sort'] = $request->post('sort');
        $data['update_at'] = time();
        $formObj = new FormCheck($this->rule);
        $checkResult = $formObj->checkFrom($data, 'article_form');
        if ($checkResult['result'] !== 'CHECK_PASS') {
            return response()->json($checkResult);
        }
        $action = $request->post('action');
        switch ($action) {
            case 'add':
                $data['created_at'] = $data['update_at'];
                $id = article::insertGetId($data);
                break;
            case 'edit':
                $id = $request->post('id');
                article::where('id', $id)->update($data);
                break;
            default:
                # code...
                break;
        }
        return response()->json(['result' => 'SUCCESS', 'msg' => '保存成功', 'id' => $id]);
    }
    public function deleteArticle($id)
    {
        article::where('id', $id)->update(['valid' => 0]);
        return response()->json(['result' => 'SUCCESS', 'msg' => '删除成功']);
    }
    public function type()
    {
        return view('admin.article.type');
    }
    public function typeData()
    {
        $data = DB::table('article_type')->get();
        foreach ($data as $key => $v) {
            $v->insert_at = date('Y-m-d H:i:s', $v->insert_at);
        }
        return response()->json(['result' => 'SUCCESS', 'msg' => '获取成功', 'data' => $data]);
    }
    public function typeSave(Request $request)
    {
        $data['named'] = $request->post('named');
        $data['insert_at'] = time();
        $id = DB::table('article_type')->insertGetId($data);
        return response()->json(['result' => 'SUCCESS', 'msg' => '添加成功']);
    }
    public function deleteArticleType($id)
    {
        DB::table('article_type')->where('id', $id)->delete();
        return response()->json(['result' => 'SUCCESS', 'msg' => '删除成功']);
    }
}
