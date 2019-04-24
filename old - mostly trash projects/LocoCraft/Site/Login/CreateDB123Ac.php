<?php
echo "DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nickname` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `email` varchar(200) NOT NULL,
  `status` int(5) NOT NULL DEFAULT '0',
  `online` int(1) NOT NULL,
  `LastIP` varchar(20) NOT NULL,
  `registerIP` varchar(20) NOT NULL,
  PRIMARY KEY (`id`,`username`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;";


                $Error = mysqli_error($connection);
                if(!($Error === " ")){
                    die("Error while adding you to the database: " . $Error);
                }