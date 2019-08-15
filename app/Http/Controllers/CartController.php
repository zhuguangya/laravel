<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
     public function __construct()
    {
       $this->middleware('auth:api', ['except' => ['']]);
        //构造函数，过滤login
    }


    public function insert()
    {

         $name=auth()->user();
         $u_id=$name['id'];
         $goodsp_id=request()->post('goodsp_id');
         $num=request()->post('num');
         $attr_name=request()->post('details');
         var_dump($attr_name);
         $arr1=DB::select("select * from cart where g_id='$goodsp_id'");
         if (empty($arr1)) {
          $arr2=DB::insert("insert into cart (`u_id`,`g_id`,`number`,`attr_name`) values ('$u_id','$goodsp_id','$num','$attr_name')");
         }else{
           $arr=DB::update("update cart set  number='$num' where g_id='$goodsp_id'");
         }
        

      return response()->json([
            'code' => 200,
            'status' => 'ok',
            'data' =>'添加成功' ,
          
        ]);
    }
    public function buycar()
    {
        $name=auth()->user();
        $u_id=$name['id'];
       
        $arr=DB::select("select commodity.goods_id,commodity.price,cart.attr_name,cart.number,cart.g_id,goods.name from cart join commodity on cart.g_id=commodity.id join goods on commodity.goods_id=goods.id where u_id='$u_id'");
        return response()->json($arr);
    }

    public function show()
    {

        return response()->json(auth()->user());
    }

   public function greed()
   {
    $num=request()->post('num');
    var_dump($num);
    $g_id=request()->post('g_id');
    $name=auth()->user();
    $u_id=$name['id'];
    DB::update("update cart set number='$num' where u_id='$u_id' and g_id='$g_id'");
    return response()->json($g_id);
   }

  

}
