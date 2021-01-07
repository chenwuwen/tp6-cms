/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 50720
 Source Host           : localhost:3306
 Source Schema         : rds_mysql_1352xip

 Target Server Type    : MySQL
 Target Server Version : 50720
 File Encoding         : 65001

 Date: 07/01/2021 18:18:43
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for customer_info
-- ----------------------------
DROP TABLE IF EXISTS `customer_info`;
CREATE TABLE `customer_info`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '客户姓名',
  `customer_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '客户地址',
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '电话',
  `contacts` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '联系人',
  `ticket_data` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '开票资料（附件）',
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  `delete_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customer_info
-- ----------------------------

-- ----------------------------
-- Table structure for customer_receive
-- ----------------------------
DROP TABLE IF EXISTS `customer_receive`;
CREATE TABLE `customer_receive`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) NULL DEFAULT NULL COMMENT '客户ID',
  `recipient_company` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '收货单位名称',
  `recipient_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '收货地址',
  `recipient_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '收货电话',
  `recipient` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '收货人',
  `ticket_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '收票地址',
  `ticket_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '收票电话',
  `ticket` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '收票人',
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  `delete_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customer_receive
-- ----------------------------

-- ----------------------------
-- Table structure for order_detail
-- ----------------------------
DROP TABLE IF EXISTS `order_detail`;
CREATE TABLE `order_detail`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '订单编号',
  `receive_info` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '客户信息',
  `product_number` bigint(20) NULL DEFAULT NULL COMMENT '产品编号',
  `product_info` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '产品信息',
  `delete_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of order_detail
-- ----------------------------

-- ----------------------------
-- Table structure for order_info
-- ----------------------------
DROP TABLE IF EXISTS `order_info`;
CREATE TABLE `order_info`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单编号(自动生成)',
  `customer_id` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT '客户id',
  `product_number` json NULL COMMENT '产品编号(多个)',
  `receive_id` bigint(20) NULL DEFAULT NULL COMMENT '收货地址ID',
  `send_date` datetime(0) NULL DEFAULT NULL COMMENT '发货日期',
  `inspection_report` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '检验报告',
  `logistics` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '承运物流',
  `send_number` bigint(11) NULL DEFAULT NULL COMMENT '发货单号',
  `rceceipt_confirm` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '收货确认',
  `rceceipt_date` datetime(0) NULL DEFAULT NULL COMMENT '收货日期',
  `invoice_date` datetime(0) NULL DEFAULT NULL COMMENT '开票日期',
  `invoice_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '发票代码',
  `invoice_number` int(11) NULL DEFAULT NULL COMMENT '发票号码',
  `invoice_follow` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '发票是否随货',
  `express` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '快递公司',
  `express_number` bigint(11) NULL DEFAULT NULL COMMENT '快递单号',
  `ticket_confirm` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '收票确认',
  `acceptance` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '安装验收',
  `recovery_of_balance` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '余款追讨',
  `create_time` datetime(0) NULL DEFAULT NULL,
  `delete_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of order_info
-- ----------------------------

-- ----------------------------
-- Table structure for product_info
-- ----------------------------
DROP TABLE IF EXISTS `product_info`;
CREATE TABLE `product_info`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_number` bigint(255) NULL DEFAULT NULL COMMENT '产品编号',
  `product_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '产品名称',
  `product_model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '型号',
  `product_specs` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '规格',
  `special_request` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '特殊要求',
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  `delete_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product_info
-- ----------------------------

