--
-- Table structure for table `forgotten_passwords`
--

CREATE TABLE IF NOT EXISTS `forgotten_passwords` (
  `uid` int(11) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `forgotten_passwords`
--

INSERT INTO `forgotten_passwords` (`uid`, `hash`, `time`) VALUES
(1, '2d588fdee83370fc7697986a689c4d3b', '2014-05-19 16:53:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `forgotten_passwords`
--
ALTER TABLE `forgotten_passwords`
 ADD PRIMARY KEY (`uid`);