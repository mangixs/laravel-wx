<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\libraries\classes\FormCheck;
use App\models\admin\slide;
use DB;
use Illuminate\Http\Request;
use App\libraries\classes\search;

class SlideController extends Controller
{
    private $rule = [
        'slide_form' => [
            'title' => ['name' => 'title', 'preg' => ':notnull', 'notice' => '请输入标题!'],
            'type' => ['name' => 'type', 'preg' => ':number', 'notice' => '请选择幻灯片类型!'],
            'url' => ['name' => 'url', 'preg' => ':url', 'notice' => '请输入正确的链接!', 'not_null' => false],
            'is_show' => ['name' => 'is_show', 'preg' => '/^[1|2]{1}$/', 'notice' => '请选择展示位置'],
            'img' => ['name' => 'img', 'preg' => ':notnull', 'notice' => '请上传图片'],
        ],
    ];
    public function index()
    {
        $data['title'] = '广告管理';
        $data['key'] = $this->authKey('slide');
        return view('admin.slide.index', $data);
    }
    public function pageData(Request $request)
    {
        $m=new search;
        $db=DB::table('slide');
        $db->where(['slide.valid'=>1]);
		$m->setSearch($db,$request);
		$data['page']=$m->setPage($db,$request);
        $data['data'] = $db->select('slide.id', 'slide.title', 'slide.img', 'slide.sort', 'slide.update_at', 'slide_type.named as type')
            ->leftJoin('slide_type', 'slide_type.id', '=', 'slide.type')
            ->orderBy('slide.update_at', 'desc')
            ->get();
        foreach ($data['data'] as $key => &$v) {
            $v->update_at = date('Y-m-d H:i:s', $v->update_at);
		}
		return response()->json($data);
    }
    public function add()
    {
        $data['action'] = 'add';
        $data['slideType'] = $this->slideType();
        return view('admin.slide.add', $data);
    }
    public function edit($id, $act)
    {
        $data['data'] = slide::find($id);
        $data['slideType'] = $this->slideType();
        $data['action'] = $act;
        return view('admin.slide.add', $data);
    }
    private function slideType()
    {
        $tmp = DB::table('slide_type')->select('id', 'named')->get();
        return $tmp;
    }
    public function save(Request $request)
    {
        $data['title'] = $request->post('title');
        $data['type'] = $request->post('type');
        $data['url'] = $request->post('url');
        $data['sort'] = $request->post('sort');
        $data['img'] = $request->post('img');
        $data['is_show'] = $request->post('is_show');
        $formObj = new FormCheck($this->rule);
        $checkResult = $formObj->checkFrom($data, 'slide_form');
        if ($checkResult['result'] !== 'CHECK_PASS') {
            return response()->json($checkResult);
        }
        $data['created_at'] = time();
        $action = $request->post('action');
        switch ($action) {
            case 'add':
                $data['update_at'] = $data['created_at'];
                $id = slide::insertGetId($data);
                break;
            case 'edit':
                $id = $request->post('id');
                $data['update_at'] = time();
                slide::where('id', $id)->update($data);
                break;
            default:
                # code...
                break;
        }
        return response()->json(['result' => 'SUCCESS', 'msg' => '保存成功', 'id' => $id]);
    }
    public function deleteSlide($id)
    {
        slide::destroy($id);
        return response()->json(['result' => 'SUCCESS', 'msg' => '删除成功']);
    }
    public function type()
    {
        return view('admin.slide.type');
    }
    public function typeData()
    {
        $data = DB::table('slide_type')->get();
        foreach ($data as $key => $v) {
            $v->insert_at = date('Y-m-d H:i:s', $v->insert_at);
        }
        return response()->json(['result' => 'SUCCESS', 'msg' => '获取成功', 'data' => $data]);
    }
    public function typeSave(Request $request)
    {
        $data['named'] = $request->post('named');
        $data['insert_at'] = time();
        DB::table('slide_type')->insert($data);
        return response()->json(['result' => 'SUCCESS', 'msg' => '添加成功']);
    }
    public function deleteSlideType($id)
    {
        DB::table('slide_type')->where('id', $id)->delete();
        return response()->json(['result' => 'SUCCESS', 'msg' => '删除成功']);
    }
}
