<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\models\user;
use Illuminate\Http\Request;
use App\models\admin\slide;
use App\models\front\nav;
use App\models\front\goods;
use App\models\front\shop;

class HomeController extends Controller
{
    public function banner()
    {
        $data = slide::where('valid', 1)->where('type',2)->select(['id', 'title', 'img as icon'])->get();
        return $this->returnRes($data);
    }
    public function BottomNav()
    {
        $data = nav::where('type_id', 2)->where('valid', 1)->select(['id', 'title', 'url', 'icon'])
            ->orderBy('sort', 'asc')->get();
        return $this->returnRes($data);
    }
    public function MiddleNav()
    {
        $data = nav::where('type_id', 1)->where('valid', 1)->select(['id', 'title', 'url', 'icon'])
            ->orderBy('sort', 'asc')->get();
        return $this->returnRes($data);
    }
    public function homeShopList()
    {
        $data = shop::where(['valid' => 1])->select(['id', 'title', 'shop_image'])->get();
        return $this->returnRes($data);
    }
    public function goodsList(Request $request)
    {
        $page = $request->post('page');
        $offset = ($page - 1) * $this->every;
        $data = goods::where(['goods.valid' => 1])->select(['goods.id', 'goods.title', 'goods.first_img', 'shop.title as shop_title', 'goods.buy_price', 'goods.sale_price', 'goods.sale_num'])
            ->leftJoin('shop', 'goods.shop_id', '=', 'shop.id')
            ->limit($this->every)
            ->offset($offset)
            ->get();
        return $this->returnRes($data);
    }
    public function shopList(Request $request)
    {
        $page = $request->post('page');
        $offset = ($page - 1) * $this->every;
        $data = shop::where(['shop.valid' => 1])->select(['shop.id', 'shop.title', 'shop.shop_image', 'shop_type.title as type'])
            ->leftJoin('shop_type', 'shop.type_id', '=', 'shop_type.id')
            ->limit($this->every)
            ->offset($offset)
            ->get();
        return $this->returnRes($data);
    }
    public function searchGoods(Request $request)
    {
        $searchText = $request->post('searchText');
        $shopId = $request->post('shopId');
        $searchPrice = $request->post('searchPrice');
        $searchTime = $request->post('searchTime');
        $page = $request->post('page');
        $offset = ($page - 1) * $this->every;
        $db = goods::where(['goods.valid' => 1]);
        if (!empty($searchText)) {
            $db->where('goods.title', 'like', '%'.$searchText.'%');
        }
        $db->select(['goods.id', 'goods.title', 'goods.first_img', 'shop.title as shop_title', 'goods.buy_price', 'goods.sale_price', 'goods.sale_num'])
            ->leftJoin('shop', 'goods.shop_id', '=', 'shop.id')
            ->limit($this->every)
            ->offset($offset);
        if (!empty($searchPrice)) {
            if ($searchPrice == 'pricedesc') {
                $db->orderBy('goods.buy_price', 'desc');
            } else {
                $db->orderBy('goods.buy_price', 'asc');
            }
        }
        if (!empty($searchTime)) {
            if($searchTime == 'goodsnew'){
                $db->orderBy('goods.insert_at','desc');
            }else{
                $db->orderBy('goods.insert_at','asc');
            }
        }
        if(is_numeric($shopId)){
            $db->where('shop.id',$shopId);
        }
        $res = $db->get();
        return $this->returnRes($res);
    }
    public function shopDetail(Request $request)
    {
        $id = $request->post('id');
        if(!is_numeric($id)){
            return response()->json(['result'=>'ERROR','msg'=>'参数错误']);
        }
        $ret['shop'] = shop::find($id);
        $ret['goods'] = goods::where(['goods.valid' => 1])
                        ->select(['goods.id', 'goods.title', 'goods.first_img', 'shop.title as shop_title', 'goods.buy_price', 'goods.sale_price', 'goods.sale_num'])
                        ->leftJoin('shop', 'goods.shop_id', '=', 'shop.id')
                        ->where('goods.shop_id',$id)
                        ->get();
        return $this->returnRes($ret);
    }
    public function marketSlide()
    {
        $data = slide::where('valid', 1)->where('type',3)->select(['id', 'title', 'img as icon'])->get();
        return $this->returnRes($data);
    }
}