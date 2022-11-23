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
	<title>我的商品</title>
	
	<link rel="stylesheet" href="/common/bootstrap-4.4.1-dist/css/bootstrap.css">
	
	<script src="/common/bootstrap-4.4.1-dist/js/jquery-3.5.1.min.js"></script>
	<script src="/common/bootstrap-4.4.1-dist/js/bootstrap.js"></script>
	<script type="text/javascript" src="/common/common.js" ></script>
</head>

<script>
	//商品图片回显
	$(document).ready(function(){
		$("#uploadImg").click(function(){
			var $input = $("#file");
			$input.on("change" , function(){
				var files = this.files;
				var length = files.length;

				$.each(files, function(key, value){
					console.log(key);
					var div = document.createElement("div"),
						img = document.createElement("img");
					div.className = "picDiv m-3";
					img.className = "rounded  pic"

					var fr = new FileReader();
					fr.onload = function(){
						img.src=this.result;
						div.appendChild(img);
						$("#images").append(div);
					}
					fr.readAsDataURL(value);
				})
			})
		})
	})
</script>
<style>
	.picDiv {
		width: 150px;
		height: 150px;
		float: left;
	}
	
	.picDiv>.pic {
		width: 100%;
		height: 100%;
	}
	
</style>

<body>
	<header></header>
	
	
	<div class="container">
	<form action="/my_goods/UploadGoods.php" method="post" enctype="multipart/form-data">

		<div class="row mt-3">
			<div class="col">
				<h3><img src="/common/images/店铺.png" alt=""><small class="text-muted">发布商品<small></h3>
			</div>
			
			<div class="col float-right">
				<button class="btn btn-primary">发布</button>
			</div>
		</div>
		
		<div class="row mt-3">
			<div class="col">
				<div class="row">
					<div class="col">
						<div class="form-group">
							<label for="goodsName">商品名称</label>
							<input class="form-control mr-sm-2 " type="text" id="goodsName" name="goodsName">
						</div>
					</div>
					<div class="col">
						<div class="form-group">
							<label for="goodsPrice">商品售价</label>
							<input class="form-control mr-sm-2 " type="text" id="goodsPrice" name="goodsPrice">
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col">
						<div class="form-group">
							<label for="goodsClass">商品类别</label>
							<select class="form-control" id="goodsClass" name="goodsClass">
								<?php
									include_once dirname(__DIR__) . "\common\Database.php";
									class ClassGoods extends Database {
										public $classId;
										public $className;

										function getAllClassGoods() {
											if ($this->open()){
												$class = array();

												$sql = "select class_id, class_name from goods_class";
												$stmt = $this -> conn -> prepare($sql);
												$stmt -> bind_result($this->classId, $this->className); 
												if ($stmt -> execute()) {
													while ($stmt -> fetch()) 
													{
														array_push($class, array($this->classId, $this->className));
													}
													$stmt->free_result();
													$stmt->close();
												}

												$this->foreachClassGoods($class);
											}
										}

										function foreachClassGoods($class) {
											if(!empty($class)) {
												foreach($class as $item){
												   echo "<option value='$item[0]'>$item[1]</option>";
												}
											} 
										}
									}

									$classGoods = new ClassGoods();
									$classGoods->getAllClassGoods();
								?>

							</select>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col">
						<div class="form-group">
							<label for="goodsDescribe">商品描述</label>
							<textarea name="goodsDescribe" id="goodsDescribe" rows="10" class="form-control" ></textarea>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col">
						<div class="mb-2">商品图片</div>
						<div id="uploadImg" class="custom-file">
							<input type="file" name="file[]" multiple id="file" class="custom-file-input">
							<label class="custom-file-label" for="inputGroupFile03">Choose images</label>
						</div>
						
						<div id="images" class="flex-fill"></div>
					</div>
				</div>
			</div>
		</div>
	
	</form>
	</div>
</body>
</html>