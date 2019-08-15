<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartwoController extends Controller
{
     public function __construct()
    {
       $this->middleware('auth:api', ['except' => ['']]);
        //构造函数，过滤login
    }

    public function cartwo(Request $request)
    {
     $request=$request->input();
     $name=auth()->user();
     $u_id=$name['id'];
     $g_id=$request['g_id'];
     $data=[];
     foreach ($g_id as $key => $value) {
        foreach ($value as $key => $value1) {
        $data[]=DB::select("select goods.name,cart.attr_name,cart.number,commodity.price from cart join commodity on cart.g_id=commodity.id join goods on commodity.goods_id=goods.id where cart.u_id='$u_id 'and cart.g_id='$value1'");
        }
     }
        return response()->json($data);
    }

    public function cartwo1()
    {
     $name=auth()->user();
     $u_id=$name['id'];
     $arr=DB::select("select * from address where u_id='$u_id'");
    return response()->json($arr);
    }

   public function addaction(Request $request)
   { 
   	 $request=$request->input();
     $name=auth()->user();
     $u_id=$name['id'];
     $g_id=$request['g_id'];
     $data=[];
     $Ymd=date("Ymd");
     $srand=rand(1000,9999);
     $time=$Ymd.$srand;
     $times=date('Y-m-d h:i:s' , time());
        foreach ($g_id as $key => $value) {
        	foreach ($value as $key1 => $value1) {
        		$data[]=DB::select("select goods.name,cart.attr_name,cart.number,commodity.price,address.address from address join cart on address.u_id=cart.u_id join commodity on cart.g_id=commodity.id join goods on commodity.goods_id=goods.id where cart.u_id='$u_id' and cart.g_id='$value1'");
        	}
        	foreach ($data as $key2 => $value2) {
                  foreach ($data[$key2] as $key3 => $value3) {
                  	$name=$value3->name;
                  	$attr_name=$value3->attr_name;
                  	$number=$value3->number;
                  	$price=$value3->price;
                  	$address=$value3->address;
                  	$status=1;
                  	$tota1=$number*$price;

                  DB::insert("insert into orders (`h_goods`,`h_id`,`address`,`price`,`number`,`order_id`) values ('$name','$attr_name','$address','$tota1','$number','$time')");
                  }
        	}
        }
                  DB::insert("insert into carorder (`order_id`,`time`,`status`) values ('$time','$times','$status')");
                  return response()->json(['code' => 200,'status' => 'ok', 'data' => '添加成功','order_id'=>$time]);
   }
}