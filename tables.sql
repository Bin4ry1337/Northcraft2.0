-- --------------------------------------------------------
-- Host:                         188.226.141.35
-- Server version:               5.7.19-0ubuntu0.16.04.1 - (Ubuntu)
-- Server OS:                    Linux
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table northcraft.blacklist
CREATE TABLE IF NOT EXISTS `blacklist` (
  `ip` tinytext NOT NULL,
  `Comment` tinytext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping structure for table northcraft.faq
CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(128) NOT NULL AUTO_INCREMENT,
  `question` tinytext NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `logging_system` (
  `id` int(128) NOT NULL AUTO_INCREMENT,
  `ip` tinytext NOT NULL,
  `agent` text NOT NULL,
  `time` int(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(128) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `parameter` longtext NOT NULL,
  `current_ip` varchar(50) NOT NULL,
  `log_time` int(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping structure for table northcraft.news
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(128) NOT NULL AUTO_INCREMENT,
  `post_title` tinytext NOT NULL,
  `post_date` int(16) NOT NULL,
  `post_summary` text NOT NULL,
  `post_content` longtext NOT NULL,
  `post_banner` tinytext,
  `category` tinytext,
  `author` varchar(50) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping structure for table northcraft.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(128) NOT NULL AUTO_INCREMENT,
  `page_id` int(16) NOT NULL,
  `permission` int(16) NOT NULL,
  `comment` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Security Permissions for the pages';

-- Dumping structure for table northcraft.ranks
CREATE TABLE IF NOT EXISTS `ranks` (
  `id` int(128) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping structure for table northcraft.recover_emails
CREATE TABLE IF NOT EXISTS `recover_emails` (
  `id` int(128) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `code` varchar(128) NOT NULL,
  `ip_address` varchar(128) NOT NULL,
  `received_date` int(16) NOT NULL,
  `active` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping structure for table northcraft.reward_system
CREATE TABLE IF NOT EXISTS `reward_system` (
  `id` int(128) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `reward` int(16) NOT NULL,
  `redeemed_on` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `ip_used` varchar(128) NOT NULL,
  `time_used` int(16) NOT NULL,
  `active` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping structure for table northcraft.shop
CREATE TABLE IF NOT EXISTS `shop` (
  `product_id` int(128) NOT NULL AUTO_INCREMENT,
  `product_type` varchar(50) NOT NULL,
  `product_name` tinytext NOT NULL,
  `product_description` tinytext NOT NULL,
  `entry` int(16) NOT NULL,
  `price` int(16) NOT NULL,
  `quantity` int(16) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Vanity Shop Items';

-- Dumping structure for table northcraft.spell
CREATE TABLE IF NOT EXISTS `spell` (
  `id` varchar(50) NOT NULL DEFAULT '0',
  `field1` varchar(50) NOT NULL DEFAULT '0',
  `field2` varchar(50) NOT NULL DEFAULT '0',
  `field3` varchar(50) NOT NULL DEFAULT '0',
  `field4` varchar(50) NOT NULL DEFAULT '0',
  `field5` varchar(50) NOT NULL DEFAULT '0',
  `field6` varchar(50) NOT NULL DEFAULT '0',
  `field7` varchar(50) NOT NULL DEFAULT '0',
  `field8` varchar(50) NOT NULL DEFAULT '0',
  `field9` varchar(50) NOT NULL DEFAULT '0',
  `field10` varchar(50) NOT NULL DEFAULT '0',
  `field11` varchar(50) NOT NULL DEFAULT '0',
  `field12` varchar(50) NOT NULL DEFAULT '0',
  `field13` varchar(50) NOT NULL DEFAULT '0',
  `field14` varchar(50) NOT NULL DEFAULT '0',
  `field15` varchar(50) NOT NULL DEFAULT '0',
  `field16` varchar(50) NOT NULL DEFAULT '0',
  `field17` varchar(50) NOT NULL DEFAULT '0',
  `field18` varchar(50) NOT NULL DEFAULT '0',
  `field19` varchar(50) NOT NULL DEFAULT '0',
  `field20` varchar(50) NOT NULL DEFAULT '0',
  `field21` varchar(50) NOT NULL DEFAULT '0',
  `field22` varchar(50) NOT NULL DEFAULT '0',
  `field23` varchar(50) NOT NULL DEFAULT '0',
  `field24` varchar(50) NOT NULL DEFAULT '0',
  `field25` varchar(50) NOT NULL DEFAULT '0',
  `field26` varchar(50) NOT NULL DEFAULT '0',
  `field27` varchar(50) NOT NULL DEFAULT '0',
  `field28` varchar(50) NOT NULL DEFAULT '0',
  `field29` varchar(50) NOT NULL DEFAULT '0',
  `field30` varchar(50) NOT NULL DEFAULT '0',
  `field31` varchar(50) NOT NULL DEFAULT '0',
  `field32` varchar(50) NOT NULL DEFAULT '0',
  `field33` varchar(50) NOT NULL DEFAULT '0',
  `field34` varchar(50) NOT NULL DEFAULT '0',
  `field35` varchar(50) NOT NULL DEFAULT '0',
  `field36` varchar(50) NOT NULL DEFAULT '0',
  `field37` varchar(50) NOT NULL DEFAULT '0',
  `field38` varchar(50) NOT NULL DEFAULT '0',
  `field39` varchar(50) NOT NULL DEFAULT '0',
  `field40` varchar(50) NOT NULL DEFAULT '0',
  `field41` varchar(50) NOT NULL DEFAULT '0',
  `field42` varchar(50) NOT NULL DEFAULT '0',
  `field43` varchar(50) NOT NULL DEFAULT '0',
  `field44` varchar(50) NOT NULL DEFAULT '0',
  `field45` varchar(50) NOT NULL DEFAULT '0',
  `field46` varchar(50) NOT NULL DEFAULT '0',
  `field47` varchar(50) NOT NULL DEFAULT '0',
  `field48` varchar(50) NOT NULL DEFAULT '0',
  `field49` varchar(50) NOT NULL DEFAULT '0',
  `field50` varchar(50) NOT NULL DEFAULT '0',
  `field51` varchar(50) NOT NULL DEFAULT '0',
  `field52` varchar(50) NOT NULL DEFAULT '0',
  `field53` varchar(50) NOT NULL DEFAULT '0',
  `field54` varchar(50) NOT NULL DEFAULT '0',
  `field55` varchar(50) NOT NULL DEFAULT '0',
  `field56` varchar(50) NOT NULL DEFAULT '0',
  `field57` varchar(50) NOT NULL DEFAULT '0',
  `field58` varchar(50) NOT NULL DEFAULT '0',
  `field59` varchar(50) NOT NULL DEFAULT '0',
  `field60` varchar(50) NOT NULL DEFAULT '0',
  `field61` varchar(50) NOT NULL DEFAULT '0',
  `field62` varchar(50) NOT NULL DEFAULT '0',
  `field63` varchar(50) NOT NULL DEFAULT '0',
  `field64` varchar(50) NOT NULL DEFAULT '0',
  `field65` varchar(50) NOT NULL DEFAULT '0',
  `field66` varchar(50) NOT NULL DEFAULT '0',
  `field67` varchar(50) NOT NULL DEFAULT '0',
  `field68` varchar(50) NOT NULL DEFAULT '0',
  `field69` varchar(50) NOT NULL DEFAULT '0',
  `field70` varchar(50) NOT NULL DEFAULT '0',
  `field71` varchar(50) NOT NULL DEFAULT '0',
  `field72` varchar(50) NOT NULL DEFAULT '0',
  `field73` varchar(50) NOT NULL DEFAULT '0',
  `field74` varchar(50) NOT NULL DEFAULT '0',
  `field75` varchar(50) NOT NULL DEFAULT '0',
  `field76` varchar(50) NOT NULL DEFAULT '0',
  `field77` varchar(50) NOT NULL DEFAULT '0',
  `field78` varchar(50) NOT NULL DEFAULT '0',
  `field79` varchar(50) NOT NULL DEFAULT '0',
  `field80` varchar(50) NOT NULL DEFAULT '0',
  `field81` varchar(50) NOT NULL DEFAULT '0',
  `field82` varchar(50) NOT NULL DEFAULT '0',
  `field83` varchar(50) NOT NULL DEFAULT '0',
  `field84` varchar(50) NOT NULL DEFAULT '0',
  `field85` varchar(50) NOT NULL DEFAULT '0',
  `field86` varchar(50) NOT NULL DEFAULT '0',
  `field87` varchar(50) NOT NULL DEFAULT '0',
  `field88` varchar(50) NOT NULL DEFAULT '0',
  `field89` varchar(50) NOT NULL DEFAULT '0',
  `field90` varchar(50) NOT NULL DEFAULT '0',
  `field91` varchar(50) NOT NULL DEFAULT '0',
  `field92` varchar(50) NOT NULL DEFAULT '0',
  `field93` varchar(50) NOT NULL DEFAULT '0',
  `field94` varchar(50) NOT NULL DEFAULT '0',
  `field95` varchar(50) NOT NULL DEFAULT '0',
  `field96` varchar(50) NOT NULL DEFAULT '0',
  `field97` varchar(50) NOT NULL DEFAULT '0',
  `field98` varchar(50) NOT NULL DEFAULT '0',
  `field99` varchar(50) NOT NULL DEFAULT '0',
  `field100` varchar(50) NOT NULL DEFAULT '0',
  `field101` varchar(50) NOT NULL DEFAULT '0',
  `field102` varchar(50) NOT NULL DEFAULT '0',
  `field103` varchar(50) NOT NULL DEFAULT '0',
  `field104` varchar(50) NOT NULL DEFAULT '0',
  `field105` varchar(50) NOT NULL DEFAULT '0',
  `field106` varchar(50) NOT NULL DEFAULT '0',
  `field107` varchar(50) NOT NULL DEFAULT '0',
  `field108` varchar(50) NOT NULL DEFAULT '0',
  `field109` varchar(50) NOT NULL DEFAULT '0',
  `field110` varchar(50) NOT NULL DEFAULT '0',
  `field111` varchar(50) NOT NULL DEFAULT '0',
  `field112` varchar(50) NOT NULL DEFAULT '0',
  `field113` varchar(50) NOT NULL DEFAULT '0',
  `field114` varchar(50) NOT NULL DEFAULT '0',
  `field115` varchar(50) NOT NULL DEFAULT '0',
  `field116` varchar(50) NOT NULL DEFAULT '0',
  `field117` varchar(50) NOT NULL DEFAULT '0',
  `field118` varchar(50) NOT NULL DEFAULT '0',
  `field119` varchar(50) NOT NULL DEFAULT '0',
  `field120` varchar(50) NOT NULL DEFAULT '0',
  `field121` varchar(50) NOT NULL DEFAULT '0',
  `field122` varchar(50) NOT NULL DEFAULT '0',
  `field123` varchar(50) NOT NULL DEFAULT '0',
  `field124` varchar(50) NOT NULL DEFAULT '0',
  `field125` varchar(50) NOT NULL DEFAULT '0',
  `field126` varchar(50) NOT NULL DEFAULT '0',
  `field127` varchar(50) NOT NULL DEFAULT '0',
  `field128` varchar(50) NOT NULL DEFAULT '0',
  `field129` varchar(50) NOT NULL DEFAULT '0',
  `field130` varchar(50) NOT NULL DEFAULT '0',
  `field131` varchar(50) NOT NULL DEFAULT '0',
  `field132` varchar(50) NOT NULL DEFAULT '0',
  `field133` varchar(50) NOT NULL DEFAULT '0',
  `field134` varchar(50) NOT NULL DEFAULT '0',
  `field135` varchar(50) NOT NULL DEFAULT '0',
  `field136` varchar(50) NOT NULL DEFAULT '0',
  `field137` varchar(50) NOT NULL DEFAULT '0',
  `field138` varchar(50) NOT NULL DEFAULT '0',
  `field139` varchar(50) NOT NULL DEFAULT '0',
  `field140` varchar(50) NOT NULL DEFAULT '0',
  `field141` varchar(50) NOT NULL DEFAULT '0',
  `field142` varchar(50) NOT NULL DEFAULT '0',
  `field143` varchar(50) NOT NULL DEFAULT '0',
  `field144` varchar(50) NOT NULL DEFAULT '0',
  `field145` varchar(50) NOT NULL DEFAULT '0',
  `field146` varchar(50) NOT NULL DEFAULT '0',
  `field147` varchar(50) NOT NULL DEFAULT '0',
  `field148` varchar(50) NOT NULL DEFAULT '0',
  `field149` varchar(50) NOT NULL DEFAULT '0',
  `field150` varchar(50) NOT NULL DEFAULT '0',
  `field151` varchar(50) NOT NULL DEFAULT '0',
  `field152` varchar(50) NOT NULL DEFAULT '0',
  `field153` varchar(50) NOT NULL DEFAULT '0',
  `field154` varchar(50) NOT NULL DEFAULT '0',
  `field155` varchar(50) NOT NULL DEFAULT '0',
  `field156` varchar(50) NOT NULL DEFAULT '0',
  `field157` varchar(50) NOT NULL DEFAULT '0',
  `field158` varchar(50) NOT NULL DEFAULT '0',
  `field159` varchar(50) NOT NULL DEFAULT '0',
  `field160` varchar(50) NOT NULL DEFAULT '0',
  `field161` varchar(50) NOT NULL DEFAULT '0',
  `field162` varchar(50) NOT NULL DEFAULT '0',
  `field163` varchar(50) NOT NULL DEFAULT '0',
  `field164` varchar(50) NOT NULL DEFAULT '0',
  `field165` varchar(50) NOT NULL DEFAULT '0',
  `field166` varchar(50) NOT NULL DEFAULT '0',
  `field167` varchar(50) NOT NULL DEFAULT '0',
  `field168` varchar(50) NOT NULL DEFAULT '0',
  `field169` varchar(50) NOT NULL DEFAULT '0',
  `field170` varchar(50) NOT NULL DEFAULT '0',
  `field171` varchar(50) NOT NULL DEFAULT '0',
  `field172` varchar(50) NOT NULL DEFAULT '0',
  `field173` varchar(50) NOT NULL DEFAULT '0',
  `field174` varchar(50) NOT NULL DEFAULT '0',
  `field175` varchar(50) NOT NULL DEFAULT '0',
  `field176` varchar(50) NOT NULL DEFAULT '0',
  `field177` varchar(50) NOT NULL DEFAULT '0',
  `field178` varchar(50) NOT NULL DEFAULT '0',
  `field179` varchar(50) NOT NULL DEFAULT '0',
  `field180` varchar(50) NOT NULL DEFAULT '0',
  `field181` varchar(50) NOT NULL DEFAULT '0',
  `field182` varchar(50) NOT NULL DEFAULT '0',
  `field183` varchar(50) NOT NULL DEFAULT '0',
  `field184` varchar(50) NOT NULL DEFAULT '0',
  `field185` varchar(50) NOT NULL DEFAULT '0',
  `field186` varchar(50) NOT NULL DEFAULT '0',
  `field187` varchar(50) NOT NULL DEFAULT '0',
  `field188` varchar(50) NOT NULL DEFAULT '0',
  `field189` varchar(50) NOT NULL DEFAULT '0',
  `field190` varchar(50) NOT NULL DEFAULT '0',
  `field191` varchar(50) NOT NULL DEFAULT '0',
  `field192` varchar(50) NOT NULL DEFAULT '0',
  `field193` varchar(50) NOT NULL DEFAULT '0',
  `field194` varchar(50) NOT NULL DEFAULT '0',
  `field195` varchar(50) NOT NULL DEFAULT '0',
  `field196` varchar(50) NOT NULL DEFAULT '0',
  `field197` varchar(50) NOT NULL DEFAULT '0',
  `field198` varchar(50) NOT NULL DEFAULT '0',
  `field199` varchar(50) NOT NULL DEFAULT '0',
  `field200` varchar(50) NOT NULL DEFAULT '0',
  `field201` varchar(50) NOT NULL DEFAULT '0',
  `field202` varchar(50) NOT NULL DEFAULT '0',
  `field203` varchar(50) NOT NULL DEFAULT '0',
  `field204` varchar(50) NOT NULL DEFAULT '0',
  `field205` varchar(50) NOT NULL DEFAULT '0',
  `field206` varchar(50) NOT NULL DEFAULT '0',
  `field207` varchar(50) NOT NULL DEFAULT '0',
  `field208` varchar(50) NOT NULL DEFAULT '0',
  `field209` varchar(50) NOT NULL DEFAULT '0',
  `field210` varchar(50) NOT NULL DEFAULT '0',
  `field211` varchar(50) NOT NULL DEFAULT '0',
  `field212` varchar(50) NOT NULL DEFAULT '0',
  `field213` varchar(50) NOT NULL DEFAULT '0',
  `field214` varchar(50) NOT NULL DEFAULT '0',
  `field215` varchar(50) NOT NULL DEFAULT '0',
  `field216` varchar(50) NOT NULL DEFAULT '0',
  `field217` varchar(50) NOT NULL DEFAULT '0',
  `field218` varchar(50) NOT NULL DEFAULT '0',
  `field219` varchar(50) NOT NULL DEFAULT '0',
  `field220` varchar(50) NOT NULL DEFAULT '0',
  `field221` varchar(50) NOT NULL DEFAULT '0',
  `field222` varchar(50) NOT NULL DEFAULT '0',
  `field223` varchar(50) NOT NULL DEFAULT '0',
  `field224` varchar(50) NOT NULL DEFAULT '0',
  `field225` varchar(50) NOT NULL DEFAULT '0',
  `field226` varchar(50) NOT NULL DEFAULT '0',
  `field227` varchar(50) NOT NULL DEFAULT '0',
  `field228` varchar(50) NOT NULL DEFAULT '0',
  `field229` varchar(50) NOT NULL DEFAULT '0',
  `field230` varchar(50) NOT NULL DEFAULT '0',
  `field231` varchar(50) NOT NULL DEFAULT '0',
  `field232` varchar(50) NOT NULL DEFAULT '0',
  `field233` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping structure for table northcraft.staff
CREATE TABLE IF NOT EXISTS `staff` (
  `id` int(128) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `avatar` tinytext NOT NULL,
  `rank` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping structure for table northcraft.streamers
CREATE TABLE IF NOT EXISTS `streamers` (
  `id` int(128) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `status` int(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping structure for table northcraft.support
CREATE TABLE IF NOT EXISTS `support` (
  `id` int(128) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` tinytext NOT NULL,
  `subject` tinytext NOT NULL,
  `message` text NOT NULL,
  `created` int(16) NOT NULL,
  `ip` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping structure for table northcraft.support
CREATE TABLE IF NOT EXISTS `support` (
  `id` int(128) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` tinytext NOT NULL,
  `subject` tinytext NOT NULL,
  `message` text NOT NULL,
  `created` int(16) NOT NULL,
  `ip` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping structure for table northcraft.transactions
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(128) NOT NULL AUTO_INCREMENT,
  `transaction_id` tinytext NOT NULL,
  `amount` int(16) NOT NULL,
  `currency_type` varchar(8) NOT NULL,
  `token` varchar(50) NOT NULL,
  `payerid` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `character_name` varchar(50) NOT NULL,
  `item_id` int(128) NOT NULL,
  `approved` int(8) NOT NULL,
  `time` int(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping structure for table northcraft.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(128) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` tinytext NOT NULL,
  `password` varchar(50) NOT NULL,
  `salt` tinytext NOT NULL,
  `level` int(10) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `register_ip` varchar(50) NOT NULL,
  `register_date` int(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Administration Panel Users';

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
