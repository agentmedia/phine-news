
CREATE TABLE IF NOT EXISTS `pc_news_archive` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(64) NOT NULL,
  `Page` bigint(20) unsigned DEFAULT NULL,
  `DateFormat` varchar(64) NOT NULL,
  `MetaTitlePlacement` varchar(32) NOT NULL,
  `MetaDescriptionPlacement` varchar(32) NOT NULL,
  `ItemsPerPage` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Page` (`Page`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pc_news_article`
--

CREATE TABLE IF NOT EXISTS `pc_news_article` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Title` varchar(128) NOT NULL,
  `CleanTitle` varchar(255) NOT NULL,
  `Teaser` text NOT NULL,
  `Text` text NOT NULL,
  `Category` bigint(20) unsigned NOT NULL,
  `Author` bigint(20) unsigned DEFAULT NULL,
  `Created` datetime NOT NULL,
  `Changed` datetime NOT NULL,
  `Publish` tinyint(1) NOT NULL DEFAULT '0',
  `PublishFrom` datetime DEFAULT NULL,
  `PublishTo` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `CleanTitle` (`CleanTitle`),
  KEY `Title` (`Title`),
  KEY `Author` (`Author`),
  KEY `Created` (`Created`),
  KEY `Changed` (`Changed`),
  KEY `Category` (`Category`),
  KEY `Publish` (`Publish`),
  KEY `PublishFrom` (`PublishFrom`),
  KEY `PublishTo` (`PublishTo`),
  FULLTEXT KEY `Teaser` (`Teaser`),
  FULLTEXT KEY `Text` (`Text`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pc_news_category`
--

CREATE TABLE IF NOT EXISTS `pc_news_category` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(64) NOT NULL,
  `Page` bigint(20) unsigned DEFAULT NULL,
  `Archive` bigint(20) unsigned NOT NULL,
  `Previous` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Previous` (`Previous`),
  UNIQUE KEY `Page` (`Page`),
  KEY `Name` (`Name`),
  KEY `Archive` (`Archive`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pc_news_content_article`
--

CREATE TABLE IF NOT EXISTS `pc_news_content_article` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Content` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Content` (`Content`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pc_news_content_article_list`
--

CREATE TABLE IF NOT EXISTS `pc_news_content_article_list` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Content` bigint(20) unsigned NOT NULL,
  `ArticlePage` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Content` (`Content`),
  KEY `ArticlePage` (`ArticlePage`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pc_news_content_pager`
--

CREATE TABLE IF NOT EXISTS `pc_news_content_pager` (
  `ID` bigint(20) unsigned NOT NULL,
  `Content` bigint(20) unsigned NOT NULL,
  `ShowOnePage` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Content` (`Content`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;