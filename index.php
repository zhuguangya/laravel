<?php
{
	// "code":200,
	// "status":"success",
	$data=[
		"id"=>1,
		"ttle"=>"一级楼层1",
		"data"=>[
                "gid"=>1,
                "title"=>"二级商品1",
                "data"=>[
                	"tid"=>1,
                	"title"=>"三级商品1",
                ]
				"gid":2,
				"title":"二级商品2",
			
		]
	    "id"=>8,
	    "title"=>"一级楼层2",
	    "data"=>[
	    	    "gid"=>8,
	    	    "title"=>"二级商品3",
	    ]
	]
	
}
$arr=['code'=>200,'status'=>'success','data'=>$data];
echo json_encode($arr);
?>