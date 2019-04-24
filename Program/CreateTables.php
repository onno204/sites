
CREATE TABLE `upload` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `size` int(11) NOT NULL,
  `content` mediumblob NOT NULL,
  `AutoDownload` int(1) DEFAULT NULL,
  `AutoRun` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;