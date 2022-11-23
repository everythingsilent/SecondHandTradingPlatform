<?php
include_once dirname(__DIR__) . "\common\Database.php";

class Comment extends Database {
    public $goodsID;
    public $userID;
    public $content;
    public $commentTime;

    function insertComment() {
        $this->getCommentInfomation();

        if ($this->open()){
            $sql = "insert into comment(user_id, goods_id, content, comment_time) values(?, ?, ?, ?)";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bind_param("iiss",$this->userID, $this->goodsID, $this->content, $this->commentTime);
			if($stmt -> execute()) {
				$this->jump();
            }
            $stmt->close();
        }
    }

    function getCommentInfomation() {
        $this->goodsID = $_GET['goods_id'];
        $this->userID = $_COOKIE['user_id'];
        $this->content = $_GET['comment'];
        $this->commentTime = date("Y-m-d h:i:sa", time());
    }

    function jump() {
        // echo "<script>alert('评论成功');history.back();</script>";
        header("location:/particular_goods/?goodsId=".$this->goodsID);
    }
}

$comment = new Comment;
$comment->insertComment();

?>