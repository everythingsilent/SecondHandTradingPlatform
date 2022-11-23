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
<body>
	<header></header>
	
	<a href="/my_goods/sell.php">
		<button type="button" class="btn btn-warning rounded-circle text-light" style="height: 100px;width: 100px;position:fixed;right: 50px;bottom: 50px;z-index: 99;">发布</button>
	</a>
	
	<div class="container">
		<div class="row mt-3">
			<div class="col">
				<h3><img src="/common/images/店铺.png" alt=""><small class="text-muted">我的商品<small></h3>
			</div>
		</div>
		
		<div class="row mt-3 flex-fill">
			<?php
				include_once dirname(__DIR__) . "\common\Database.php";
				class MyGoods extends Database {
					public $userId;
					
					public $goodsId;
					public $goodsName;
					public $goodsDescribe;
					public $goodsPrice;

					function refreshInformation() {
						$this->userId=$_COOKIE['user_id'];

						$this->getMyGoods();
					}

					function getMyGoods() {
						if ($this->open()){
							$goods = array();

							$sql = "select goods_id, goods_name, goods_describe, goods_price from goods where user_id= ? order by goods_id desc";
							$stmt = $this -> conn -> prepare($sql);
							$stmt -> bind_param("i", $this->userId);
							$stmt -> bind_result($this->goodsId, $this->goodsName, $this->goodsDescribe, $this->goodsPrice); 
							if ($stmt -> execute()) {
								while ($stmt -> fetch()) 
								{
									array_push($goods, 
												array("goodsId"=>$this->goodsId, "goodsName"=>$this->goodsName, 
												  	  "goodsDescribe"=>$this->goodsDescribe, "goodsPrice"=>$this->goodsPrice));
								}
								$stmt->free_result();
								$stmt->close();
							}
							$this->foreachMyGoods($goods);
						}
					}

					function foreachMyGoods($goods) {
						foreach($goods as $key=>$item) {
							$goods_img_url = $this->getMyGoodsImg($item['goodsId']);

							echo "
							<div class='card m-4' style='width: 18rem;'>
								<img class='card-img-top' src='".$goods_img_url."' alt='Card image cap'>
								<div class='card-body'>
									<h5 class='card-title'>".$item['goodsName']."</h5>
									<h5 class='text-danger'>".$item['goodsPrice']."￥</h5>
									<p class='card-text'>".$item['goodsDescribe']."</p>
									
									<a href='/my_goods/TackDownGoods.php?goodsId=".$item['goodsId']."' class='btn btn-danger float-right m-1'>下架</a>
									<a href='/particular_goods/?goodsId=".$item['goodsId']."' class='btn btn-primary float-right m-1'>详情</a>
								</div>
							</div>							
							";
						}
					}

					function getMyGoodsImg($goodsId) {
						$goods_img_url = "";
						if ($this->open()){
							$sql = "select img_url from goods_img where goods_id= ? limit 1";
							$stmt = $this -> conn -> prepare($sql);
							$stmt -> bind_param("i", $goodsId);
							$stmt -> bind_result($goods_img_url); 
							if ($stmt -> execute()) {
								while ($stmt -> fetch()) 
								{
								}
								$stmt->free_result();
								$stmt->close();
							}

							if(empty($goods_img_url)) {
								return "/common/images/暂无图片.png";
							}else{
								return "/common/upload/".$goods_img_url;
							}
							
						}
					}
				}

				$myGoods = new MyGoods();
				$myGoods->refreshInformation();

			?>
		</div>
		
	</div>
</body>
</html>