<?php

use Phine\Framework\Localization\PhpTranslator;
$translator = PhpTranslator::Singleton();

$lang = 'de';
//Navigation
$translator->AddTranslation($lang, 'News.NavTitle', 'News');
$translator->AddTranslation($lang, 'News.ArchiveList.NavTitle', 'News-Archive');
$translator->AddTranslation($lang, 'News.OverviewTitle', 'News-Modul');
$translator->AddTranslation($lang, 'News.OverviewDescription', 'News-Artikel auf Ihren Webseiten');
$translator->AddTranslation($lang, 'News.ArchiveList.OverviewTitle', 'News-Archive');
$translator->AddTranslation($lang, 'News.ArchiveList.OverviewDescription', 'Organisiere Ihre Artikel in Archiven and Kategorien.');

//News Archive List
$translator->AddTranslation($lang, 'News.ArchiveList.Title', 'News Archivliste');
$translator->AddTranslation($lang, 'News.ArchiveList.Description.Amount_{0}', 'Es gibt {0} Archive in dieser Phine-Installation.');
$translator->AddTranslation($lang, 'News.ArchiveList.New', 'Archive erstellem');
$translator->AddTranslation($lang, 'News.ArchiveList.Name', 'Name');
$translator->AddTranslation($lang, 'News.ArchiveList.Categories', 'Kategorien ansehen/ändern');
$translator->AddTranslation($lang, 'News.ArchiveList.Articles', 'Artikel ansehen/ändern');
$translator->AddTranslation($lang, 'News.ArchiveList.Edit', 'Archiv bearbeiten');
$translator->AddTranslation($lang, 'News.ArchiveList.Delete', 'Archiv löschen');

//News Archive Form
$translator->AddTranslation($lang, 'News.ArchiveForm.Title', 'Archiv bearbeiten');
$translator->AddTranslation($lang, 'News.ArchiveForm.Description', 'Ändern Sie hier die Basiseinstellungen des News-Archives.');
$translator->AddTranslation($lang, 'News.ArchiveForm.Legend', 'Archiv-Einstellungen');
$translator->AddTranslation($lang, 'News.ArchiveForm.Name', 'Name');
$translator->AddTranslation($lang, 'News.ArchiveForm.ItemsPerPage', 'Beiträge pro Seite');
$translator->AddTranslation($lang, 'News.ArchiveForm.DateFormat', 'Datumsformat');
$translator->AddTranslation($lang, 'News.ArchiveForm.DateFormat.Default', 'd.m.Y H:i:s');
$translator->AddTranslation($lang, 'News.ArchiveForm.MetaTitlePlacement', 'News-Titel im Seitentitel');
$translator->AddTranslation($lang, 'News.ArchiveForm.MetaDescriptionPlacement', 'Teaser in Meta-Description');
$translator->AddTranslation($lang, 'News.MetaPlacement.Prepend', 'Voranstellen');
$translator->AddTranslation($lang, 'News.MetaPlacement.Append', 'Anhängen');
$translator->AddTranslation($lang, 'News.MetaPlacement.Replace', 'Ersetzen');
$translator->AddTranslation($lang, 'News.MetaPlacement.None', 'Nicht einsetzen');
$translator->AddTranslation($lang, 'News.ArchiveForm.Submit', 'Speichern');
$translator->AddTranslation($lang, 'News.ArchiveForm.Name.Validation.Required.Missing', 'Archivname wird benötigt');
$translator->AddTranslation($lang, 'News.ArchiveForm.ItemsPerPage.Validation.Required.Missing', 'Artikel pro Seite definieren');
$translator->AddTranslation($lang, 'News.ArchiveForm.ItemsPerPage.Validation.Integer.HasNonDigits', 'Positive Zahl erforderlich');
$translator->AddTranslation($lang, 'News.ArchiveForm.ItemsPerPage.Validation.Integer.ExceedsMin_{0}', 'Positive Zahl erforderlich');    
$translator->AddTranslation($lang, 'News.ArchiveForm.DateFormat.Validation.Required.Missing', 'Datumsformat für Artikel angeben');

//News Article List Content
$translator->AddTranslation($lang, 'News.ArticleList.BackendName', 'Artikelliste');
$translator->AddTranslation($lang, 'News.ArticleListForm.Title', 'Artikelliste');
$translator->AddTranslation($lang, 'News.ArticleListForm.Description', 'Das Element "Artikelliste" zeigt die Artikel in einem Archiv oder einer Kategorie.');
$translator->AddTranslation($lang, 'News.ArticleListForm.Legend', 'Einstellungen der Artikelliste');
$translator->AddTranslation($lang, 'News.ArticleListForm.ArchiveCategory', 'Archiv / Kategorie');
$translator->AddTranslation($lang, 'News.ArticleListForm.ArticlePage', 'Artikel-Seite');
$translator->AddTranslation($lang, 'News.ArticleListForm.NoArticles', 'Keine Artikel');
$translator->AddTranslation($lang, 'News.ArticleListForm.DisplayArticles-From_{0}-To_{1}-Of_{2}', 'Artikel {0] bis {1} von {2} angezeigt');
$translator->AddTranslation($lang, 'News.ArticleListForm.Submit', 'Speichern');
$translator->AddTranslation($lang, 'News.ArticleListForm.ArchiveCategory.Validation.Required.Missing', 'Archiv oder Kategorie auswählen');

//News Article Content

$translator->AddTranslation($lang, 'News.ArticleContent.BackendName', 'Artikel');
$translator->AddTranslation($lang, 'News.ArticleContentForm.Title', 'Artikel');
$translator->AddTranslation($lang, 'News.ArticleContentForm.Description', 'Das Element "Artikel" stellt einen einzelnen Artikel. Dieser wird über den Parameter "article" übergeben.');
$translator->AddTranslation($lang, 'News.ArticleContentForm.Legend', 'Artikelelement-Einstellungen');
$translator->AddTranslation($lang, 'News.ArticleContentForm.NotAvailable', 'Artikel nicht verfügbar');
$translator->AddTranslation($lang, 'News.ArticleContentForm.Submit', 'Speichern');