-- ----------------------------
-- Table structure for site_setting
-- ----------------------------
DROP TABLE IF EXISTS `site_setting`;
CREATE TABLE `site_setting`  (
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of site_setting
-- ----------------------------

-- ----------------------------
-- Table structure for sys_permission
-- ----------------------------
DROP TABLE IF EXISTS `sys_permission`;
CREATE TABLE `sys_permission`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '资源名称',
  `type` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '资源类型：folder,menu,button,',
  `url` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '访问url地址',
  `percode` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '权限代码字符串',
  `parentid` bigint(20) NULL DEFAULT NULL COMMENT '父结点id',
  `parentids` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '父结点id列表串',
  `sortstring` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '排序号',
  `available` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '是否可用,1：可用，0不可用',
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_permission
-- ----------------------------
INSERT INTO `sys_permission` VALUES (1, '业务管理', '1', NULL, NULL, 0, NULL, NULL, NULL, 'layui-icon layui-icon-home');
INSERT INTO `sys_permission` VALUES (2, '用户管理', '1', NULL, NULL, 0, NULL, NULL, NULL, 'layui-icon layui-icon-user');
INSERT INTO `sys_permission` VALUES (3, '客户管理', '2', '/admin/customer', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `sys_permission` VALUES (4, '产品管理', '2', '/admin/product', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `sys_permission` VALUES (5, '订单管理', '2', '/admin/order', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `sys_permission` VALUES (6, '管理员管理', '2', '/admin/sysuser', NULL, 2, NULL, NULL, NULL, NULL);
INSERT INTO `sys_permission` VALUES (7, '角色管理', '2', '/admin/role', NULL, 2, NULL, NULL, NULL, NULL);
INSERT INTO `sys_permission` VALUES (8, '设置', '1', NULL, NULL, 0, NULL, NULL, NULL, 'layui-icon layui-icon-set');
INSERT INTO `sys_permission` VALUES (9, '我的设置', '1', NULL, NULL, 8, NULL, NULL, NULL, NULL);
INSERT INTO `sys_permission` VALUES (10, '系统设置', '1', NULL, NULL, 8, NULL, NULL, NULL, NULL);
INSERT INTO `sys_permission` VALUES (11, '网站设置', '2', '/admin/site', NULL, 10, NULL, NULL, NULL, NULL);
INSERT INTO `sys_permission` VALUES (12, '修改密码', '2', '/admin/sysuser/updatePassword', NULL, 9, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for sys_role
-- ----------------------------
DROP TABLE IF EXISTS `sys_role`;
CREATE TABLE `sys_role`  (
  `id` bigint(36) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `describe` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '描述',
  `available` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '是否可用,1：可用，0不可用',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_role
-- ----------------------------
INSERT INTO `sys_role` VALUES (1, '超级管理员', '伟大的超级管理员', NULL, '2020-11-11 15:48:14', '2020-12-07 11:17:18');
INSERT INTO `sys_role` VALUES (2, '管理员', '负责日常业务处理', NULL, '2020-11-11 16:15:36', '2020-11-11 16:15:36');

-- ----------------------------
-- Table structure for sys_role_permission
-- ----------------------------
DROP TABLE IF EXISTS `sys_role_permission`;
CREATE TABLE `sys_role_permission`  (
  `id` bigint(36) NOT NULL AUTO_INCREMENT,
  `sys_role_id` int(32) NOT NULL COMMENT '角色id',
  `sys_permission_id` int(32) NOT NULL COMMENT '权限id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_role_permission
-- ----------------------------
INSERT INTO `sys_role_permission` VALUES (1, 1, 1);
INSERT INTO `sys_role_permission` VALUES (2, 1, 3);
INSERT INTO `sys_role_permission` VALUES (3, 1, 4);
INSERT INTO `sys_role_permission` VALUES (4, 1, 5);
INSERT INTO `sys_role_permission` VALUES (5, 1, 2);
INSERT INTO `sys_role_permission` VALUES (6, 1, 6);
INSERT INTO `sys_role_permission` VALUES (7, 1, 7);
INSERT INTO `sys_role_permission` VALUES (8, 1, 8);
INSERT INTO `sys_role_permission` VALUES (9, 1, 9);
INSERT INTO `sys_role_permission` VALUES (10, 1, 12);
INSERT INTO `sys_role_permission` VALUES (11, 1, 10);
INSERT INTO `sys_role_permission` VALUES (12, 1, 11);
INSERT INTO `sys_role_permission` VALUES (13, 2, 1);
INSERT INTO `sys_role_permission` VALUES (14, 2, 3);
INSERT INTO `sys_role_permission` VALUES (15, 2, 4);
INSERT INTO `sys_role_permission` VALUES (16, 2, 5);

-- ----------------------------
-- Table structure for sys_user
-- ----------------------------
DROP TABLE IF EXISTS `sys_user`;
CREATE TABLE `sys_user`  (
  `id` bigint(36) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_code` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '账号',
  `user_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '姓名',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `salt` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '盐',
  `available` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '账号是否启用，1：启用，0未启用',
  `create_time` timestamp(0) NULL DEFAULT NULL,
  `update_time` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_user
-- ----------------------------
INSERT INTO `sys_user` VALUES (1, 'admin', '看云', '9449314448e7531b31ffa98cac9dce54', '5b6c6fe4598bddec5fea14e23fc7ea8e', '1', '2020-10-27 00:00:00', '2020-11-11 17:56:23');
INSERT INTO `sys_user` VALUES (2, 'hxt2020', 'Miss Hu', '26f900e5086f01680713b9c3ac5aa4b4', 'bf01263cee2cae364a0c9f59ed6d9ca8', '0', '2020-11-11 16:16:50', '2020-11-13 10:43:34');

-- ----------------------------
-- Table structure for sys_user_role
-- ----------------------------
DROP TABLE IF EXISTS `sys_user_role`;
CREATE TABLE `sys_user_role`  (
  `id` bigint(36) NOT NULL AUTO_INCREMENT,
  `sys_user_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sys_role_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_user_role
-- ----------------------------
INSERT INTO `sys_user_role` VALUES (1, '1', '1');
INSERT INTO `sys_user_role` VALUES (2, '2', '2');

SET FOREIGN_KEY_CHECKS = 1;
