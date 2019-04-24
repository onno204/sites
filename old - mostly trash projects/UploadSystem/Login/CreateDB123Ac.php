<?php
echo "
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nickname` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `email` varchar(200) NOT NULL,
  `status` int(5) NOT NULL DEFAULT '0',
  `online` int(1) DEFAULT '0',
  `LastIP` varchar(20) NOT NULL DEFAULT '0.0.0.0',
  `registerIP` varchar(20) NOT NULL,
  `Perm` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`id`,`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

















";
