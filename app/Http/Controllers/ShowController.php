<?php
namespace App\Http\Controllers;
use Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Rquest;
use Illuminate\Support\Facades\Hash;
class ShowController extends Controller
{   
	public function show()
	{
         return view('show');
	}

    public function show1()
	{   
		$arr=DB::select("select * from goods");
        return response()->json($arr);
	} 

     public function tree(){
         $arr=Db::select("select * from goods_category");
         $ary=$this->show2($arr,0,0);
         $json=['code'=>'200','status'=>'success','data'=>$ary];
         return response()->json($ary); 
    }

    public function show2($arr,$id,$level)
    {   
        $list = array();
        foreach ($arr as $k => $v) {
            if ($v->pid == $id) {
                $v->level=$level;
                $v->son = $this->show2($arr,$v->id,$level+1);
                $list[]=$v;
            }
        }
        return $list;
    }

    public function denglu()
    {
        $arr=Db::select("select * from users");
        return response()->json($arr);
    }

    public function show3()
    {
       $arr=Db::select("select goods.id,goods.name as g_name,goods.price,floor.id,floor.name as f_name,goods_floor.f_id,goods_floor.g_id from goods_floor join floor on goods_floor.f_id=floor.id join goods on goods_floor.g_id=goods.id ");
       $data=[];
       foreach ($arr as $key => $value) {
           // $price=$value->price;
           $data[$value->f_name][]=[$value->g_name,$value->g_id];
           
       }
       return response()->json($data);
    } 
   
	public function addaction()
	{
		$name= Input::get('name');
        $password= Input::get('password');
        	$arr=DB::query("insert into arr(`name`,`password`) values ('$name','password')");
        	$json=['code'=>'0','statua'=>'ok','data'=>'添加成功'];
            echo json_encode($json);
        
	}
    public function shop()
    {    
        $goods_id=request()->post('goods_id');
        // var_dump($goods_id);
        $arr=Db::select("select goods.id as g_id,goods.name as g_name,attribute.name as attr_name ,attr_details.name as d_name, attr_details.id as d_id from goods join goods_attr on goods.id=goods_attr.goods_id join attr_details on goods_attr.attr_details_id=attr_details.id join attribute on goods_attr.attr_id=attribute.id where goods.id='$goods_id'");
        $data=[];
        foreach ($arr as $key => $value) {
            $data[$value->attr_name][]=[$value->d_name,$value->d_id];
        }
        $ary['name']=$value->g_name;
        $ary['data']=$data;
        return response()->json($ary);
    }
    public function product()
    {
        $goods=request()->post();
        $goods_id=$goods['goods_id'];
        $a_id=$goods['id'];
        $a_id=substr($a_id,1);
        $arr=Db::select("select * from commodity where goods_id='$goods_id' and goods_attr_id='$a_id' ");
        return response()->json($arr);

    }
    
}