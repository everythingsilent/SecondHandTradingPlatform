<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>二手交易市场</title>
	
	<link rel="stylesheet" href="/common/bootstrap-4.4.1-dist/css/bootstrap.css">
	
	<script src="/common/bootstrap-4.4.1-dist/js/jquery-3.5.1.min.js"></script>
	<script src="/common/bootstrap-4.4.1-dist/js/bootstrap.js"></script>
	<script type="text/javascript" src="/common/common.js" ></script>
</head>
<body>
	<header></header>
	
	
	
	<div class="container">
		<div class="row mt-3">
			<div class="col">
				<h3><img src="/common/images/爱心.png" alt=""><small class="text-muted">猜你喜欢<small></h3>
			</div>
		</div>
		
		
		<div class="row mt-3 flex-fill">
			<?php
				include_once __DIR__ . "\common\Database.php";
				class AllGoods extends Database {
					public $goodsId;
					public $goodsName;
					public $goodsDescribe;
					public $goodsPrice;

					function getAllGoods() {
						if ($this->open()){
							$goods = array();

							$sql = "select goods_id, goods_name, goods_describe, goods_price from goods order by goods_id desc";
							$stmt = $this -> conn -> prepare($sql);
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
							$this->foreachAllGoods($goods);
						}
					}

					function foreachAllGoods($goods) {
						foreach($goods as $key=>$item) {
							$goods_img_url = $this->getMyGoodsImg($item['goodsId']);

							echo "
							<div class='card m-4' style='width: 18rem;'>
								<img class='card-img-top' src='".$goods_img_url."' alt='Card image cap'>
								<div class='card-body'>
									<h5 class='card-title'>".$item['goodsName']."</h5>
									<h5 class='text-danger'>".$item['goodsPrice']."￥</h5>
									<p class='card-text'>".$item['goodsDescribe']."</p>
									
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

				$allGoods = new AllGoods();
				$allGoods->getAllGoods();
			?>
		</div>

	</div>
	
</body>
</html>