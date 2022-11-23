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
	<title>详情页面</title>
	
	<link rel="stylesheet" href="/common/bootstrap-4.4.1-dist/css/bootstrap.css">
	
	<script src="/common/bootstrap-4.4.1-dist/js/jquery-3.5.1.min.js"></script>
	<script src="/common/bootstrap-4.4.1-dist/js/bootstrap.js"></script>
	<script type="text/javascript" src="/common/common.js" ></script>
</head>
<body>
	<header></header>
	
	<a href="/">
		<button type="button" class="btn btn-secondary rounded-circle text-light" style="height: 75px;width: 75px;position:fixed;right: 25px;bottom: 50px;z-index: 99;">返回</button>
	</a>

	<div class="container">
		<div class="row mt-5">
			<div class="col-5">
				<?php
					include_once dirname(__DIR__) . "\common\Database.php";

					class ParticularGoods extends Database {
						public $goodsId;

						public $userId;
						public $goodsName;
						public $goodsDescribe;
						public $goodsPrice;
						public $goodsTime;
						

						function flushInformation() {
							$this->updateInformation();
							
							$this->getParticualGoodsImgs();
							$this->getParticularGoods();
							
						}

						function updateInformation() {
							$this->goodsId = $_GET['goodsId'];
						}

						function getParticularGoods() {
							if ($this->open()){
								$goods = array();
		
								$sql = "select user_id, goods_name, goods_describe, goods_price, goods_time from goods where goods_id = ?";
								$stmt = $this -> conn -> prepare($sql);
								$stmt -> bind_param("i", $this->goodsId);
								$stmt -> bind_result($this->userId, $this->goodsName, $this->goodsDescribe, $this->goodsPrice, $this->goodsTime); 
								if ($stmt -> execute()) {
									while ($stmt -> fetch())
									{
										array_push($goods, 
													array("userId"=>$this->userId, "goodsName"=>$this->goodsName, 
															"goodsDescribe"=>$this->goodsDescribe, "goodsPrice"=>$this->goodsPrice, 
															"goodsTime"=>$this->goodsTime));
									}
									$stmt->free_result();
									$stmt->close();
								}

								$this->showGoodsParticular($goods[0]);
							}
						}

						function showGoodsParticular($goods) {
							if (empty($goods)) {
								echo "不存在该商品";
							}else {
								echo '
								<div class="mt-4">
									<h4>'.$goods['goodsName'].'</h4>
									<h4 class="text-danger">'.$goods['goodsPrice'].'￥</h4>
									<p>'.$goods['goodsDescribe'].'</p>
									<small>发布者：用户编号'.$goods['userId'].'</small>
									<small>发布时间：'.$goods['goodsTime'].'</small>
								</div>
								';
							}
						}

						function getParticualGoodsImgs() {
							$goodsImgUrls = array();
							$tempUrl = "";
							if ($this->open()){
								$sql = "select img_url from goods_img where goods_id= ?";
								$stmt = $this -> conn -> prepare($sql);
								$stmt -> bind_param("i", $this->goodsId);
								$stmt -> bind_result($tempUrl); 
								if ($stmt -> execute()) {
									while ($stmt -> fetch()) 
									{
										array_push($goodsImgUrls, $tempUrl);
									}
									$stmt->free_result();
									$stmt->close();
								}
								$this->showParticualGoodsImgs($goodsImgUrls);
							}
						}

						function showParticualGoodsImgs($goodsImgUrls) {
							if(empty($goodsImgUrls)) {
								echo '
								<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
								<div class="carousel-inner">
									<div class="carousel-item active">
										<img src="/common/images/暂无图片.png" class="d-block w-100" alt="...">
									</div>
									<div class="carousel-item">
										<img src="/common/images/暂无图片.png" class="d-block w-100" alt="...">
									</div>
								</div>
								<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
									<span class="carousel-control-prev-icon" aria-hidden="true"></span>
									<span class="sr-only">Previous</span>
								</a>
								<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
									<span class="carousel-control-next-icon" aria-hidden="true"></span>
									<span class="sr-only">Next</span>
								</a>
								</div>
								';
							}else {
								echo '
								<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
								<div class="carousel-inner">
								';
								$index = 1;
								foreach ($goodsImgUrls as $key=>$val) {
									if($index==1){
										echo '<div class="carousel-item active">';
									}else {
										echo '<div class="carousel-item">';
									}
									echo '
										<img src="/common/upload/'.$val.'" class="d-block w-100" alt="...">
									</div>
									';
									$index+=1;
								}

								echo '
								</div>
								<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
									<span class="carousel-control-prev-icon" aria-hidden="true"></span>
									<span class="sr-only">Previous</span>
								</a>
								<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
									<span class="carousel-control-next-icon" aria-hidden="true"></span>
									<span class="sr-only">Next</span>
								</a>
								</div>
								';
							}
						}

						function getComment() {
							$comments = array();
							$tempUserId = "";
							$tempContent = "";
							$tempCommentTime = "";
							if ($this->open()){
								$sql = "select user_id, content, comment_time from comment where goods_id=? order by comment_id desc";
								$stmt = $this -> conn -> prepare($sql);
								$stmt -> bind_param("i", $this->goodsId);
								$stmt -> bind_result($tempUserId, $tempContent, $tempCommentTime); 
								if ($stmt -> execute()) {
									while ($stmt -> fetch()) 
									{
										array_push($comments, array("user_id"=>$tempUserId, "content"=>$tempContent, "comment_time"=>$tempCommentTime));
									}
									$stmt->free_result();
									$stmt->close();
								}
								$this->showComments($comments);
							}
						}

						function showComments($comments) {
							if (!empty($comments)) {
								foreach($comments as $key=>$val) {
									echo "<div class='m-2'>";
									echo "</p>".$val['comment_time']."</p>";
									echo "<p>用户".$val['user_id']."：".$val['content']."</p><hr>";
									echo "</div>";
								}
							}else {
								echo "<h5 class='p-3'>暂无评论</h5>";
							}
						}
					}


					$particularGoods = new ParticularGoods;
					$particularGoods->flushInformation();

				?>
			</div>
			
			
			
			<div class="col-7" style="height:600px">
				<h3><img src="/common/images/评论.png" alt=""><small class="text-muted">评论<small></h3>

				<div style="height:450px;overflow:auto;" class="bg-light block-center">
					<?php
						$particularGoods->getComment();
					?>
				</div>


				<form action="/particular_goods/Comment.php" method="get" class="mt-3">
					<div class="row">
						<div class="col">
							<input type="text" class="form-control" name="comment">
							<input type="text" name="goods_id" value="<?=$_GET['goodsId']?>" hidden>
						</div>
						<div class="col">
							<button class="btn btn-primary">评论</button>
						</div>
					</div>
				</form>
				
			</div>
			
		</div>
	</div>
	
</body>
</html>