# used-goods
#  二手交易平台

## 技术栈


> 前端：Bootstrap AJAX Jquery Html Css JavaScript
>
> 后端：PHP
>
> 数据持久层：MySQL



## 初步产品设计

### 架构图

![二手交易平台架构图V1.1](E:\School\used-goods\doc\二手交易平台架构图V1.1.png)

### 原型图

![image-20221122135505434](C:\Users\BreaKpoint\AppData\Roaming\Typora\typora-user-images\image-20221122135505434.png)

![image-20221122135525764](C:\Users\BreaKpoint\AppData\Roaming\Typora\typora-user-images\image-20221122135525764.png)

![image-20221122135631864](C:\Users\BreaKpoint\AppData\Roaming\Typora\typora-user-images\image-20221122135631864.png)

### 数据库ER图

![ER](E:\School\used-goods\doc\ER.jpg)



## 客户端界面

### 登录

![image-20221122134156031](C:\Users\BreaKpoint\AppData\Roaming\Typora\typora-user-images\image-20221122134156031.png)

### 注册

![image-20221122134212876](C:\Users\BreaKpoint\AppData\Roaming\Typora\typora-user-images\image-20221122134212876.png)

### 首页

![image-20221123234409835](C:\Users\BreaKpoint\AppData\Roaming\Typora\typora-user-images\image-20221123234409835.png)

### 个人中心
![image-20221122133339303](C:\Users\BreaKpoint\AppData\Roaming\Typora\typora-user-images\image-20221122133339303.png)

### 我的商品

![image-20221123234426623](C:\Users\BreaKpoint\AppData\Roaming\Typora\typora-user-images\image-20221123234426623.png)

### 发布

![image-20221123234452828](C:\Users\BreaKpoint\AppData\Roaming\Typora\typora-user-images\image-20221123234452828.png)

![image-20221123234528230](C:\Users\BreaKpoint\AppData\Roaming\Typora\typora-user-images\image-20221123234528230.png)

### 搜索

![image-20221123234555700](C:\Users\BreaKpoint\AppData\Roaming\Typora\typora-user-images\image-20221123234555700.png)

### 商品详情

![image-20221123234628147](C:\Users\BreaKpoint\AppData\Roaming\Typora\typora-user-images\image-20221123234628147.png)

![image-20221123234648937](C:\Users\BreaKpoint\AppData\Roaming\Typora\typora-user-images\image-20221123234648937.png)

## 数据库

### SQL语句

```sql
DROP DATABASE IF EXISTS `usedGoods`;
CREATE DATABASE `usedGoods`;
use usedGoods;


DROP TABLE IF EXISTS `account`;
CREATE TABLE `account`  (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户编号',
  `user_account` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户账号',
  `user_password` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户密码',
  PRIMARY KEY (`user_id`, `user_account`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;


DROP TABLE IF EXISTS `user_center`;
CREATE TABLE `user_center` (
  `user_id` int(11) not NULL COMMENT '用户编号',
  `img_url` varchar(100) COMMENT '头像地址',
  `user_name` varchar(50) COMMENT '用户名',
  `contact` varchar(100) COMMENT '联系方式',
  `address` varchar(100) COMMENT '地址',
  `gender` varchar(50) COMMENT '性别',
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;


DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
  `goods_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品编号',
  `user_id` int(11) NOT NULL COMMENT '用户编号',
  `goods_name` varchar(50) COMMENT '商品名字',
  `goods_describe` varchar(200) COMMENT '商品描述',
  `goods_time` varchar(50) COMMENT '商品发布时间',
  `goods_price` int(11) COMMENT '商品价格',
  `class_id` int(11) COMMENT '分类编号',
  PRIMARY KEY (`goods_id`, `user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;


DROP TABLE IF EXISTS `goods_img`;
CREATE TABLE `goods_img` (
  `img_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品图片编号',
  `goods_id` int(11) NOT NULL COMMENT '商品编号',
  `img_url` varchar(100) COMMENT '商品图片地址',
  PRIMARY KEY (`img_id`, `goods_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;


DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论编号',
  `goods_id` int(11) NOT NULL COMMENT '商品编号',
  `user_id` int(11) not NULL COMMENT '用户编号',
  `content` varchar(100) COMMENT '评论内容',
  `comment_time` varchar(50) COMMENT '评论时间',
  PRIMARY KEY (`comment_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;


DROP TABLE IF EXISTS `goods_class`;
CREATE TABLE `goods_class` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类编号',
  `class_name` varchar(50) COMMENT '分类名',
  PRIMARY KEY (`class_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

```

