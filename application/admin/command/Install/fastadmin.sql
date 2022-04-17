-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2021-12-29 19:15:19
-- 服务器版本： 5.6.50-log
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pay_iexle_com`
--

-- --------------------------------------------------------

--
-- 表的结构 `fa_admin`
--

CREATE TABLE IF NOT EXISTS `fa_admin` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `username` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '用户名',
  `nickname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '昵称',
  `password` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '密码',
  `salt` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '密码盐',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '头像',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '电子邮箱',
  `loginfailure` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '失败次数',
  `logintime` int(10) DEFAULT NULL COMMENT '登录时间',
  `loginip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '登录IP',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',
  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',
  `token` varchar(59) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'Session标识',
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal' COMMENT '状态',
  `cloudkey` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='管理员表';

--
-- 转存表中的数据 `fa_admin`
--

INSERT INTO `fa_admin` (`id`, `username`, `nickname`, `password`, `salt`, `avatar`, `email`, `loginfailure`, `logintime`, `loginip`, `createtime`, `updatetime`, `token`, `status`, `cloudkey`) VALUES
(1, 'admin', '后台管理员', '4b28d45fec15cf9752e00ddeb2d50afa', '37c05f', '/uploads/20211024/ea10a5da175f6d8ce952a3df052e4f56.png', 'admin@admin.com', 0, 1640678424, '27.209.2.227', 1491635035, 1640678424, 'e648bc39-1da4-46c7-b2f2-a10474ea6f61', 'normal', '66666');

-- --------------------------------------------------------

--
-- 表的结构 `fa_admin_log`
--

CREATE TABLE IF NOT EXISTS `fa_admin_log` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `username` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '管理员名字',
  `url` varchar(1500) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '操作页面',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '日志标题',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
  `ip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'IP',
  `useragent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'User-Agent',
  `createtime` int(10) DEFAULT NULL COMMENT '操作时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='管理员日志表';

-- --------------------------------------------------------

--
-- 表的结构 `fa_area`
--

CREATE TABLE IF NOT EXISTS `fa_area` (
  `id` int(10) NOT NULL COMMENT 'ID',
  `pid` int(10) DEFAULT NULL COMMENT '父id',
  `shortname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '简称',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '名称',
  `mergename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '全称',
  `level` tinyint(4) DEFAULT NULL COMMENT '层级 0 1 2 省市区县',
  `pinyin` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '拼音',
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '长途区号',
  `zip` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '邮编',
  `first` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '首字母',
  `lng` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '经度',
  `lat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '纬度'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='地区表';

-- --------------------------------------------------------

--
-- 表的结构 `fa_attachment`
--

