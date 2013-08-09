-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生日期: 2013 年 08 月 09 日 17:20
-- 伺服器版本: 5.5.32
-- PHP 版本: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫: `ci`
--
CREATE DATABASE IF NOT EXISTS `ci` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `ci`;

-- --------------------------------------------------------

--
-- 表的結構 `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `count` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- 轉存資料表中的資料 `category`
--

INSERT INTO `category` (`id`, `name`, `count`, `create_time`, `note`) VALUES
(1, '菜比巴', 3, '0000-00-00 00:00:00', ''),
(2, '八八八', 0, '0000-00-00 00:00:00', ''),
(3, '哈哈哈', 9999, '0000-00-00 00:00:00', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
