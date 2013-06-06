--
-- Sample Database for Pandora
--

-- --------------------------------------------------------

--
-- Table structure for table `groupmembers`
--

CREATE TABLE `groupmembers` (
  `groupid` int(15) NOT NULL,
  `userid` int(15) NOT NULL,
  PRIMARY KEY (`groupid`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `groupid` int(9) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(99) NOT NULL,
  `groupadmin` int(15) NOT NULL,
  PRIMARY KEY (`groupid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `password`
--

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
  `SUID` varchar(99) DEFAULT NULL,
  PRIMARY KEY (`passwordid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(9) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password_hash` text NOT NULL,
  `privatekey_enc` text NOT NULL,
  `publickey` text NOT NULL,
  `twofa_enc` text NOT NULL,
  `keypass` varchar(30) NOT NULL,
  `salt` text NOT NULL,
  `challenge` text NOT NULL,
  `challenge_hash` text NOT NULL,
  `firstname` varchar(99) NOT NULL,
  `lastname` varchar(99) NOT NULL,
  `email` varchar(99) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;