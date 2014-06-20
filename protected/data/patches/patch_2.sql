CREATE TABLE IF NOT EXISTS `recommended_servers` (
  `sid` int(10) unsigned NOT NULL DEFAULT '0',
  `till` timestamp NULL DEFAULT NULL,
  `registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recommended_servers`
--
ALTER TABLE `recommended_servers`
 ADD PRIMARY KEY (`sid`), ADD KEY `sid` (`sid`);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `recommended_servers`
--
ALTER TABLE `recommended_servers`
ADD CONSTRAINT `recommended_servers_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `servers` (`id`);
