<?php
	$isExistUserId = !empty($_COOKIE['user_id']);
	if (!$isExistUserId) {
		illegalOperation();
	}

	function illegalOperation() {
		echo "<script>
				alert('请先登录!');
				window.location.replace('/account/login.html');
			</script>";
	}
?>


<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>个人中心</title>
	
	<link rel="stylesheet" href="../common/bootstrap-4.4.1-dist/css/bootstrap.css">
	
	<script src="../common/bootstrap-4.4.1-dist/js/jquery-3.5.1.min.js"></script>
	<script src="../common/bootstrap-4.4.1-dist/js/bootstrap.js"></script>
	<script type="text/javascript" src="../common/common.js" ></script>
</head>
<body>
	<header></header>
	
	<div class="container">
		<div class="row mt-3">
			<div class="col">
				<h3><img src="/common/images/个人.png" alt=""><small class="text-muted">个人中心<small></h3>
			</div>
		</div>
		
		
		<div class="row  mt-3">
			<div class="offset-4 col-4">
				<div id="user_img" class="float-left">
					<img src="../common/images/小黄鸭.png" alt="" width="210px" height="210px" class="rounded-circle">
				</div>
				
				<div class="float-left">
					<button class="btn btn-light">修改头像</button>
				</div>
			</div>
		</div>
		<hr>
		
		
		<div class="row">
			<div class="col">
				<div class="form-group">
					<label for="userName">用户名</label>
					<input class="form-control mr-sm-2 " type="text" id="userName">
				</div>
			</div>
			
			<div class="col">
				<div class="form-group">
					<label>性别</label><br>
					
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="gender" id="gender1" value="男" checked>
						<label class="form-check-label" for="gender1">男</label>
					</div>
					
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="gender" id="gender2" value="女">
						<label class="form-check-label" for="gender2">女</label>
					</div>
				</div>
			</div>
		</div>
		
		
		<div class="row">
			<div class="col">
				<div class="form-group">
					<label for="address">地址</label>
					<input class="form-control mr-sm-2 " type="text" id="address" name="address">
				</div>
			</div>
			
			<div class="col">
				<div class="form-group">
					<label for="contact">联系方式</label>
					<input class="form-control mr-sm-2 " type="text" id="contact" name="contact">
				</div>
			</div>
		</div>
		
		
		<div class="row mt-5">
			<div class="col">
				<button class="btn btn-primary float-right">保存修改</button>
			</div>
		</div>
	</div>
</body>
</html>