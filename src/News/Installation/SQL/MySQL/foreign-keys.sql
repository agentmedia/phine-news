--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `pc_news_archive`
--
ALTER TABLE `pc_news_archive`
  ADD CONSTRAINT `pc_news_archive_ibfk_1` FOREIGN KEY (`Page`) REFERENCES `pc_core_page` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints der Tabelle `pc_news_article`
--
ALTER TABLE `pc_news_article`
  ADD CONSTRAINT `pc_news_article_ibfk_1` FOREIGN KEY (`Author`) REFERENCES `pc_core_user` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pc_news_article_ibfk_2` FOREIGN KEY (`Category`) REFERENCES `pc_news_category` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `pc_news_category`
--
ALTER TABLE `pc_news_category`
  ADD CONSTRAINT `pc_news_category_ibfk_3` FOREIGN KEY (`Page`) REFERENCES `pc_core_page` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pc_news_category_ibfk_1` FOREIGN KEY (`Archive`) REFERENCES `pc_news_archive` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pc_news_category_ibfk_2` FOREIGN KEY (`Previous`) REFERENCES `pc_news_category` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints der Tabelle `pc_news_content_article`
--
ALTER TABLE `pc_news_content_article`
  ADD CONSTRAINT `pc_news_content_article_ibfk_1` FOREIGN KEY (`Content`) REFERENCES `pc_core_content` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `pc_news_content_article_list`
--
ALTER TABLE `pc_news_content_article_list`
  ADD CONSTRAINT `pc_news_content_article_list_ibfk_2` FOREIGN KEY (`ArticlePage`) REFERENCES `pc_core_page` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pc_news_content_article_list_ibfk_1` FOREIGN KEY (`Content`) REFERENCES `pc_core_content` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `pc_news_content_pager`
--
ALTER TABLE `pc_news_content_pager`
  ADD CONSTRAINT `pc_news_content_pager_ibfk_1` FOREIGN KEY (`Content`) REFERENCES `pc_core_content` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;


