SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE DATABASE IF NOT EXISTS `Feeds` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `Feeds`;

CREATE TABLE IF NOT EXISTS `feed` (
`id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `feedurl` varchar(255) NOT NULL DEFAULT '',
  `siteurl` varchar(255) DEFAULT NULL,
  `iconurl` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `private` int(11) NOT NULL DEFAULT '1',
  `active` int(11) NOT NULL DEFAULT '1',
  `folderid` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `folder` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `position` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `item` (
`id` int(11) NOT NULL,
  `feedid` int(11) NOT NULL DEFAULT '0',
  `hash` varchar(40) DEFAULT NULL,
  `guid` text,
  `linkurl` varchar(255) DEFAULT NULL,
  `enclosureurl` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `unread` int(11) DEFAULT '1',
  `author` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pubdate` datetime DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=56447 DEFAULT CHARSET=utf8;


ALTER TABLE `feed`
 ADD PRIMARY KEY (`id`), ADD KEY `url` (`feedurl`);

ALTER TABLE `folder`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

ALTER TABLE `item`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `linkurl` (`linkurl`), ADD UNIQUE KEY `linkurl_2` (`linkurl`), ADD KEY `url` (`linkurl`), ADD KEY `guid` (`guid`(10)), ADD KEY `feedid` (`feedid`), ADD KEY `feedguid` (`feedid`,`guid`(40)), ADD FULLTEXT KEY `ft_index` (`title`,`content`);


ALTER TABLE `feed`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
ALTER TABLE `folder`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
ALTER TABLE `item`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=56447;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
