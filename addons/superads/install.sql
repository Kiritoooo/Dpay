CREATE TABLE IF NOT EXISTS `__PREFIX__superads` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `adsname` varchar(50) NOT NULL DEFAULT '' COMMENT '广告名称',
  `adstag` varchar(50) NOT NULL DEFAULT '' COMMENT '广告标记',
  `adswidth` int(10) NOT NULL DEFAULT '0' COMMENT '广告宽度',
  `adsheight` int(10) NOT NULL DEFAULT '0' COMMENT '广告高度',
  `typedata` enum('1','2','3') NOT NULL DEFAULT '1' COMMENT '类型:1=单图,2=多图,3=代码',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',
  `memo` varchar(100) DEFAULT '' COMMENT '备注',
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '状态:1=启用,0=未启用',
  PRIMARY KEY (`id`),
  KEY (`adstag`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='广告表';

CREATE TABLE IF NOT EXISTS `__PREFIX__superads_images`(
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `imgtitle` varchar(300) NOT NULL DEFAULT '' COMMENT '广告标题',
  `superads_id` int(10) NOT NULL DEFAULT '0' COMMENT '广告表ID',
  `isforeverdata` enum('1','0') NOT NULL DEFAULT '1' COMMENT '时间:1=永久生效,0=设定时间内生效',
  `clickhref` varchar(200) NULL DEFAULT '' COMMENT '点击地址',
  `adscontent` text  COMMENT '广告文本内容',
  `adsimage` varchar(500) NULL DEFAULT '' COMMENT '广告图片',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',
  `livestime` int(10) DEFAULT NULL COMMENT '生效开始时间',
  `liveetime` int(10) DEFAULT NULL COMMENT '生效结束时间',
  `memo` varchar(100) DEFAULT '' COMMENT '备注',
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '状态:1=启用,0=未启用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='广告内容表';

CREATE TABLE IF NOT EXISTS `__PREFIX__superads_publist`(
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `pubtitle` varchar(300) NOT NULL DEFAULT '' COMMENT '公告标题',
  `pubtag` varchar(30) NOT NULL DEFAULT '' COMMENT '公告标签',
  `publicontent` text  COMMENT '公告内容',
  `pubimage` varchar(500) NULL DEFAULT '' COMMENT '公告图片',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',
  `isforeverdata` enum('1','0') NOT NULL DEFAULT '1' COMMENT '时间:1=永久生效,0=设定时间内生效',
  `livestime` int(10) DEFAULT NULL COMMENT '生效开始时间',
  `liveetime` int(10) DEFAULT NULL COMMENT '生效结束时间',
  `memo` varchar(100) DEFAULT '' COMMENT '备注',
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '状态:1=启用,0=未启用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='公告内容表';