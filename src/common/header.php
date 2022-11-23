<?php $isSign=!empty($_COOKIE['user_id']);?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">
	<img src="../common/images/商店.png" alt=""> 二手交易市场
  </a>
  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
	<?php
		if($isSign){
			echo 
	'<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
		<li class="nav-item">
			<a class="nav-link" href="/">首页<span class="sr-only">(current)</span></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="/my_goods/">我的商品</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="/user_center/">个人中心<span class="sr-only">(current)</span></a>
		</li>
		<li class="nav-item">
			<a href="/account/SignOut.php" class="nav-link">退出登录</a>
		</li>
	</ul>';
		}else{
			echo
	'<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
		<li class="nav-item active">
			<a href="/account/login.html" class="nav-link">登录</a>
		</li>
	</ul>';
		}
	?>


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
					return $class;
				}
			}
		}

		$classGoods = new ClassGoods();
		$class = $classGoods->getAllClassGoods();
	?>
	<form class="form-inline my-2 my-lg-0" action="/search/ " method="get">
		<select class="form-control mr-2" name="class_id">
		  <option value="0">所有商品</option>
		  <?php
		 	if(!empty($class)) {
				 foreach($class as $item){
					echo "<option value='$item[0]'>$item[1]</option>";
				 }
			 } 
		  ?>
		</select>
		<input class="form-control mr-sm-2" type="search" placeholder="Search" name="key_word">
		<button class="btn btn-outline-success my-2 my-sm-0" type="submit">搜索商品</button>
	</form>
  </div>
</nav>
