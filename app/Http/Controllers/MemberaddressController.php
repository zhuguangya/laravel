<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberaddressController extends Controller
{
     public function __construct()
    {
       $this->middleware('auth:api', ['except' => ['']]);
      
    }

    public function memberaddress(Request $request)
    {
     $request=$request->input();
     $p_id=$request['p_id'];
     $arr=DB::select("select * from area where parent_id='$p_id'");
     return response()->json($arr);
    }
 
    public function address(Request $request)
    { 
      $name=auth()->user();
      $u_id=$name['id'];
      $request=$request->input();
      $name=$request['name'];
      $address=$request['address'];
      $phone=$request['phone'];
      $you=$request['you'];
      $iphone=$request['iphone'];
      $email=$request['email'];

      DB::insert ("insert into address (`address`,`phone`,`email`,`code`,`name`,`iphone`,`u_id` ) values ('$address','$phone','$email','$you','$name',' $iphone','$u_id')");
       return response()->json([
            'code' => 200,
            'status' => 'ok',
            'data' =>'添加成功',
        ]);
    }
    public function cartshow()
    {
        $arr=DB::select("select * from address");
         return response()->json($arr);
    }

}
