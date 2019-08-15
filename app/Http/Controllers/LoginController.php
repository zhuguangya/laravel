<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
       return view('login');
    }
    public function loginAction()
    {
        $name= Input::get('name');
        $password= Input::get('password');
        // var_dump($name);
        // var_dump($password);
        // die;
        $arr=Db::query("select * from arr where name='$name' and password='$password'");
        if (empty($arr)) {
            $json=['code'=>'1','status'=>'error','data'=>'登入失败'];
            echo json_encode($json);
        }else{
            $json=['code'=>'0','status'=>'ok','data'=>'登入成功'];
            Session::put("name",$name);
            echo json_encode($json);
        }
    }
    public function show()
    {

    }
    public function loginout(Request $request)
    {
      $request->session()->forget('name');
      return view('login');
    }
}
