<!DOCTYPE html>
<html>
<head>
	<title>标题</title>
</head>
<body>
	123456
	<div>
		<a href="<?php echo url('login/loginout') ?>">退出</a></div>
			<table border="1" class="table" >
				<thead>
					<tr>
						<th colspan="5">用户表</th>
					</tr>
					<tr>
						<th width="100">ID</th>
						<th width="100">姓名</th>
						<th width="100">密码</th>
						<th width="200" colspan="2">操作</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
	<script src="/php/laravel/blog/public/js/jquery.min.js"></script>
	姓名：<input type="text" name="" id="name">
	密码：<input type="text" name="" id="password">
	<button onclick="add()">提交</button>
	</body>
	<script>
		
		function show() {
			$.ajax({
				url:'<?php echo url("show/show1") ?>',
				dataType:'json',
				success:function (res) {
				   	   	  	 console.log(res)
				   	   	  	 data=res.data
				   	   	  	 var tr=''
				   	   	  	 for (var i = 0; i < data.length; i++) {
				   	   	  	 	tr=tr+"<tr><td>"+data[i].id+"</td><td>"+data[i].name+"</td><td>"+data[i].password+"</td><td><a onclick='delte()'>删除</a></td><td><a onclick='modaldemo()''>修改</a></td></tr>"
				   	   	  	 }
				   	   	  	 $('.table tbody').html(tr)
					         console.log(tr)
					     }
					 })
		}
		show()

		function add(){
			var name=$("#name").val()
			var password=$("#password").val()
			console.log(name)
			console.log(password)
			$.ajax({
				url:'<?php echo url("show/addaction") ?>',
				data:{
					name:name,
					password:password,
				},
				success:function(res){

				}
			})
		}
	</script>
	</html> 