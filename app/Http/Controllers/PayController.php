<?php

namespace App\Http\Controllers;

use Yansongda\Pay\Pay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PayController extends Controller
{   
     public function __construct()
    {
       $this->middleware('auth:api', ['except' => ['return','notify']]);
        //构造函数，过滤login
    }
    protected $config = [
        'alipay' => [
            'app_id' => '2016101000655078',
            'notify_url' => 'http://localhost/php/laravel/blog/public/api/pay/notify',
            'return_url' => 'http://localhost/php/laravel/blog/public/api/pay/return',
            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAgSUwXoSmUcGyGl5nW0WhSf2nBdLgr2fQdcdcOZKl31qBN6Mp06hPDvTy+61HhTB4h7yEnpGxxzO6xKqQudiBHUMyDKoUJXWM5sEV7SMHUv3RUllF7I+2vfywm+TeNpXEkrxbgdHyVtk3voOLvKxwtImC0lQdk084WXus44onjlPLbB37dI+1/rPwTdLPC3ly6JE8XOxdE60+fVzKNcnkUpBoJIKASC0o+GEqhVw2UOstQUqNxDBrzqIQvZVh9IuqczsfZ0pSDbx8lZ15a6/vHFSGS1A8vQU4AjgAx1goAc2ZUufKqrtGSvex8qM+2Nif0YJyTQ9BPtwWhK6HZfVmMwIDAQAB',
            'private_key' => 'MIIEowIBAAKCAQEA0im4vGpUHCa8AUApNibPX6ViYWAD3MAOA1+lSiSt7Crik2RJ/ATxCQVIDXcGk8i0oyBPhuP7XEzVaVfMaWj4UZNe2J8uG/ZTBfGI9JrG5xPXo+uE5BeysFAmJfuSfKIpZ+xTtndXlzjfxenoLRaoaefhzIMEcN+5MH6FPVQnFPkOIaRThAKnalJYSag0xBEwGHGRIC5adlRv+2smGwlmgNdDqLNEz3uwjqPHiZyz37p3Y0g8MGMHF8j0Naqg4aR5EOgyMceSbSVprC/FuntLBnkIPUKFx/ePJ72CRix6S2hWPuid0wtw+8OO3eh0YwMTCcz/u8QBKmpVRgyK9t5rZwIDAQABAoIBAHMTT0kz+3wypW0V4br6A0C/ASCKf3LnYoTsYUg4z1bqoIfOOUiauBSVZL+iteJD2s0bixA0U1VV6OE2pwHs7VNVm3CHsKq09P7jI3e0LEcpMUFbW7e9ViV+rXTMzIgcDwoNeEUIEdkG1li7XFsb9fmPc68U6mCX0AJCtNhA9Olg++Wu6sOAlRc1OtpfzQVYrXdQ7zbbD3viOnluDLSsikYLpfKOQYk0sbxT6JnY8SWlEhx5Oto44lms0MLExUCt52tjZDe9dG14Q56QiEs7+Hc5Lymc9euCeSR7e+jYIldqNOlvmQcTfB8UYdIst09VGzx22zaa6COOUMLhT87QoLkCgYEA8bNN1DhzM919Y5UT/ZbFE/pYJL0znMupOb/bVZ0pyS2kacIKRzv2UHN3jGe9yfMD8W8tFICL8qMZ3eaLRRLrDQDTYKmWWUrMnsvqrjbZBkpsVwd/6ciMQwgvFgZKpadNoGjc/w7eq6ysASvWve/g8WK+dwkCdOloIfZSV8kCoIMCgYEA3pjDts0RE8WZ5NXVIZa1v/2NNb4R/OM/83uy7S+rgHUBuiks1q+iUWymzmCzyEFvAfVPLFBE6MrWv57ycYUYHebXcsdSjwbgW3s+4ukVSl50jx5YierFVGRLTBSX5MCqIL160B724T3EbhTQE825R8zzjk1eQpQvxtMnl+baDE0CgYEAni2kP8D50/WeO++yd4GWVK6/xLt17aVziHHBD1SdpiWStgvhQiFB4ADROjgigunhqL4DmKlP7WlEYm6gsoHhBk+GBnq2BJXpN/toCL+oZG+MW6By3AL9mFjgx98yNxs4uEQobVvD6kJFBzczgHZellrzH1/sFaszFRbpaL4KVBUCgYAPzPA3jZ7ktGYUJEmYtMX59tmLMw670LW9Zs5wn62g1K1mtX2FT7pJ5ViB1cNtN5fVn8Aa+SerDprnxzSWckgf9z7b2uI1XNuYIst39+uW99V2Q0UtpQiU0Pm3UM7nYfWxlUGefFQx8Nx8o+WRQk0gl5/CPiOuvi4WAu8QjUZ1EQKBgC+E3XRWmF4KERUn1opOivqFqdWfjE0eoZeyRahHNVWhmOX5gDMHK+WpOIkAaSGlaJehOEMHCa0zzKyvXYnO7akVEmaLqeBe3cyuEKoFzqefWt92UUd0d/hPn+IExwKAxl2VycDctARWawGZ/nnCNalEQISL3NZz6aKyerDFhy/8',
        ],
    ];

    public function index(Request $request)
    {   
        $order_id=$request->input('id');
        $total_amount=DB::select("select price from orders where order_id='$order_id'");
        $price=0;
        foreach ($total_amount as $key => $value) {
             $price+=$value->price;
        }
        
        $config_biz = [
            'out_trade_no' => $order_id,
            'total_amount' => $price,
            'subject'      => 'test subject',
        ];

        $pay = new Pay($this->config);

        return $pay->driver('alipay')->gateway()->pay($config_biz);
    }

    public function return(Request $request)
    {
        $pay = new Pay($this->config);

        // return $pay->driver('alipay')->gateway()->verify($request->all());
        header("location:http://localhost:8080/#/Buytree");
    }

    public function notify(Request $request)
    {
        $pay = new Pay($this->config);

        if ($pay->driver('alipay')->gateway()->verify($request->all())) {
            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。 
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号； 
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）； 
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）； 
            // 4、验证app_id是否为该商户本身。 
            // 5、其它业务逻辑情况
            file_put_contents(storage_path('notify.txt'), "收到来自支付宝的异步通知\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单号：' . $request->out_trade_no . "\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单金额：' . $request->total_amount . "\r\n\r\n", FILE_APPEND);
        } else {
            file_put_contents(storage_path('notify.txt'), "收到异步通知\r\n", FILE_APPEND);
        }

        echo "success";
    }
}