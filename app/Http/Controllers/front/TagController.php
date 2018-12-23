<?php
namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\models\front\tag;
use DB;
use Illuminate\Http\Request;
use App\libraries\classes\search;

class TagController extends Controller
{
    private $rule = [
        'tag_form' => [
            'title' => ['name' => 'title', 'preg' => ':notnull', 'notice' => '请输入名称!'],
            'sort' => ['name' => 'sort', 'preg' => ':number', 'notice' => '请输入排序!'],
            'color' => ['name' => 'color', 'preg' => '/^\#[a-zA-Z|0-9]{6}$/', 'notice' => '请选择正确的背景颜色', 'not_null' => false],
        ],
    ];
    public function index()
    {
        $data['title'] = '商品标签管理';
        $data['key'] = $this->authKey('tag');
        return view('front.tag.index', $data);
    }
    public function pageData(Request $request)
    {
        $m = new search;
        $db = DB::table('goods_tag');
        $db->where(['valid'=>1]);
        $m->setSearch($db,$request);
        $ret['page'] = $m->setPage($db,$request);
        $ret['data'] = $db->select(['id','title','update_at','insert_at','sort'])->get();
        foreach($ret['data'] as $k=>&$v){
            $v->insert_at = date('Y-m-d H:i:s',$v->insert_at);
        }
        return response()->json($ret);
    }
    public function save(Request $request)
    {
        $data['title'] = $request->post('title');
        $data['sort'] = $request->post('sort');
        $data['color'] = $request->post('color');
        $formObj = load_class('FormCheck', $this->rule);
        $checkResult = $formObj->checkFrom($data, 'tag_form');
        if ($checkResult['result'] !== 'CHECK_PASS') {
            return response()->json($checkResult);
        }
        $action = $request->post('action');
        switch ($action) {
            case 'add':
                $data['insert_at'] = $data['insert_at'] = time();
                $id = tag::insertGetId($data);
                break;
            case 'edit':
            $data['insert_at'] = time();
                $id = $request->post('id');
                tag::where('id', $id)->update($data);
                break;
            default:
                # code...
                break;
        }
        return response()->json(['result' => 'SUCCESS', 'msg' => '操作成功', 'id' => $id]);
    }
    public function deleteTag($id)
    {
        tag::where('id', $id)->update(['valid' => 0]);
        return response()->json(['result' => 'SUCCESS', 'msg' => '删除成功']);
    }
}
