-- ServerGrid
-- Server Monitoring Application Framework
-- gingerCoder()
-- gingercoder.com


SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `servergrid`
--

-- --------------------------------------------------------

--
-- Table structure for table `client_servers`
--

CREATE TABLE IF NOT EXISTS `client_servers` (
  `serverid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `serverIdent` varchar(32) NOT NULL,
  `serverName` varchar(255) NOT NULL,
  `serverOS` varchar(50) NOT NULL,
  `ipaddress` varchar(15) DEFAULT NULL,
  `rackposition` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateModified` datetime NOT NULL,
  PRIMARY KEY (`serverid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Servers added by clients' AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `client_servers_log`
--

CREATE TABLE IF NOT EXISTS `client_servers_log` (
  `logid` int(11) NOT NULL AUTO_INCREMENT,
  `serverid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `freemem` varchar(50) DEFAULT NULL,
  `freedisk` varchar(255) DEFAULT NULL,
  `loadAverage` varchar(50) DEFAULT NULL,
  `kernelVersion` varchar(150) DEFAULT NULL,
  `ipaddress` varchar(15) DEFAULT NULL,
  `uptime` varchar(50) DEFAULT NULL,
  `hostname` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`logid`),
  KEY `serverid` (`serverid`,`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Server Log files' AUTO_INCREMENT=309 ;

-- --------------------------------------------------------

--
-- Table structure for table `errorlogs`
--

CREATE TABLE IF NOT EXISTS `errorlogs` (
  `errorlogid` int(11) NOT NULL AUTO_INCREMENT,
  `logged` datetime NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `userAction` text NOT NULL,
  PRIMARY KEY (`errorlogid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='System Error Logging' AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `framework_settings`
--

CREATE TABLE IF NOT EXISTS `framework_settings` (
  `settingName` varchar(30) DEFAULT NULL,
  `settingValue` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
INSERT INTO `framework_settings` (`settingName`, `settingValue`) VALUES
('appTitle', 'ServerGrid'),
('appDescription', 'Remote Server Information'),
('footerInfo', 'ServerGrid built by Tohu Muna Software'),
('outputType', 'php'),
('passwordSeed', '2d5377a9e28871fefc8c5ee77e06f818'),
('firewall', 'off'),
('emailSentFrom', 'servergrid@tohumuna.com'),
('emailFooter', 'Automatically generated email from ServerGrid inteded for recipient only');
-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `logid` int(11) NOT NULL AUTO_INCREMENT,
  `logged` datetime NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `userAction` text NOT NULL,
  PRIMARY KEY (`logid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='System Event Logging' AUTO_INCREMENT=83 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `emailaddress` varchar(100) NOT NULL,
  `telephone` varchar(16) NOT NULL,
  `jobtitle` varchar(50) NOT NULL,
  `usertype` int(1) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`userid`),
  KEY `emailaddress` (`emailaddress`),
  KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Users table' AUTO_INCREMENT=2 ;


--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `firstname`, `surname`, `emailaddress`, `telephone`, `jobtitle`, `usertype`, `username`, `password`) VALUES
(1, 'ServerGrid', 'Admin', 'servergridadmin@tohumuna.com', '0123456', 'System Admin', 5, 'sysadmin', '9e7a2f946feed6a7e4d9d7b5b635b080');