CREATE TABLE IF NOT EXISTS `fa_attachment` (
  `id` int(20) unsigned NOT NULL COMMENT 'ID',
  `category` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '类别',
  `admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '物理路径',
  `imagewidth` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '宽度',
  `imageheight` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '高度',
  `imagetype` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '图片类型',
  `imageframes` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '图片帧数',
  `filename` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '文件名称',
  `filesize` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `mimetype` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'mime类型',
  `extparam` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '透传数据',
  `createtime` int(10) DEFAULT NULL COMMENT '创建日期',
  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',
  `uploadtime` int(10) DEFAULT NULL COMMENT '上传时间',
  `storage` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'local' COMMENT '存储位置',
  `sha1` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '文件 sha1编码'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='附件表';

--
-- 转存表中的数据 `fa_attachment`
--

INSERT INTO `fa_attachment` (`id`, `category`, `admin_id`, `user_id`, `url`, `imagewidth`, `imageheight`, `imagetype`, `imageframes`, `filename`, `filesize`, `mimetype`, `extparam`, `createtime`, `updatetime`, `uploadtime`, `storage`, `sha1`) VALUES
(1, '', 1, 0, '/uploads/20211024/ea10a5da175f6d8ce952a3df052e4f56.png', '500', '500', 'png', 0, '1613648623-d02a42d9cb3dec9.png', 109657, 'image/png', '', 1635050756, 1635050756, 1635050756, 'local', 'ab5056a8a9fec620b904d448a21c8de3cf6ac8ff'),
(2, '', 1, 0, '/uploads/20211110/d904cf7e5f6aa82f6aec002a5faa498f.png', '187', '59', 'png', 0, 'logo31.png', 6028, 'image/png', '', 1636540295, 1636540295, 1636540295, 'local', '1c59776654c542017fe7ad57ca9da01ae9a2edf6'),
(3, '', 1, 0, '/uploads/20211128/17267feea01b81465378974acaaa2f27.png', '400', '80', 'png', 0, '易制图生成制作-编号251.png', 16798, 'image/png', '', 1638091460, 1638091460, 1638091460, 'local', '362c79123f77d38567f6beed531e6e455f19dfcd'),
(4, '', 1, 0, '/uploads/20211128/461df033520875b9faaad7a858585432.png', '400', '80', 'png', 0, '(zhaoxi.net).png', 17359, 'image/png', '', 1638091631, 1638091631, 1638091631, 'local', 'd29310b2cd2c4ceffd8d74d9b7c027ffe0f6b021');

-- --------------------------------------------------------

--
-- 表的结构 `fa_auth_group`
--

CREATE TABLE IF NOT EXISTS `fa_auth_group` (
  `id` int(10) unsigned NOT NULL,
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父组别',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '组名',
  `rules` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '规则ID',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',
  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',
  `status` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '状态'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='分组表';

--
-- 转存表中的数据 `fa_auth_group`
--

INSERT INTO `fa_auth_group` (`id`, `pid`, `name`, `rules`, `createtime`, `updatetime`, `status`) VALUES
(1, 0, 'Admin group', '*', 1491635035, 1491635035, 'normal'),
(2, 1, 'Second group', '13,14,16,15,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,40,41,42,43,44,45,46,47,48,49,50,55,56,57,58,59,60,61,62,63,64,65,1,9,10,11,7,6,8,2,4,5', 1491635035, 1491635035, 'normal'),
(3, 2, 'Third group', '1,4,9,10,11,13,14,15,16,17,40,41,42,43,44,45,46,47,48,49,50,55,56,57,58,59,60,61,62,63,64,65,5', 1491635035, 1491635035, 'normal'),
(4, 1, 'Second group 2', '1,4,13,14,15,16,17,55,56,57,58,59,60,61,62,63,64,65', 1491635035, 1491635035, 'normal'),
(5, 2, 'Third group 2', '1,2,6,7,8,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34', 1491635035, 1491635035, 'normal');

-- --------------------------------------------------------

--
-- 表的结构 `fa_auth_group_access`
--

CREATE TABLE IF NOT EXISTS `fa_auth_group_access` (
  `uid` int(10) unsigned NOT NULL COMMENT '会员ID',
  `group_id` int(10) unsigned NOT NULL COMMENT '级别ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='权限分组表';

--
-- 转存表中的数据 `fa_auth_group_access`
--

INSERT INTO `fa_auth_group_access` (`uid`, `group_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `fa_auth_rule`
--

CREATE TABLE IF NOT EXISTS `fa_auth_rule` (
  `id` int(10) unsigned NOT NULL,
  `type` enum('menu','file') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'file' COMMENT 'menu为菜单,file为权限节点',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '规则名称',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '规则名称',
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '图标',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '规则URL',
  `condition` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '条件',
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '备注',
  `ismenu` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为菜单',
  `menutype` enum('addtabs','blank','dialog','ajax') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '菜单类型',
  `extend` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '扩展属性',
  `py` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '拼音首字母',
  `pinyin` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '拼音',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',
  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',
  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',
  `status` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '状态'
) ENGINE=InnoDB AUTO_INCREMENT=243 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='节点表';

--
-- 转存表中的数据 `fa_auth_rule`
--

INSERT INTO `fa_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `url`, `condition`, `remark`, `ismenu`, `menutype`, `extend`, `py`, `pinyin`, `createtime`, `updatetime`, `weigh`, `status`) VALUES
(1, 'file', 0, 'dashboard', '后台首页', 'fa fa-dashboard', '', '', 'Dashboard tips', 1, 'addtabs', '', 'htsy', 'houtaishouye', 1491635035, 1635051774, 143, 'normal'),
(2, 'file', 0, 'general', 'General', 'fa fa-cogs', '', '', '', 1, NULL, '', 'cggl', 'changguiguanli', 1491635035, 1491635035, 137, 'normal'),
(4, 'file', 2, 'addon', '插件管理', 'fa fa-rocket', '', '', 'Addon tips', 1, 'addtabs', '', 'cjgl', 'chajianguanli', 1491635035, 1632142860, 0, 'normal'),
(5, 'file', 0, 'auth', 'Auth', 'fa fa-group', '', '', '', 1, NULL, '', 'qxgl', 'quanxianguanli', 1491635035, 1491635035, 99, 'normal'),
(6, 'file', 2, 'general/config', 'Config', 'fa fa-cog', '', '', 'Config tips', 1, NULL, '', 'xtpz', 'xitongpeizhi', 1491635035, 1491635035, 60, 'normal'),
(7, 'file', 2, 'general/attachment', '附件管理', 'fa fa-file-image-o', '', '', 'Attachment tips', 1, 'addtabs', '', 'fjgl', 'fujianguanli', 1491635035, 1633597109, 53, 'hidden'),
(8, 'file', 2, 'general/profile', 'Profile', 'fa fa-user', '', '', '', 1, NULL, '', 'grzl', 'gerenziliao', 1491635035, 1491635035, 34, 'normal'),
(9, 'file', 5, 'auth/admin', 'Admin', 'fa fa-user', '', '', 'Admin tips', 1, NULL, '', 'glygl', 'guanliyuanguanli', 1491635035, 1491635035, 118, 'normal'),
(11, 'file', 5, 'auth/group', 'Group', 'fa fa-group', '', '', 'Group tips', 1, NULL, '', 'jsz', 'juesezu', 1491635035, 1491635035, 109, 'normal'),
(12, 'file', 5, 'auth/rule', 'Rule', 'fa fa-bars', '', '', 'Rule tips', 1, NULL, '', 'cdgz', 'caidanguize', 1491635035, 1491635035, 104, 'normal'),
(13, 'file', 1, 'dashboard/index', 'View', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 136, 'normal'),
(14, 'file', 1, 'dashboard/add', 'Add', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 135, 'normal'),
(15, 'file', 1, 'dashboard/del', 'Delete', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 133, 'normal'),
(16, 'file', 1, 'dashboard/edit', 'Edit', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 134, 'normal'),
(17, 'file', 1, 'dashboard/multi', 'Multi', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 132, 'normal'),
(18, 'file', 6, 'general/config/index', 'View', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 52, 'normal'),
(19, 'file', 6, 'general/config/add', 'Add', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 51, 'normal'),
(20, 'file', 6, 'general/config/edit', 'Edit', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 50, 'normal'),
(21, 'file', 6, 'general/config/del', 'Delete', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 49, 'normal'),
(22, 'file', 6, 'general/config/multi', 'Multi', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 48, 'normal'),
(23, 'file', 7, 'general/attachment/index', 'View', 'fa fa-circle-o', '', '', 'Attachment tips', 0, NULL, '', '', '', 1491635035, 1491635035, 59, 'normal'),
(24, 'file', 7, 'general/attachment/select', 'Select attachment', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 58, 'normal'),
(25, 'file', 7, 'general/attachment/add', 'Add', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 57, 'normal'),
(26, 'file', 7, 'general/attachment/edit', 'Edit', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 56, 'normal'),
(27, 'file', 7, 'general/attachment/del', 'Delete', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 55, 'normal'),
(28, 'file', 7, 'general/attachment/multi', 'Multi', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 54, 'normal'),
(29, 'file', 8, 'general/profile/index', 'View', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 33, 'normal'),
(30, 'file', 8, 'general/profile/update', 'Update profile', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 32, 'normal'),
(31, 'file', 8, 'general/profile/add', 'Add', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 31, 'normal'),
(32, 'file', 8, 'general/profile/edit', 'Edit', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 30, 'normal'),
(33, 'file', 8, 'general/profile/del', 'Delete', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 29, 'normal'),
(34, 'file', 8, 'general/profile/multi', 'Multi', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 28, 'normal'),
(40, 'file', 9, 'auth/admin/index', 'View', 'fa fa-circle-o', '', '', 'Admin tips', 0, NULL, '', '', '', 1491635035, 1491635035, 117, 'normal'),
(41, 'file', 9, 'auth/admin/add', 'Add', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 116, 'normal'),
(42, 'file', 9, 'auth/admin/edit', 'Edit', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 115, 'normal'),
(43, 'file', 9, 'auth/admin/del', 'Delete', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 114, 'normal'),
(47, 'file', 11, 'auth/group/index', 'View', 'fa fa-circle-o', '', '', 'Group tips', 0, NULL, '', '', '', 1491635035, 1491635035, 108, 'normal'),
(48, 'file', 11, 'auth/group/add', 'Add', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 107, 'normal'),
(49, 'file', 11, 'auth/group/edit', 'Edit', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 106, 'normal'),
(50, 'file', 11, 'auth/group/del', 'Delete', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 105, 'normal'),
(51, 'file', 12, 'auth/rule/index', 'View', 'fa fa-circle-o', '', '', 'Rule tips', 0, NULL, '', '', '', 1491635035, 1491635035, 103, 'normal'),
(52, 'file', 12, 'auth/rule/add', 'Add', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 102, 'normal'),
(53, 'file', 12, 'auth/rule/edit', 'Edit', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 101, 'normal'),
(54, 'file', 12, 'auth/rule/del', 'Delete', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 100, 'normal'),
(55, 'file', 4, 'addon/index', 'View', 'fa fa-circle-o', '', '', 'Addon tips', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(56, 'file', 4, 'addon/add', 'Add', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(57, 'file', 4, 'addon/edit', 'Edit', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(58, 'file', 4, 'addon/del', 'Delete', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(59, 'file', 4, 'addon/downloaded', 'Local addon', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(60, 'file', 4, 'addon/state', 'Update state', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(63, 'file', 4, 'addon/config', 'Setting', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(64, 'file', 4, 'addon/refresh', 'Refresh', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(65, 'file', 4, 'addon/multi', 'Multi', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(66, 'file', 0, 'user', 'User', 'fa fa-user-circle', '', '', '', 1, NULL, '', 'hygl', 'huiyuanguanli', 1491635035, 1491635035, 0, 'normal'),
(67, 'file', 66, 'user/user', '会员管理', 'fa fa-user', '', '', '', 1, 'addtabs', '', 'hygl', 'huiyuanguanli', 1491635035, 1634054955, 0, 'normal'),
(68, 'file', 67, 'user/user/index', 'View', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(69, 'file', 67, 'user/user/edit', 'Edit', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(70, 'file', 67, 'user/user/add', 'Add', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(71, 'file', 67, 'user/user/del', 'Del', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(72, 'file', 67, 'user/user/multi', 'Multi', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(85, 'file', 0, 'command', '在线命令管理', 'fa fa-terminal', '', '', '', 1, 'addtabs', '', 'zxmlgl', 'zaixianminglingguanli', 1630376819, 1638017458, 0, 'hidden'),
(86, 'file', 85, 'command/index', '查看', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'zk', 'zhakan', 1630376819, 1630376819, 0, 'normal'),
(87, 'file', 85, 'command/add', '添加', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'tj', 'tianjia', 1630376819, 1630376819, 0, 'normal'),
(88, 'file', 85, 'command/detail', '详情', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'xq', 'xiangqing', 1630376819, 1630376819, 0, 'normal'),
(89, 'file', 85, 'command/execute', '运行', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'yx', 'yunxing', 1630376819, 1630376819, 0, 'normal'),
(90, 'file', 85, 'command/del', '删除', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'sc', 'shanchu', 1630376819, 1630376819, 0, 'normal'),
(91, 'file', 85, 'command/multi', '批量更新', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'plgx', 'pilianggengxin', 1630376819, 1630376819, 0, 'normal'),
(100, 'file', 66, 'user/moneylog', '余额日志', 'fa fa-money', '', '', '', 1, 'addtabs', '', 'yerz', 'yuerizhi', 1630901300, 1630901346, 0, 'normal'),
(101, 'file', 100, 'user/moneylog/index', '查看', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'zk', 'zhakan', 1630901300, 1630901300, 0, 'normal'),
(102, 'file', 100, 'user/moneylog/add', '添加', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'tj', 'tianjia', 1630901300, 1630901300, 0, 'normal'),
(103, 'file', 100, 'user/moneylog/edit', '修改', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'xg', 'xiugai', 1630901300, 1630901300, 0, 'normal'),
(104, 'file', 100, 'user/moneylog/del', '删除', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'sc', 'shanchu', 1630901300, 1630901300, 0, 'normal'),
(105, 'file', 100, 'user/moneylog/multi', '批量更新', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'plgx', 'pilianggengxin', 1630901300, 1630901300, 0, 'normal'),
(112, 'file', 66, 'vippack', '会员套餐', 'fa fa-vimeo-square', '', '', '', 1, 'addtabs', '', 'hytc', 'huiyuantaocan', 1630901413, 1630901658, 0, 'normal'),
(113, 'file', 112, 'vippack/import', 'Import', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'dr', 'daoru', 1630901413, 1633457546, 0, 'normal'),
(114, 'file', 112, 'vippack/index', '查看', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'zk', 'zhakan', 1630901413, 1633457546, 0, 'normal'),
(115, 'file', 112, 'vippack/add', '添加', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'tj', 'tianjia', 1630901413, 1633457546, 0, 'normal'),
(116, 'file', 112, 'vippack/edit', '编辑', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'bj', 'bianji', 1630901413, 1633457546, 0, 'normal'),
(117, 'file', 112, 'vippack/del', '删除', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'sc', 'shanchu', 1630901413, 1633457546, 0, 'normal'),
(118, 'file', 112, 'vippack/multi', '批量更新', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'plgx', 'pilianggengxin', 1630901413, 1633457546, 0, 'normal'),
(125, 'file', 199, 'risk', '风控记录', 'fa fa-map', '', '', '', 1, 'addtabs', '', 'fkjl', 'fengkongjilu', 1630913325, 1636510350, 0, 'normal'),
(126, 'file', 125, 'risk/import', 'Import', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'dr', 'daoru', 1630913325, 1630913325, 0, 'normal'),
(127, 'file', 125, 'risk/index', '查看', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'zk', 'zhakan', 1630913325, 1630913325, 0, 'normal'),
(128, 'file', 125, 'risk/add', '添加', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'tj', 'tianjia', 1630913325, 1630913325, 0, 'normal'),
(129, 'file', 125, 'risk/edit', '编辑', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'bj', 'bianji', 1630913325, 1630913325, 0, 'normal'),
(130, 'file', 125, 'risk/del', '删除', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'sc', 'shanchu', 1630913325, 1630913325, 0, 'normal'),
(131, 'file', 125, 'risk/multi', '批量更新', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'plgx', 'pilianggengxin', 1630913325, 1630913325, 0, 'normal'),
(132, 'file', 200, 'order', '订单记录', 'fa fa-chrome', '', '', '', 1, 'addtabs', '', 'ddjl', 'dingdanjilu', 1630913325, 1636510420, 0, 'normal'),
(133, 'file', 132, 'order/import', 'Import', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'dr', 'daoru', 1630913325, 1633458803, 0, 'normal'),
(134, 'file', 132, 'order/index', '查看', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'zk', 'zhakan', 1630913325, 1633458803, 0, 'normal'),
(135, 'file', 132, 'order/add', '添加', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'tj', 'tianjia', 1630913325, 1633458803, 0, 'normal'),
(136, 'file', 132, 'order/edit', '编辑', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'bj', 'bianji', 1630913325, 1633458803, 0, 'normal'),
(137, 'file', 132, 'order/del', '删除', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'sc', 'shanchu', 1630913325, 1633458803, 0, 'normal'),
(138, 'file', 132, 'order/multi', '批量更新', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'plgx', 'pilianggengxin', 1630913325, 1633458803, 0, 'normal'),
(139, 'file', 197, 'qrlist', '账号管理', 'fa fa-xing-square', '', '', '', 1, 'addtabs', '', 'zhgl', 'zhanghaoguanli', 1630929963, 1636510027, 0, 'normal'),
(140, 'file', 139, 'qrlist/import', 'Import', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'dr', 'daoru', 1630929963, 1633459371, 0, 'normal'),
(141, 'file', 139, 'qrlist/index', '查看', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'zk', 'zhakan', 1630929963, 1633459371, 0, 'normal'),
(142, 'file', 139, 'qrlist/add', '添加', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'tj', 'tianjia', 1630929963, 1633459371, 0, 'normal'),
(143, 'file', 139, 'qrlist/edit', '编辑', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'bj', 'bianji', 1630929963, 1633459371, 0, 'normal'),
(144, 'file', 139, 'qrlist/del', '删除', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'sc', 'shanchu', 1630929963, 1633459371, 0, 'normal'),
(145, 'file', 139, 'qrlist/multi', '批量更新', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'plgx', 'pilianggengxin', 1630929963, 1633459371, 0, 'normal'),
(152, 'file', 197, 'wxemp', '店员列表', 'fa fa-wechat', '', '', '', 1, 'addtabs', '', 'dylb', 'dianyuanliebiao', 1632033584, 1636510100, 0, 'normal'),
(153, 'file', 152, 'wxemp/import', 'Import', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'dr', 'daoru', 1632033584, 1632033584, 0, 'normal'),
(154, 'file', 152, 'wxemp/index', '查看', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'zk', 'zhakan', 1632033584, 1632033584, 0, 'normal'),
(155, 'file', 152, 'wxemp/add', '添加', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'tj', 'tianjia', 1632033584, 1632033584, 0, 'normal'),
(156, 'file', 152, 'wxemp/edit', '编辑', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'bj', 'bianji', 1632033584, 1632033584, 0, 'normal'),
(157, 'file', 152, 'wxemp/del', '删除', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'sc', 'shanchu', 1632033584, 1632033584, 0, 'normal'),
(158, 'file', 152, 'wxemp/multi', '批量更新', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'plgx', 'pilianggengxin', 1632033584, 1632033584, 0, 'normal'),
(159, 'file', 200, 'recharge_order', '充值管理', 'fa fa-yen', '', '', '', 1, 'addtabs', '', 'czgl', 'chongzhiguanli', 1632113616, 1636510432, 0, 'normal'),
(160, 'file', 159, 'recharge_order/import', 'Import', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'dr', 'daoru', 1632113616, 1632113616, 0, 'normal'),
(161, 'file', 159, 'recharge_order/index', '查看', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'zk', 'zhakan', 1632113616, 1632113616, 0, 'normal'),
(162, 'file', 159, 'recharge_order/add', '添加', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'tj', 'tianjia', 1632113616, 1632113616, 0, 'normal'),
(163, 'file', 159, 'recharge_order/edit', '编辑', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'bj', 'bianji', 1632113616, 1632113616, 0, 'normal'),
(164, 'file', 159, 'recharge_order/del', '删除', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'sc', 'shanchu', 1632113616, 1632113616, 0, 'normal'),
(165, 'file', 159, 'recharge_order/multi', '批量更新', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'plgx', 'pilianggengxin', 1632113616, 1632113616, 0, 'normal'),
(169, 'file', 2, 'yuanpay', '支付配置', 'fa fa-firefox', '', '', '', 1, 'addtabs', '', 'zfpz', 'zhifupeizhi', 1636171906, 1636174317, 0, 'normal'),
(170, 'file', 169, 'yuanpay/import', 'Import', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'dr', 'daoru', 1636171906, 1636171906, 0, 'normal'),
(171, 'file', 169, 'yuanpay/index', '查看', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'zk', 'zhakan', 1636171906, 1636171906, 0, 'normal'),
(172, 'file', 169, 'yuanpay/add', '添加', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'tj', 'tianjia', 1636171906, 1636171906, 0, 'normal'),
(173, 'file', 169, 'yuanpay/edit', '编辑', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'bj', 'bianji', 1636171906, 1636171906, 0, 'normal'),
(174, 'file', 169, 'yuanpay/del', '删除', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'sc', 'shanchu', 1636171906, 1636171906, 0, 'normal'),
(175, 'file', 169, 'yuanpay/multi', '批量更新', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'plgx', 'pilianggengxin', 1636171906, 1636171906, 0, 'normal'),
(176, 'file', 2, 'yuanlogin', '快捷登录', 'fa fa-qq', '', '', '', 1, 'addtabs', '', 'kjdl', 'kuaijiedenglu', 1636477971, 1637842553, 0, 'hidden'),
(177, 'file', 176, 'yuanlogin/import', 'Import', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'dr', 'daoru', 1636477971, 1636477971, 0, 'normal'),
(178, 'file', 176, 'yuanlogin/index', '查看', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'zk', 'zhakan', 1636477971, 1636477971, 0, 'normal'),
(179, 'file', 176, 'yuanlogin/add', '添加', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'tj', 'tianjia', 1636477971, 1636477971, 0, 'normal'),
(180, 'file', 176, 'yuanlogin/edit', '编辑', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'bj', 'bianji', 1636477971, 1636477971, 0, 'normal'),
(181, 'file', 176, 'yuanlogin/del', '删除', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'sc', 'shanchu', 1636477971, 1636477971, 0, 'normal'),
(182, 'file', 176, 'yuanlogin/multi', '批量更新', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'plgx', 'pilianggengxin', 1636477971, 1636477971, 0, 'normal'),
(183, 'file', 197, 'channel', '通道列表', 'fa fa-google-wallet', '', '', '', 1, 'addtabs', '', 'tdlb', 'tongdaoliebiao', 1636478898, 1636510019, 0, 'normal'),
(184, 'file', 183, 'channel/import', 'Import', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'dr', 'daoru', 1636478898, 1636478898, 0, 'normal'),
(185, 'file', 183, 'channel/index', '查看', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'zk', 'zhakan', 1636478898, 1636478898, 0, 'normal'),
(186, 'file', 183, 'channel/add', '添加', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'tj', 'tianjia', 1636478898, 1636478898, 0, 'normal'),
(187, 'file', 183, 'channel/edit', '编辑', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'bj', 'bianji', 1636478898, 1636478898, 0, 'normal'),
(188, 'file', 183, 'channel/del', '删除', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'sc', 'shanchu', 1636478898, 1636478898, 0, 'normal'),
(189, 'file', 183, 'channel/multi', '批量更新', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'plgx', 'pilianggengxin', 1636478898, 1636478898, 0, 'normal'),
(197, 'file', 0, 'tongdao', '通道管理', 'fa fa-buysellads', '', '', '', 1, 'addtabs', '', 'tdgl', 'tongdaoguanli', 1636510003, 1636510003, 0, 'normal'),
(198, 'file', 0, 'gonggao', '公告管理', 'fa fa-volume-up', '', '', '', 0, 'addtabs', '', 'gggl', 'gonggaoguanli', 1636510272, 1638016752, 0, 'normal'),
(199, 'file', 0, 'anquan', '安全管理', 'fa fa-cog', '', '', '', 1, 'addtabs', '', 'aqgl', 'anquanguanli', 1636510338, 1636510338, 0, 'normal'),
(200, 'file', 0, 'caiwu', '财务管理', 'fa fa-pie-chart', '', '', '', 1, 'addtabs', '', 'cwgl', 'caiwuguanli', 1636510408, 1636510408, 0, 'normal'),
(202, 'file', 0, 'templates', '模板管理', 'fa fa-window-restore', '', '', '', 1, NULL, '', 'mbgl', 'mubanguanli', 1636689045, 1636689045, 0, 'normal'),
(203, 'file', 202, 'templates/templates', '模板列表', 'fa fa-window-restore', '', '', '', 1, NULL, '', 'mblb', 'mubanliebiao', 1636689045, 1636689045, 0, 'normal'),
(204, 'file', 203, 'templates/templates/index', '模板列表', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'mblb', 'mubanliebiao', 1636689045, 1636689045, 0, 'normal'),
(205, 'file', 203, 'templates/templates/add', '创建模板', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'cjmb', 'chuangjianmuban', 1636689045, 1636689045, 0, 'normal'),
(206, 'file', 203, 'templates/templates/edit', '使用模板', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'symb', 'shiyongmuban', 1636689045, 1636689045, 0, 'normal'),
(207, 'file', 203, 'templates/templates/reset', '重置模板', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'zzmb', 'zhongzhimuban', 1636689045, 1636689045, 0, 'normal'),
(208, 'file', 203, 'templates/templates/del', '删除模板', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'scmb', 'shanchumuban', 1636689045, 1636689045, 0, 'normal'),
(209, 'file', 203, 'templates/templates/package', '模板打包', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'mbdb', 'mubandabao', 1636689045, 1636689045, 0, 'normal'),
(210, 'file', 203, 'templates/templates/local', '上传安装模板', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'scazmb', 'shangchuananzhuangmuban', 1636689045, 1636689045, 0, 'normal'),
(211, 'file', 203, 'templates/templates/config', '模板配置', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'mbpz', 'mubanpeizhi', 1636689045, 1636689045, 0, 'normal'),
(212, 'file', 203, 'templates/templates/addconfig', '添加模板配置', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'tjmbpz', 'tianjiamubanpeizhi', 1636689045, 1636689045, 0, 'normal'),
(213, 'file', 203, 'templates/templates/langs', '多语言管理', 'fa fa-language', '', '', '', 0, NULL, '', 'dyygl', 'duoyuyanguanli', 1636689045, 1636689045, 0, 'normal'),
(214, 'file', 203, 'templates/templates/langsadd', '多语言添加', 'fa fa-plus', '', '', '', 0, NULL, '', 'dyytj', 'duoyuyantianjia', 1636689045, 1636689045, 0, 'normal'),
(215, 'file', 203, 'templates/templates/langsedit', '多语言修改', 'fa fa-plus', '', '', '', 0, NULL, '', 'dyyxg', 'duoyuyanxiugai', 1636689045, 1636689045, 0, 'normal'),
(216, 'file', 0, 'superadsmenu', '公告管理', 'fa fa-file-text-o', '', '', '常用于管理广告图片', 1, 'addtabs', '', 'gggl', 'gonggaoguanli', 1638016501, 1638016791, 0, 'normal'),
(217, 'file', 216, 'superads', '广告管理', 'fa fa-list', '', '', '', 1, NULL, '', 'gggl', 'guanggaoguanli', 1638016501, 1638016501, 0, 'normal'),
(218, 'file', 217, 'superads/index', '查看', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'zk', 'zhakan', 1638016501, 1638016501, 0, 'normal'),
(219, 'file', 217, 'superads/showhelp', '使用帮助', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'sybz', 'shiyongbangzhu', 1638016501, 1638016501, 0, 'normal'),
(220, 'file', 217, 'superads/add', '添加', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'tj', 'tianjia', 1638016501, 1638016501, 0, 'normal'),
(221, 'file', 217, 'superads/edit', '编辑', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'bj', 'bianji', 1638016501, 1638016501, 0, 'normal'),
(222, 'file', 217, 'superads/del', '删除', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'sc', 'shanchu', 1638016501, 1638016501, 0, 'normal'),
(223, 'file', 216, 'superads_publist', '公告管理', 'fa fa-list', '', '', '', 1, NULL, '', 'gggl', 'gonggaoguanli', 1638016501, 1638016501, 0, 'normal'),
(224, 'file', 223, 'superads_publist/index', '查看', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'zk', 'zhakan', 1638016501, 1638016501, 0, 'normal'),
(225, 'file', 223, 'superads_publist/add', '添加', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'tj', 'tianjia', 1638016501, 1638016501, 0, 'normal'),
(226, 'file', 223, 'superads_publist/edit', '编辑', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'bj', 'bianji', 1638016501, 1638016501, 0, 'normal'),
(227, 'file', 223, 'superads_publist/del', '删除', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'sc', 'shanchu', 1638016501, 1638016501, 0, 'normal'),
(228, 'file', 66, 'message', '通知管理', 'fa fa-bullhorn', '', '', '常用于管理站内通知消息，支持个体消息和系统消息', 1, 'addtabs', '', 'tzgl', 'tongzhiguanli', 1638016955, 1638017028, 0, 'normal'),
(229, 'file', 228, 'message/index', '查看', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'zk', 'zhakan', 1638016955, 1638016955, 0, 'normal'),
(230, 'file', 228, 'message/add', '添加', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'tj', 'tianjia', 1638016955, 1638016955, 0, 'normal'),
(231, 'file', 228, 'message/edit', '修改', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'xg', 'xiugai', 1638016955, 1638016955, 0, 'normal'),
(232, 'file', 228, 'message/del', '删除', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'sc', 'shanchu', 1638016955, 1638016955, 0, 'normal'),
(233, 'file', 228, 'message/multi', '批量更新', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'plgx', 'pilianggengxin', 1638016955, 1638016955, 0, 'normal'),
(234, 'file', 66, 'user/withdraw', '提现管理', 'fa fa-money', '', '', '', 1, 'addtabs', '', 'txgl', 'tixianguanli', 1638017169, 1638017212, 0, 'normal'),
(235, 'file', 234, 'user/withdraw/index', '查看', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'zk', 'zhakan', 1638017169, 1638017169, 0, 'normal'),
(236, 'file', 234, 'user/withdraw/add', '添加', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'tj', 'tianjia', 1638017169, 1638017169, 0, 'normal'),
(237, 'file', 234, 'user/withdraw/edit', '修改', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'xg', 'xiugai', 1638017169, 1638017169, 0, 'normal'),
(238, 'file', 234, 'user/withdraw/del', '删除', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'sc', 'shanchu', 1638017169, 1638017169, 0, 'normal'),
(239, 'file', 234, 'user/withdraw/multi', '批量更新', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'plgx', 'pilianggengxin', 1638017169, 1638017169, 0, 'normal'),
(240, 'file', 0, 'third', '第三方登录管理', 'fa fa-users', '', '', '', 1, NULL, '', 'dsfdlgl', 'disanfangdengluguanli', 1638112089, 1638112089, 0, 'normal'),
(241, 'file', 240, 'third/index', '查看', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'zk', 'zhakan', 1638112090, 1638112090, 0, 'normal'),
(242, 'file', 240, 'third/del', '删除', 'fa fa-circle-o', '', '', '', 0, NULL, '', 'sc', 'shanchu', 1638112090, 1638112090, 0, 'normal');

-- --------------------------------------------------------

--
-- 表的结构 `fa_category`
--

CREATE TABLE IF NOT EXISTS `fa_category` (
  `id` int(10) unsigned NOT NULL,
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '栏目类型',
  `name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `nickname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `flag` set('hot','index','recommend') COLLATE utf8mb4_unicode_ci DEFAULT '',
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '图片',
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '关键字',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '描述',
  `diyname` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '自定义名称',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',
  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',
  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',
  `status` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '状态'
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='分类表';

--
-- 转存表中的数据 `fa_category`
--

INSERT INTO `fa_category` (`id`, `pid`, `type`, `name`, `nickname`, `flag`, `image`, `keywords`, `description`, `diyname`, `createtime`, `updatetime`, `weigh`, `status`) VALUES
(1, 0, 'page', '官方新闻', 'news', 'recommend', '/assets/img/qrcode.png', '', '', 'news', 1491635035, 1491635035, 1, 'normal'),
(2, 0, 'page', '移动应用', 'mobileapp', 'hot', '/assets/img/qrcode.png', '', '', 'mobileapp', 1491635035, 1491635035, 2, 'normal'),
(3, 2, 'page', '微信公众号', 'wechatpublic', 'index', '/assets/img/qrcode.png', '', '', 'wechatpublic', 1491635035, 1491635035, 3, 'normal'),
(4, 2, 'page', 'Android开发', 'android', 'recommend', '/assets/img/qrcode.png', '', '', 'android', 1491635035, 1491635035, 4, 'normal'),
(5, 0, 'page', '软件产品', 'software', 'recommend', '/assets/img/qrcode.png', '', '', 'software', 1491635035, 1491635035, 5, 'normal'),
(6, 5, 'page', '网站建站', 'website', 'recommend', '/assets/img/qrcode.png', '', '', 'website', 1491635035, 1491635035, 6, 'normal'),
(7, 5, 'page', '企业管理软件', 'company', 'index', '/assets/img/qrcode.png', '', '', 'company', 1491635035, 1491635035, 7, 'normal'),
(8, 6, 'page', 'PC端', 'website-pc', 'recommend', '/assets/img/qrcode.png', '', '', 'website-pc', 1491635035, 1491635035, 8, 'normal'),
(9, 6, 'page', '移动端', 'website-mobile', 'recommend', '/assets/img/qrcode.png', '', '', 'website-mobile', 1491635035, 1491635035, 9, 'normal'),
(10, 7, 'page', 'CRM系统 ', 'company-crm', 'recommend', '/assets/img/qrcode.png', '', '', 'company-crm', 1491635035, 1491635035, 10, 'normal'),
(11, 7, 'page', 'SASS平台软件', 'company-sass', 'recommend', '/assets/img/qrcode.png', '', '', 'company-sass', 1491635035, 1491635035, 11, 'normal'),
(12, 0, 'test', '测试1', 'test1', 'recommend', '/assets/img/qrcode.png', '', '', 'test1', 1491635035, 1491635035, 12, 'normal'),
(13, 0, 'test', '测试2', 'test2', 'recommend', '/assets/img/qrcode.png', '', '', 'test2', 1491635035, 1491635035, 13, 'normal');

-- --------------------------------------------------------

--
-- 表的结构 `fa_channel`
--

CREATE TABLE IF NOT EXISTS `fa_channel` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `name` varchar(50) NOT NULL COMMENT '通道名称',
  `type` varchar(50) NOT NULL COMMENT '通道类型',
  `weigh` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `remark` varchar(50) NOT NULL COMMENT '备注',
  `is_hot` int(11) NOT NULL DEFAULT '0' COMMENT '热门',
  `creat_time` int(11) NOT NULL COMMENT '创建时间',
  `status` int(11) NOT NULL COMMENT '状态',
  `code` varchar(50) NOT NULL COMMENT '通道标识',
  `max_account` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `fa_channel`
--

INSERT INTO `fa_channel` (`id`, `name`, `type`, `weigh`, `remark`, `is_hot`, `creat_time`, `status`, `code`, `max_account`) VALUES
(1, '本地免挂', 'alipay', 2, '本地免挂，备注订单号免输入金额', 0, 1636478903, 1, 'alipay_mg', 3),
(3, 'APP监控', 'alipay', 3, '需使用手机或者云手机监控', 0, 1636486192, 1, 'alipay_app', 1),
(4, '店员免挂', 'wxpay', 5, '店员需要挂机，店长添加店员的微信', 0, 1636486248, 1, 'wxpay_dy', 1),
(5, '云端免挂', 'wxpay', 5, '云端挂机，免输入金额，备注订单号回调', 0, 1636486267, 1, 'wxpay_cloud', 3),
(6, 'APP监控', 'wxpay', 5, '需使用手机或者云手机监控', 0, 1636486294, 1, 'wxpay_app', 1),
(7, 'PC云监控', 'alipay', 4, '配合旺旺,实现掉线重登,软件自动心跳', 0, 1636486345, 0, 'alipay_cloud', 1),
(8, 'QQ免挂', 'qqpay', 10, 'QQ免挂通道', 0, 1636486345, 1, 'qqpay_mg', 1),
(9, '个人免挂', 'alipay', 1, '支付宝免挂', 0, 1636486345, 0, 'alipay_grmg', 1);

-- --------------------------------------------------------

--
-- 表的结构 `fa_command`
--

CREATE TABLE IF NOT EXISTS `fa_command` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '类型',
  `params` varchar(1500) NOT NULL DEFAULT '' COMMENT '参数',
  `command` varchar(1500) NOT NULL DEFAULT '' COMMENT '命令',
  `content` text COMMENT '返回结果',
  `executetime` int(10) unsigned DEFAULT NULL COMMENT '执行时间',
  `createtime` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  `updatetime` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
  `status` enum('successed','failured') NOT NULL DEFAULT 'failured' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='在线命令表';

-- --------------------------------------------------------

--
-- 表的结构 `fa_config`
--

CREATE TABLE IF NOT EXISTS `fa_config` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '变量名',
  `group` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '分组',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '变量标题',
  `tip` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '变量描述',
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '类型:string,text,int,bool,array,datetime,date,file',
  `value` text COLLATE utf8mb4_unicode_ci COMMENT '变量值',
  `content` text COLLATE utf8mb4_unicode_ci COMMENT '变量字典数据',
  `rule` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '验证规则',
  `extend` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '扩展属性',
  `setting` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '配置'
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='系统配置';

--
-- 转存表中的数据 `fa_config`
--

INSERT INTO `fa_config` (`id`, `name`, `group`, `title`, `tip`, `type`, `value`, `content`, `rule`, `extend`, `setting`) VALUES
(1, 'name', 'basic', 'Site name', '请填写站点名称', 'string', '源支付', '', 'required', '', NULL),
(2, 'beian', 'basic', 'Beian', '粤ICP备15000000号-1', 'string', '', '', '', '', NULL),
(3, 'cdnurl', 'basic', 'Cdn url', '如果全站静态资源使用第三方云储存请配置该值', 'string', '', '', '', '', NULL),
(4, 'version', 'basic', 'Version', '如果静态资源有变动请重新配置该值', 'string', '3.0.34', '', 'required', '', NULL),
(5, 'timezone', 'basic', 'Timezone', '', 'string', 'Asia/Shanghai', '', 'required', '', NULL),
(8, 'fixedpage', 'basic', 'Fixed page', '请尽量输入左侧菜单栏存在的链接', 'string', 'dashboard', '', 'required', '', NULL),
(9, 'categorytype', 'dictionary', 'Category type', '', 'array', '[]', '', '', '', NULL),
(10, 'configgroup', 'dictionary', 'Config group', '', 'array', '{"basic":"基础配置","email":"邮件配置","pay":"支付配置"}', '', '', '', NULL),
(11, 'mail_type', 'email', 'Mail type', '选择邮件发送方式', 'select', '1', '["请选择","SMTP"]', '', '', NULL),
(12, 'mail_smtp_host', 'email', 'Mail smtp host', '错误的配置发送邮件会导致服务器超时', 'string', 'smtp.qq.com', '', '', '', NULL),
(13, 'mail_smtp_port', 'email', 'Mail smtp port', '(不加密默认25,SSL默认465,TLS默认587)', 'string', '465', '', '', '', NULL),
(14, 'mail_smtp_user', 'email', 'Mail smtp user', '（填写完整用户名）', 'string', '', '', '', '', NULL),
(15, 'mail_smtp_pass', 'email', 'Mail smtp password', '（填写您的密码或授权码）', 'string', '', '', '', '', NULL),
(16, 'mail_verify_type', 'email', 'Mail vertify type', '（SMTP验证方式[推荐SSL]）', 'select', '2', '["无","TLS","SSL"]', '', '', NULL),
(17, 'mail_from', 'email', 'Mail from', '', 'string', '', '', '', '', NULL),
(18, 'attachmentcategory', 'dictionary', 'Attachment category', '', 'array', '[]', '', '', '', NULL),
(19, 'title', 'basic', '网站标题', '', 'string', '码支付', '', '', '', '{"table":"","conditions":"","key":"","value":""}'),
(20, 'keywords', 'basic', '关键字', '', 'string', '码支付', '', '', '', '{"table":"","conditions":"","key":"","value":""}'),
(22, 'pay_maxmoney', 'pay', '最大支付金额', '', 'string', '1000', '', '', '', '{"table":"","conditions":"","key":"","value":""}'),
(23, 'pay_minmoney', 'pay', '最小支付金额', '', 'string', '0.01', '', '', '', '{"table":"","conditions":"","key":"","value":""}'),
(24, 'blockname', 'pay', '屏蔽关键字', '', 'text', '百度云|摆渡|云盘|点券|芸盘|萝莉|罗莉|网盘|黑号|q币|Q币|扣币|qq货币|QQ货币|花呗|baidu云|bd云|吃鸡|透视|自瞄|后座|穿墙|脚本|外挂|辅助|检测|武器|套装', '', '', '', '{"table":"","conditions":"","key":"","value":""}'),
(25, 'blockalert', 'pay', '屏蔽提示内容', '', 'string', '温馨提醒该商品禁止出售，如有疑问请联系网站客服！', '', '', '', '{"table":"","conditions":"","key":"","value":""}'),
(30, 'cloud_key', 'pay', '软件通讯密钥', '', 'string', 'kale', '', '', '', '{"table":"","conditions":"","key":"","value":""}'),
(38, 'logo', 'basic', '网站LOGO', '', 'image', '/uploads/20211128/461df033520875b9faaad7a858585432.png', '', '', '', '{"table":"","conditions":"","key":"","value":""}'),
(42, 'app_down', 'pay', 'APP下载地址', '', 'string', '', '', '', '', '{"table":"","conditions":"","key":"","value":""}'),
(44, 'reg_type', 'pay', '验证码类型', '修改后需清理缓存', 'radio', 'text', '{"text":"普通验证","email":"邮箱验证","mobile":"手机验证"}', '', '', '{"table":"","conditions":"","key":"","value":""}'),
(45, 'sitenav', 'basic', '首页导航', '', 'array', '{"插件下载":"/index/index/work.html","开发文档":"https://easydoc.net/doc/95137535/oyLJ2AHp/1K77TFiR","支付测试":"/index/index/test.html","公告中心":"/index/news/index.html","管理中心":"/index/user/index.html"}', '{"value1":"title1","value2":"title2"}', '', '', '{"table":"","conditions":"","key":"导航名称","value":"导航链接"}');

-- --------------------------------------------------------

--
-- 表的结构 `fa_ems`
--

CREATE TABLE IF NOT EXISTS `fa_ems` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `event` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '事件',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '邮箱',
  `code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '验证码',
  `times` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '验证次数',
  `ip` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'IP',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='邮箱验证码表';

-- --------------------------------------------------------

--
-- 表的结构 `fa_message_notice`
--

CREATE TABLE IF NOT EXISTS `fa_message_notice` (
  `message_id` int(11) NOT NULL COMMENT 'ID',
  `message_type` enum('system','user') NOT NULL DEFAULT 'system' COMMENT '消息类型',
  `message_title` varchar(255) DEFAULT NULL COMMENT '消息标题',
  `message_content` text NOT NULL COMMENT '消息内容',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',
  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='站内消息表';

-- --------------------------------------------------------

--
-- 表的结构 `fa_message_user`
--

CREATE TABLE IF NOT EXISTS `fa_message_user` (
  `rec_id` int(11) NOT NULL COMMENT 'ID',
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `message_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '消息id',
  `is_see` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否查看：0未查看, 1已查看',
  `deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户假删除标识,1:删除,0未删除',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',
  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户的消息表';

-- --------------------------------------------------------

--
-- 表的结构 `fa_news`
--

CREATE TABLE IF NOT EXISTS `fa_news` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `weigh` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `name` varchar(255) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `creat_time` int(11) NOT NULL COMMENT '发布时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `fa_order`
--

CREATE TABLE IF NOT EXISTS `fa_order` (
  `id` bigint(11) NOT NULL COMMENT 'ID',
  `trade_no` varchar(50) NOT NULL DEFAULT '' COMMENT '本地单号',
  `out_trade_no` varchar(50) NOT NULL DEFAULT '' COMMENT '商户单号',
  `notify_url` varchar(500) NOT NULL DEFAULT '' COMMENT '异步通知地址',
  `return_url` varchar(500) NOT NULL DEFAULT '' COMMENT '同步通知地址',
  `typedata` enum('alipay','wxpay','qqpay') NOT NULL DEFAULT 'alipay' COMMENT '支付类型:alipay=支付宝,wxpay=微信,qqpay=钱包',
  `user_id` bigint(11) NOT NULL DEFAULT '0' COMMENT '商户ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '商品名称',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `truemoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实付金额',
  `qr_id` bigint(11) NOT NULL DEFAULT '0' COMMENT '通道ID',
  `ip` varchar(50) NOT NULL DEFAULT '' COMMENT '访问IP',
  `createtime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '支付时间',
  `out_time` int(11) NOT NULL DEFAULT '0' COMMENT '有效时限',
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '状态:0=未支付,1=已支付',
  `api_memo` text NOT NULL,
  `sitename` varchar(50) NOT NULL,
  `qrcode` text NOT NULL COMMENT '二维码信息',
  `h5_qrurl` varchar(2500) NOT NULL,
  `yuantype` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单记录';

-- --------------------------------------------------------

--
-- 表的结构 `fa_qrlist`
--

CREATE TABLE IF NOT EXISTS `fa_qrlist` (
  `id` bigint(11) NOT NULL COMMENT 'ID',
  `code` varchar(50) NOT NULL COMMENT '通道标识',
  `user_id` bigint(11) NOT NULL DEFAULT '0' COMMENT '商户ID',
  `type` enum('alipay','wxpay','qqpay') NOT NULL DEFAULT 'alipay' COMMENT '通道类型:alipay=支付宝,wxpay=微信,qqpay=钱包',
  `qr_url` varchar(5000) NOT NULL DEFAULT '' COMMENT '二维码地址',
  `wx_name` varchar(50) NOT NULL DEFAULT '' COMMENT '微信昵称',
  `money` varchar(50) NOT NULL DEFAULT '' COMMENT '已收款金额',
  `succ_ordercount` int(11) NOT NULL DEFAULT '0' COMMENT '已收款数',
  `cookie` text NOT NULL COMMENT '登录Cookie',
  `createtime` bigint(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` bigint(11) NOT NULL DEFAULT '0' COMMENT '监控时间',
  `end_time` bigint(11) NOT NULL DEFAULT '0' COMMENT '失效时间',
  `zfb_pid` varchar(50) NOT NULL COMMENT '支付宝PID',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  `diaoxian_notity` int(11) NOT NULL DEFAULT '0' COMMENT '掉线通知状态',
  `memo` varchar(50) NOT NULL DEFAULT '' COMMENT '备注',
  `day_maxmoney` int(11) NOT NULL DEFAULT '0' COMMENT '日收款上限',
  `all_maxmoney` int(11) NOT NULL DEFAULT '0' COMMENT '总收款上限',
  `is_status` int(11) NOT NULL DEFAULT '1' COMMENT '是否启用',
  `is_cloud` int(11) NOT NULL DEFAULT '0' COMMENT '云端守护',
  `cloud_wxid` varchar(50) NOT NULL,
  `cloud_server_code` varchar(50) NOT NULL COMMENT '云端服务器标识',
  `cloud_server_name` varchar(50) DEFAULT NULL COMMENT '云端服务器名称',
  `qq` varchar(50) NOT NULL,
  `num` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='二维码列表';

-- --------------------------------------------------------

--
-- 表的结构 `fa_recharge_order`
--

CREATE TABLE IF NOT EXISTS `fa_recharge_order` (
  `id` int(10) unsigned NOT NULL COMMENT '主键ID',
  `orderid` varchar(100) DEFAULT NULL COMMENT '订单ID',
  `user_id` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `amount` double(10,2) unsigned DEFAULT '0.00' COMMENT '订单金额',
  `payamount` double(10,2) unsigned DEFAULT '0.00' COMMENT '支付金额',
  `paytype` varchar(50) DEFAULT NULL COMMENT '支付类型',
  `paytime` int(10) DEFAULT NULL COMMENT '支付时间',
  `ip` varchar(50) DEFAULT NULL COMMENT 'IP地址',
  `useragent` varchar(255) DEFAULT NULL COMMENT 'UserAgent',
  `memo` varchar(255) DEFAULT NULL COMMENT '备注',
  `createtime` int(10) DEFAULT NULL COMMENT '添加时间',
  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',
  `status` enum('created','paid','expired') DEFAULT 'created' COMMENT '状态'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='充值表';

--
-- 转存表中的数据 `fa_recharge_order`
--

INSERT INTO `fa_recharge_order` (`id`, `orderid`, `user_id`, `amount`, `payamount`, `paytype`, `paytime`, `ip`, `useragent`, `memo`, `createtime`, `updatetime`, `status`) VALUES
(1, '20211227092209000010012509', 1001, 30.00, 0.00, 'wxpay', NULL, '38.17.50.7', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36', NULL, 1640611329, NULL, 'created'),
(2, '20211228054228000010006014', 1000, 10.00, 0.00, 'alipay', NULL, '14.146.251.125', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', NULL, 1640684548, NULL, 'created');

-- --------------------------------------------------------

--
-- 表的结构 `fa_risk`
--

CREATE TABLE IF NOT EXISTS `fa_risk` (
  `id` bigint(11) NOT NULL COMMENT 'ID',
  `user_id` bigint(11) NOT NULL DEFAULT '0' COMMENT '商户ID',
  `urltext` varchar(255) NOT NULL DEFAULT '' COMMENT '来源地址',
  `contenttext` varchar(200) NOT NULL DEFAULT '' COMMENT '风控内容',
  `createtime` bigint(11) NOT NULL DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='风控记录';

-- --------------------------------------------------------

--
-- 表的结构 `fa_sms`
--

CREATE TABLE IF NOT EXISTS `fa_sms` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `event` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '事件',
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '手机号',
  `code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '验证码',
  `times` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '验证次数',
  `ip` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'IP',
  `createtime` int(10) unsigned DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='短信验证码表';

-- --------------------------------------------------------

--
-- 表的结构 `fa_superads`
--

CREATE TABLE IF NOT EXISTS `fa_superads` (
  `id` int(10) NOT NULL COMMENT 'ID',
  `adsname` varchar(50) NOT NULL DEFAULT '' COMMENT '广告名称',
  `adstag` varchar(50) NOT NULL DEFAULT '' COMMENT '广告标记',
  `adswidth` int(10) NOT NULL DEFAULT '0' COMMENT '广告宽度',
  `adsheight` int(10) NOT NULL DEFAULT '0' COMMENT '广告高度',
  `typedata` enum('1','2','3') NOT NULL DEFAULT '1' COMMENT '类型:1=单图,2=多图,3=代码',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',
  `memo` varchar(100) DEFAULT '' COMMENT '备注',
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '状态:1=启用,0=未启用'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告表';

-- --------------------------------------------------------

--
-- 表的结构 `fa_superads_images`
--

CREATE TABLE IF NOT EXISTS `fa_superads_images` (
  `id` int(10) NOT NULL COMMENT 'ID',
  `imgtitle` varchar(300) NOT NULL DEFAULT '' COMMENT '广告标题',
  `superads_id` int(10) NOT NULL DEFAULT '0' COMMENT '广告表ID',
  `isforeverdata` enum('1','0') NOT NULL DEFAULT '1' COMMENT '时间:1=永久生效,0=设定时间内生效',
  `clickhref` varchar(200) DEFAULT '' COMMENT '点击地址',
  `adscontent` text COMMENT '广告文本内容',
  `adsimage` varchar(500) DEFAULT '' COMMENT '广告图片',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',
  `livestime` int(10) DEFAULT NULL COMMENT '生效开始时间',
  `liveetime` int(10) DEFAULT NULL COMMENT '生效结束时间',
  `memo` varchar(100) DEFAULT '' COMMENT '备注',
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '状态:1=启用,0=未启用'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告内容表';

-- --------------------------------------------------------

--
-- 表的结构 `fa_superads_publist`
--

CREATE TABLE IF NOT EXISTS `fa_superads_publist` (
  `id` int(10) NOT NULL COMMENT 'ID',
  `pubtitle` varchar(300) NOT NULL DEFAULT '' COMMENT '公告标题',
  `pubtag` varchar(30) NOT NULL DEFAULT '' COMMENT '公告标签',
  `publicontent` text COMMENT '公告内容',
  `pubimage` varchar(500) DEFAULT '' COMMENT '公告图片',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',
  `isforeverdata` enum('1','0') NOT NULL DEFAULT '1' COMMENT '时间:1=永久生效,0=设定时间内生效',
  `livestime` int(10) DEFAULT NULL COMMENT '生效开始时间',
  `liveetime` int(10) DEFAULT NULL COMMENT '生效结束时间',
  `memo` varchar(100) DEFAULT '' COMMENT '备注',
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '状态:1=启用,0=未启用'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公告内容表';

-- --------------------------------------------------------

--
-- 表的结构 `fa_test`
--

CREATE TABLE IF NOT EXISTS `fa_test` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `admin_id` int(10) DEFAULT '0' COMMENT '管理员ID',
  `category_id` int(10) unsigned DEFAULT '0' COMMENT '分类ID(单选)',
  `category_ids` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '分类ID(多选)',
  `week` enum('monday','tuesday','wednesday') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '星期(单选):monday=星期一,tuesday=星期二,wednesday=星期三',
  `flag` set('hot','index','recommend') COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '标志(多选):hot=热门,index=首页,recommend=推荐',
  `genderdata` enum('male','female') COLLATE utf8mb4_unicode_ci DEFAULT 'male' COMMENT '性别(单选):male=男,female=女',
  `hobbydata` set('music','reading','swimming') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '爱好(多选):music=音乐,reading=读书,swimming=游泳',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '标题',
  `content` text COLLATE utf8mb4_unicode_ci COMMENT '内容',
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '图片',
  `images` varchar(1500) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '图片组',
  `attachfile` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '附件',
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '关键字',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '描述',
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '省市',
  `json` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '配置:key=名称,value=值',
  `price` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '价格',
  `views` int(10) unsigned DEFAULT '0' COMMENT '点击',
  `startdate` date DEFAULT NULL COMMENT '开始日期',
  `activitytime` datetime DEFAULT NULL COMMENT '活动时间(datetime)',
  `year` year(4) DEFAULT NULL COMMENT '年',
  `times` time DEFAULT NULL COMMENT '时间',
  `refreshtime` int(10) DEFAULT NULL COMMENT '刷新时间(int)',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',
  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',
  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',
  `weigh` int(10) DEFAULT '0' COMMENT '权重',
  `switch` tinyint(1) DEFAULT '0' COMMENT '开关',
  `status` enum('normal','hidden') COLLATE utf8mb4_unicode_ci DEFAULT 'normal' COMMENT '状态',
  `state` enum('0','1','2') COLLATE utf8mb4_unicode_ci DEFAULT '1' COMMENT '状态值:0=禁用,1=正常,2=推荐'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='测试表';

-- --------------------------------------------------------

--
-- 表的结构 `fa_third`
--

CREATE TABLE IF NOT EXISTS `fa_third` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `user_id` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `platform` varchar(30) CHARACTER SET utf8 DEFAULT '' COMMENT '第三方应用',
  `apptype` varchar(50) CHARACTER SET utf8 DEFAULT '' COMMENT '应用类型',
  `unionid` varchar(100) CHARACTER SET utf8 DEFAULT '' COMMENT '第三方UNIONID',
  `openname` varchar(100) NOT NULL DEFAULT '' COMMENT '第三方会员昵称',
  `openid` varchar(100) CHARACTER SET utf8 DEFAULT '' COMMENT '第三方OPENID',
  `access_token` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT 'AccessToken',
  `refresh_token` varchar(255) CHARACTER SET utf8 DEFAULT 'RefreshToken',
  `expires_in` int(10) unsigned DEFAULT '0' COMMENT '有效期',
  `createtime` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  `updatetime` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
  `logintime` int(10) unsigned DEFAULT NULL COMMENT '登录时间',
  `expiretime` int(10) unsigned DEFAULT NULL COMMENT '过期时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='第三方登录表';

-- --------------------------------------------------------

--
-- 表的结构 `fa_user`
--

CREATE TABLE IF NOT EXISTS `fa_user` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '组别ID',
  `username` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '用户名',
  `nickname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '昵称',
  `password` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '密码',
  `salt` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '密码盐',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '电子邮箱',
  `mobile` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '手机号',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '头像',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '等级',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `bio` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '格言',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `score` int(10) NOT NULL DEFAULT '0' COMMENT '积分',
  `successions` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '连续登录天数',
  `maxsuccessions` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '最大连续登录天数',
  `prevtime` int(10) DEFAULT NULL COMMENT '上次登录时间',
  `logintime` int(10) DEFAULT NULL COMMENT '登录时间',
  `loginip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '登录IP',
  `loginfailure` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '失败次数',
  `joinip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '加入IP',
  `jointime` int(10) DEFAULT NULL COMMENT '加入时间',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',
  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',
  `token` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'Token',
  `status` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '状态',
  `verification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '验证',
  `user_key` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alipay_time` int(11) NOT NULL,
  `wxpay_time` int(11) NOT NULL,
  `order_out_time` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lixian_notity` int(11) NOT NULL DEFAULT '1',
  `yuyin_notity` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alipay_feilv` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wxpay_feilv` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `console_notity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '收银台提示信息',
  `pay_temp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'console' COMMENT '收银台模板',
  `is_login_email` int(11) NOT NULL DEFAULT '0' COMMENT '登录邮件提醒',
  `min_money_tx` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `qqpay_time` int(11) NOT NULL,
  `qqpay_feilv` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_other` int(11) NOT NULL DEFAULT '0' COMMENT '是否开启其他支付方式'
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='会员表';

-- --------------------------------------------------------

--
-- 表的结构 `fa_user_group`
--

CREATE TABLE IF NOT EXISTS `fa_user_group` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '组名',
  `rules` text COLLATE utf8mb4_unicode_ci COMMENT '权限节点',
  `createtime` int(10) DEFAULT NULL COMMENT '添加时间',
  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',
  `status` enum('normal','hidden') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '状态'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='会员组表';

--
-- 转存表中的数据 `fa_user_group`
--

INSERT INTO `fa_user_group` (`id`, `name`, `rules`, `createtime`, `updatetime`, `status`) VALUES
(1, '默认组', '1,3,5,100,101,6,13,15,14,16,17,18,19,8,32,99,37,36,35,34,33,30,31,7,28,29,26,27,24,25,22,23,20,21,2', 1515386468, 1634053907, 'normal');

-- --------------------------------------------------------

--
-- 表的结构 `fa_user_money_log`
--

CREATE TABLE IF NOT EXISTS `fa_user_money_log` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '变更余额',
  `before` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '变更前余额',
  `after` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '变更后余额',
  `memo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '备注',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='会员余额变动表';

-- --------------------------------------------------------

--
-- 表的结构 `fa_user_rule`
--

CREATE TABLE IF NOT EXISTS `fa_user_rule` (
  `id` int(10) unsigned NOT NULL,
  `pid` int(10) DEFAULT NULL COMMENT '父ID',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '名称',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '标题',
  `remark` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `ismenu` tinyint(1) DEFAULT NULL COMMENT '是否菜单',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',
  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',
  `weigh` int(10) DEFAULT '0' COMMENT '权重',
  `status` enum('normal','hidden') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '状态',
  `icon` char(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fa fa-circle-o' COMMENT '图标',
  `condition` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '条件',
  `type` enum('menu','file') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'file' COMMENT 'menu为菜单,file为权限节点'
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='会员规则表';

--
-- 转存表中的数据 `fa_user_rule`
--

INSERT INTO `fa_user_rule` (`id`, `pid`, `name`, `title`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `icon`, `condition`, `type`) VALUES
(1, 0, 'dashboard', 'Dashboard', 'Dashboard tips', 1, 1516168079, 1516168079, 99, 'normal', 'fa fa-dashboard', '', 'file'),
(2, 0, 'api', 'API接口', '', 1, 1516168062, 1634053614, 2, 'normal', '', '', 'file'),
(3, 1, 'dashboard/index', 'View', '', 0, 1515386247, 1634054222, 5, 'normal', 'fa fa-circle-o', '', 'file'),
(4, 2, 'api/user', '会员模块', '', 1, 1515386221, 1537758859, 11, 'hidden', '', '', 'file'),
(5, 0, 'user', 'User center', '', 1, 1515386262, 1516015236, 7, 'normal', 'fa fa-users', '', 'file'),
(6, 5, 'user/secure', '安全管理', '', 1, 1516015012, 1516015012, 10, 'normal', 'fa fa-shield', '', 'file'),
(7, 5, 'user/rich', '财富管理', '', 1, 1541045799, 1541052272, 9, 'normal', 'fa fa-money', '', 'file'),
(8, 5, 'user/general', '常规管理', '', 1, 1541045799, 1541052272, 9, 'normal', 'fa fa-cogs', '', 'file'),
(9, 4, 'api/user/login', '登录', '', 0, 1515386247, 1537758859, 6, 'hidden', '', '', 'file'),
(10, 4, 'api/user/register', '注册', '', 0, 1515386262, 1537758859, 8, 'hidden', '', '', 'file'),
(11, 4, 'api/user/index', '会员中心', '', 0, 1516015012, 1634053609, 10, 'normal', '', '', 'file'),
(12, 4, 'api/user/profile', '个人资料', '', 0, 1516015012, 1634053600, 3, 'normal', '', '', 'file'),
(13, 6, 'user/profile', 'Profile', '', 1, 1516015012, 1516015012, 10, 'normal', 'fa fa-user-o', '', 'file'),
(14, 13, 'user/profile/index', 'View', '', 1, 1516015012, 1634053506, 4, 'normal', 'fa fa-circle-o', '', 'file'),
(15, 13, 'user/profile/edit', 'Edit', '', 1, 1516015012, 1634053507, 4, 'normal', 'fa fa-circle-o', '', 'file'),
(16, 6, 'user/changepwd', 'Change password', '', 1, 1541045799, 1541056067, 8, 'normal', 'fa fa-key', '', 'file'),
(17, 16, 'user/changepwd/index', 'View', '', 0, 1541045799, 1541045799, 0, 'normal', 'fa fa-circle-o', '', 'file'),
(18, 6, 'user/log', '用户日志', '', 1, 1516015012, 1541043105, 7, 'normal', 'fa fa-file-text-o', '', 'file'),
(19, 18, 'user/log/index', 'View', '', 0, 1516015012, 1537758859, 3, 'normal', 'fa fa-circle-o', '', 'file'),
(20, 7, 'user/scorelog', '积分日志', '', 1, 1541045799, 1541050931, 0, 'normal', 'fa fa-file-text-o', '', 'file'),
(21, 20, 'user/scorelog/index', 'View', '', 0, 1541045799, 1541050931, 0, 'normal', 'fa fa-circle-o', '', 'file'),
(22, 7, 'user/recharge', '充值余额', '', 1, 1541045799, 1541050931, 0, 'normal', 'fa fa-cny', '', 'file'),
(23, 22, 'user/recharge/index', 'View', '', 0, 1541045799, 1541045799, 8, 'normal', 'fa fa-circle-o', '', 'file'),
(24, 0, 'user/moneylog', '余额日志', '', 1, 1541045799, 1634054092, 0, 'normal', 'fa fa-file-text-o', '', 'file'),
(25, 24, 'user/moneylog/index', 'View', '', 0, 1516015012, 1541043105, 7, 'normal', 'fa fa-circle-o', '', 'file'),
(26, 7, 'user/withdraw', '余额提现', '', 1, 1541045799, 1541050931, 0, 'normal', 'fa fa-cny', '', 'file'),
(27, 26, 'user/withdraw/index', 'View', '', 0, 1541045799, 1541045799, 8, 'normal', 'fa fa-circle-o', '', 'file'),
(28, 7, 'user/withdrawlog', '提现日志', '', 1, 1541045799, 1541050931, 0, 'normal', 'fa fa-file-text-o', '', 'file'),
(29, 28, 'user/withdrawlog/index', 'View', '', 0, 1516015012, 1541043105, 7, 'normal', 'fa fa-circle-o', '', 'file'),
(30, 8, 'user/invite', '邀请好友', '', 1, 1541045799, 1541050931, 0, 'normal', 'fa fa-users', '', 'file'),
(31, 30, 'user/invite/index', 'View', '', 0, 1516015012, 1541043105, 7, 'normal', 'fa fa-circle-o', '', 'file'),
(32, 8, 'general/attachment', '附件管理', '', 1, 1541045799, 1541050931, 0, 'normal', 'fa fa-file-image-o', '', 'file'),
(33, 32, 'general/attachment/index', 'View', '', 0, 1516015012, 1541043105, 7, 'normal', 'fa fa-circle-o', '', 'file'),
(34, 32, 'general/attachment/add', 'Add', '', 0, 1516015012, 1541043105, 7, 'normal', 'fa fa-circle-o', '', 'file'),
(35, 32, 'general/attachment/edit', 'Edit', '', 0, 1516015012, 1541043105, 7, 'normal', 'fa fa-circle-o', '', 'file'),
(36, 32, 'general/attachment/del', 'Del', '', 0, 1516015012, 1541043105, 7, 'normal', 'fa fa-circle-o', '', 'file'),
(37, 32, 'general/attachment/select', 'Select', '', 0, 1516015012, 1541043105, 7, 'normal', 'fa fa-circle-o', '', 'file'),
(99, 32, 'general/attachment/multi', 'Multi', '', 0, 1516015012, 1541043105, 7, 'normal', 'fa fa-circle-o', '', 'file'),
(100, 5, 'pay', '云端管理', '', 1, 1631170502, 1631170571, 100, 'normal', 'fa fa-circle-o', '', 'file'),
(101, 100, 'qrmanage', '二维码管理', '', 1, 1631170633, 1631170633, 101, 'normal', 'fa fa-circle-o', '', 'file');

-- --------------------------------------------------------

--
-- 表的结构 `fa_user_score_log`
--

CREATE TABLE IF NOT EXISTS `fa_user_score_log` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `score` int(10) NOT NULL DEFAULT '0' COMMENT '变更积分',
  `before` int(10) NOT NULL DEFAULT '0' COMMENT '变更前积分',
  `after` int(10) NOT NULL DEFAULT '0' COMMENT '变更后积分',
  `memo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '备注',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='会员积分变动表';

-- --------------------------------------------------------

--
-- 表的结构 `fa_user_token`
--

CREATE TABLE IF NOT EXISTS `fa_user_token` (
  `token` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Token',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',
  `expiretime` int(10) DEFAULT NULL COMMENT '过期时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='会员Token表';

-- --------------------------------------------------------

--
-- 表的结构 `fa_version`
--

CREATE TABLE IF NOT EXISTS `fa_version` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `oldversion` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '旧版本号',
  `newversion` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '新版本号',
  `packagesize` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '包大小',
  `content` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '升级内容',
  `downloadurl` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '下载地址',
  `enforce` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '强制更新',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',
  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',
  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',
  `status` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='版本表';

-- --------------------------------------------------------

--
-- 表的结构 `fa_vippack`
--

CREATE TABLE IF NOT EXISTS `fa_vippack` (
  `id` bigint(11) NOT NULL COMMENT 'ID',
  `vip_nametext` varchar(200) NOT NULL DEFAULT '' COMMENT '套餐名称',
  `vip_type` enum('alipay','wxpay','qqpay') NOT NULL DEFAULT 'alipay' COMMENT '套餐类型:alipay=支付宝,wxpay=微信,qqpay=钱包',
  `taocans` text NOT NULL COMMENT '套餐配置',
  `vip_feilvtext` varchar(10) NOT NULL DEFAULT '' COMMENT '套餐费率',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '状态:0=关闭,1=启用',
  `weigh` bigint(11) NOT NULL DEFAULT '0' COMMENT '排序'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='会员套餐';

--
-- 转存表中的数据 `fa_vippack`
--

INSERT INTO `fa_vippack` (`id`, `vip_nametext`, `vip_type`, `taocans`, `vip_feilvtext`, `create_time`, `status`, `weigh`) VALUES
(1, '支付宝套餐管理', 'alipay', '[]', '0', 1632744359, '1', 1),
(2, '微信套餐管理', 'wxpay', '[]', '0', 1633456212, '1', 2),
(3, '钱包套餐管理', 'qqpay', '[]', '0', 1633456212, '1', 3);

-- --------------------------------------------------------

--
-- 表的结构 `fa_withdraw`
--

CREATE TABLE IF NOT EXISTS `fa_withdraw` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT '0' COMMENT '会员ID',
  `money` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '金额',
  `handingfee` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '手续费',
  `taxes` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '税费',
  `type` varchar(50) DEFAULT '' COMMENT '类型',
  `account` varchar(100) DEFAULT '' COMMENT '提现账户',
  `name` varchar(100) DEFAULT '' COMMENT '真实姓名',
  `memo` varchar(255) DEFAULT NULL COMMENT '备注',
  `orderid` varchar(50) DEFAULT '' COMMENT '订单号',
  `transactionid` varchar(50) DEFAULT '' COMMENT '流水号',
  `status` enum('created','successed','rejected') DEFAULT 'created' COMMENT '状态:created=申请中,successed=成功,rejected=已拒绝',
  `transfertime` int(10) DEFAULT NULL COMMENT '转账时间',
  `createtime` int(10) DEFAULT NULL COMMENT '添加时间',
  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='提现表';

-- --------------------------------------------------------

--
-- 表的结构 `fa_wxemp`
--

CREATE TABLE IF NOT EXISTS `fa_wxemp` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `wx_name` varchar(50) NOT NULL COMMENT '微信名称',
  `wx_user` varchar(50) NOT NULL COMMENT '微信账号',
  `update_time` int(11) NOT NULL COMMENT '刷新时间',
  `creat_time` int(11) NOT NULL COMMENT '创建时间',
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '状态:0=离线,1=在线',
  `wxid` varchar(50) NOT NULL COMMENT '微信ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `fa_yuanlogin`
--

CREATE TABLE IF NOT EXISTS `fa_yuanlogin` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `name` varchar(50) NOT NULL COMMENT '通道名称',
  `url` varchar(50) NOT NULL COMMENT '通道地址',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  `value` varchar(2500) NOT NULL COMMENT '通道数据',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '通道类型',
  `weigh` int(11) NOT NULL COMMENT '排序'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `fa_yuanpay`
--

CREATE TABLE IF NOT EXISTS `fa_yuanpay` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` text,
  `type` varchar(15) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '是否启用',
  `weigh` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `fa_yuanpay`
--

INSERT INTO `fa_yuanpay` (`id`, `name`, `value`, `type`, `status`, `weigh`) VALUES
(1, '易支付', '{"gateway_url":"http:\\/\\/code.juhekefu.com\\/","appid":"1000","secret_key":"T3VB9GVU","alipay":"1","wxpay":"1"}', 'epay', 1, 100);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fa_admin`
--
ALTER TABLE `fa_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`) USING BTREE;

--
-- Indexes for table `fa_admin_log`
--
ALTER TABLE `fa_admin_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`username`);

--
-- Indexes for table `fa_area`
--
ALTER TABLE `fa_area`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `fa_attachment`
--
ALTER TABLE `fa_attachment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_auth_group`
--
ALTER TABLE `fa_auth_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_auth_group_access`
--
ALTER TABLE `fa_auth_group_access`
  ADD UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `fa_auth_rule`
--
ALTER TABLE `fa_auth_rule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`) USING BTREE,
  ADD KEY `pid` (`pid`),
  ADD KEY `weigh` (`weigh`);

--
-- Indexes for table `fa_category`
--
ALTER TABLE `fa_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weigh` (`weigh`,`id`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `fa_channel`
--
ALTER TABLE `fa_channel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_command`
--
ALTER TABLE `fa_command`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `fa_config`
--
ALTER TABLE `fa_config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `fa_ems`
--
ALTER TABLE `fa_ems`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `fa_message_notice`
--
ALTER TABLE `fa_message_notice`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `fa_message_user`
--
ALTER TABLE `fa_message_user`
  ADD PRIMARY KEY (`rec_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `message_id` (`message_id`);

--
-- Indexes for table `fa_news`
--
ALTER TABLE `fa_news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_order`
--
ALTER TABLE `fa_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_qrlist`
--
ALTER TABLE `fa_qrlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_recharge_order`
--
ALTER TABLE `fa_recharge_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_risk`
--
ALTER TABLE `fa_risk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_sms`
--
ALTER TABLE `fa_sms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_superads`
--
ALTER TABLE `fa_superads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adstag` (`adstag`);

--
-- Indexes for table `fa_superads_images`
--
ALTER TABLE `fa_superads_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_superads_publist`
--
ALTER TABLE `fa_superads_publist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_test`
--
ALTER TABLE `fa_test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_third`
--
ALTER TABLE `fa_third`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `platform` (`platform`,`openid`),
  ADD KEY `user_id` (`user_id`,`platform`),
  ADD KEY `unionid` (`platform`,`unionid`);

--
-- Indexes for table `fa_user`
--
ALTER TABLE `fa_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `email` (`email`),
  ADD KEY `mobile` (`mobile`);

--
-- Indexes for table `fa_user_group`
--
ALTER TABLE `fa_user_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_user_money_log`
--
ALTER TABLE `fa_user_money_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_user_rule`
--
ALTER TABLE `fa_user_rule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_user_score_log`
--
ALTER TABLE `fa_user_score_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_user_token`
--
ALTER TABLE `fa_user_token`
  ADD PRIMARY KEY (`token`);

--
-- Indexes for table `fa_version`
--
ALTER TABLE `fa_version`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `fa_vippack`
--
ALTER TABLE `fa_vippack`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_withdraw`
--
ALTER TABLE `fa_withdraw`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_wxemp`
--
ALTER TABLE `fa_wxemp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_yuanlogin`
--
ALTER TABLE `fa_yuanlogin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fa_yuanpay`
--
ALTER TABLE `fa_yuanpay`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fa_admin`
--
ALTER TABLE `fa_admin`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fa_admin_log`
--
ALTER TABLE `fa_admin_log`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `fa_area`
--
ALTER TABLE `fa_area`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `fa_attachment`
--
ALTER TABLE `fa_attachment`
  MODIFY `id` int(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `fa_auth_group`
--
ALTER TABLE `fa_auth_group`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `fa_auth_rule`
--
ALTER TABLE `fa_auth_rule`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=243;
--
-- AUTO_INCREMENT for table `fa_category`
--
ALTER TABLE `fa_category`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `fa_channel`
--
ALTER TABLE `fa_channel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `fa_command`
--
ALTER TABLE `fa_command`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `fa_config`
--
ALTER TABLE `fa_config`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `fa_ems`
--
ALTER TABLE `fa_ems`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `fa_message_notice`
--
ALTER TABLE `fa_message_notice`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `fa_message_user`
--
ALTER TABLE `fa_message_user`
  MODIFY `rec_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `fa_news`
--
ALTER TABLE `fa_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `fa_order`
--
ALTER TABLE `fa_order`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `fa_qrlist`
--
ALTER TABLE `fa_qrlist`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `fa_recharge_order`
--
ALTER TABLE `fa_recharge_order`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fa_risk`
--
ALTER TABLE `fa_risk`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fa_sms`
--
ALTER TABLE `fa_sms`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `fa_superads`
--
ALTER TABLE `fa_superads`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `fa_superads_images`
--
ALTER TABLE `fa_superads_images`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `fa_superads_publist`
--
ALTER TABLE `fa_superads_publist`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `fa_test`
--
ALTER TABLE `fa_test`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `fa_third`
--
ALTER TABLE `fa_third`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `fa_user`
--
ALTER TABLE `fa_user`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',AUTO_INCREMENT=1000;
--
-- AUTO_INCREMENT for table `fa_user_group`
--
ALTER TABLE `fa_user_group`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fa_user_money_log`
--
ALTER TABLE `fa_user_money_log`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fa_user_rule`
--
ALTER TABLE `fa_user_rule`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=102;
--
-- AUTO_INCREMENT for table `fa_user_score_log`
--
ALTER TABLE `fa_user_score_log`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fa_version`
--
ALTER TABLE `fa_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `fa_vippack`
--
ALTER TABLE `fa_vippack`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `fa_withdraw`
--
ALTER TABLE `fa_withdraw`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fa_wxemp`
--
ALTER TABLE `fa_wxemp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `fa_yuanlogin`
--
ALTER TABLE `fa_yuanlogin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `fa_yuanpay`
--
ALTER TABLE `fa_yuanpay`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
