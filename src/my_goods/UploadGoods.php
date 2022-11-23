<?php
include_once dirname(__DIR__) . "\common\Database.php";


class UploadGoods extends Database {
    public $goodsId;
    public $userId;
    public $goodsName;
    public $goodsPrice;
    public $goodsClass;
    public $goodsDescribe;
    public $goodsTime;
    

    public $goodsImgFiles;

    function startUploadGoods() {
        $this->getUploadGoodsInformation();

        $this->checkGoodsInformation();
        $this->checkGoodsImgFiles();

        $this->jump();
    }

    function getUploadGoodsInformation() {
        $this->userId = $_COOKIE['user_id'];
        $this->goodsName = $_POST['goodsName'];
        $this->goodsPrice = $_POST['goodsPrice'];
        $this->goodsClass = $_POST['goodsClass'];
        $this->goodsDescribe = $_POST['goodsDescribe'];
        $this->goodsImgFiles = $_FILES['file'];
        $this->goodsId = time();
        $this->goodsTime = date("Y-m-d h:i:sa", time());
    }

    function checkGoodsInformation() {
        if(!empty($this->userId)) {
            if(empty($this->goodsDescribe)) {
                $this->goodsDescribe = "这个人很懒，没有留下任何关于商品的说明。";
            }
            if(empty($this->goodsName)) {
                $this->goodsName = "商品".$this->goodsId;
            }
            $this->insertGoodsInformation();
        }
    }

    function insertGoodsInformation() {
		if ($this->open()){
            $sql = "insert into goods(goods_id, user_id, goods_name, goods_describe, goods_time, goods_price, class_id) values(?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this -> conn -> prepare($sql);

            $stmt -> bind_param("iisssii", 
                                $this->goodsId, $this->userId, $this->goodsName, 
                                $this->goodsDescribe, $this->goodsTime, $this->goodsPrice, $this->goodsClass);

			if($stmt -> execute())
            {
            }
            $stmt->close();
        }
    }

    function checkGoodsImgFiles() {
        //避免上传时间过长，导致goodsId发生改变
        $goodsId = $this->goodsId;


        $this->getUploadGoodsInformation();
        $isExistNull = empty($this->goodsImgFiles['name'][0]);
        if(!$isExistNull) {
            $imgFiles = $this->uploadGoodsImgFiles();
            $this->insertGoodsImg($imgFiles, $goodsId);
        }
    }

    function uploadGoodsImgFiles() {
        $uploadPath = "../common/upload/";
        $imgFiles = array();

        foreach($this->goodsImgFiles['name'] as $key=>$value) {
            $goodsImg = explode(".", $this->goodsImgFiles["name"][$key]);
            $goodsImgName = md5($goodsImg[0]).time();
            $goodsImgSuffix = $goodsImg[1];
            $goodsImgUrl = $uploadPath.$goodsImgName.'.'.$goodsImgSuffix;

            if (!file_exists($goodsImgUrl)){
                move_uploaded_file($this->goodsImgFiles["tmp_name"][$key], $goodsImgUrl);
            }

            array_push($imgFiles, $goodsImgName.'.'.$goodsImgSuffix);
        }
        return $imgFiles;
    }

    function insertGoodsImg($imgFiles, $goodsId) {
        foreach($imgFiles as $imgFileName) {
            if ($this->open()){
                $sql = "insert into goods_img(goods_id, img_url) values(?, ?)";
                $stmt = $this -> conn -> prepare($sql);
    
                $stmt -> bind_param("is", $goodsId, $imgFileName);
    
                if($stmt -> execute())
                {
                }
                $stmt->close();
            }
        }
    }

    function jump() {
        echo "<script>alert('发布成功。');window.location.replace('/my_goods/')</script>";
    }
}

$uploadGoods = new UploadGoods;
$uploadGoods->startUploadGoods();
?>