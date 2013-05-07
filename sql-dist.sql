--
-- Sample Database for Pandora
--

-- --------------------------------------------------------

--
-- Table structure for table `password`
--

DROP TABLE IF EXISTS `password`;
CREATE TABLE `password` (
  `passwordid` int(9) NOT NULL AUTO_INCREMENT,
  `user_id` int(9) NOT NULL,
  `group_id` int(9) NOT NULL,
  `title_enc` text NOT NULL,
  `username_enc` text NOT NULL,
  `password_enc` text NOT NULL,
  `notes_enc` text NOT NULL,
  `url_enc` text NOT NULL,
  `timestamp` int(15) NOT NULL,
  PRIMARY KEY (`passwordid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `uid` int(9) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password_hash` text NOT NULL,
  `privatekey_enc` text NOT NULL,
  `publickey` text NOT NULL,
  `twofa_enc` text NOT NULL,
  `keypass` varchar(30) NOT NULL,
  `salt` text NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
