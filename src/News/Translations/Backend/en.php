<?php

use Phine\Framework\Localization\PhpTranslator;
$translator = PhpTranslator::Singleton();

$lang = 'en';
//Navigation
$translator->AddTranslation($lang, 'News.NavTitle', 'News');
$translator->AddTranslation($lang, 'News.ArchiveList.NavTitle', 'News Archives');
$translator->AddTranslation($lang, 'News.OverviewTitle', 'News Module');
$translator->AddTranslation($lang, 'News.OverviewDescription', 'News Articles on your web pages');
$translator->AddTranslation($lang, 'News.ArchiveList.OverviewTitle', 'News Archives');
$translator->AddTranslation($lang, 'News.ArchiveList.OverviewDescription', 'Organize your news articles in archives and categories.');

//News Archive List
$translator->AddTranslation($lang, 'News.ArchiveList.Title', 'News Archive List');
$translator->AddTranslation($lang, 'News.ArchiveList.Description.Amount_{0}', 'There are currently {0} news archives controlled by your phine installation.');
$translator->AddTranslation($lang, 'News.ArchiveList.New', 'Create Archive');
$translator->AddTranslation($lang, 'News.ArchiveList.Name', 'Name');
$translator->AddTranslation($lang, 'News.ArchiveList.Categories', 'View/Edit categories');
$translator->AddTranslation($lang, 'News.ArchiveList.Articles', 'View/Edit articles');
$translator->AddTranslation($lang, 'News.ArchiveList.Edit', 'Edit archive');
$translator->AddTranslation($lang, 'News.ArchiveList.Delete', 'Delete archive');

//News Archive Form
$translator->AddTranslation($lang, 'News.ArchiveForm.Title', 'Edit Archive');
$translator->AddTranslation($lang, 'News.ArchiveForm.Description', 'Here you can edit the base settings of the archive.');
$translator->AddTranslation($lang, 'News.ArchiveForm.Description', 'Here you can edit the base settings of the archive.');
$translator->AddTranslation($lang, 'News.ArchiveForm.Legend', 'Archive Settings');
$translator->AddTranslation($lang, 'News.ArchiveForm.Name', 'Name');
$translator->AddTranslation($lang, 'News.ArchiveForm.ItemsPerPage', 'Items per Page');
$translator->AddTranslation($lang, 'News.ArchiveForm.DateFormat', 'Date Format');
$translator->AddTranslation($lang, 'News.ArchiveForm.DateFormat.Default', 'Y-m-d H:i:s');
$translator->AddTranslation($lang, 'News.ArchiveForm.MetaTitlePlacement', 'News Title to Page Title');
$translator->AddTranslation($lang, 'News.ArchiveForm.MetaDescriptionPlacement', 'News Teaser to Page Meta');
$translator->AddTranslation($lang, 'News.MetaPlacement.Prepend', 'Prepend');
$translator->AddTranslation($lang, 'News.MetaPlacement.Append', 'Append');
$translator->AddTranslation($lang, 'News.MetaPlacement.Replace', 'Replace');
$translator->AddTranslation($lang, 'News.MetaPlacement.None', 'None');
$translator->AddTranslation($lang, 'News.ArchiveForm.Submit', 'Save');
$translator->AddTranslation($lang, 'News.ArchiveForm.Name.Validation.Required.Missing', 'The archive name is obligatory');
$translator->AddTranslation($lang, 'News.ArchiveForm.ItemsPerPage.Validation.Required.Missing', 'Define number of articles per page');
$translator->AddTranslation($lang, 'News.ArchiveForm.ItemsPerPage.Validation.Integer.HasNonDigits', 'A positive number is required');
$translator->AddTranslation($lang, 'News.ArchiveForm.ItemsPerPage.Validation.Integer.ExceedsMin_{0}', 'A positive number is required');    
$translator->AddTranslation($lang, 'News.ArchiveForm.DateFormat.Validation.Required.Missing', 'Define date format for article dates');

/* Category list */
$translator->AddTranslation($lang, 'News.CategoryList.Title', 'Categories');
$translator->AddTranslation($lang, 'News.CategoryList.Description', 'Here you can edit the categories in the news archive.');
$translator->AddTranslation($lang, 'News.CategoryList.CreateAfter', 'Create category after this one');
$translator->AddTranslation($lang, 'News.CategoryList.Cut', 'Cut category to move it');
$translator->AddTranslation($lang, 'News.CategoryList.Edit', 'Edit category');
$translator->AddTranslation($lang, 'News.CategoryList.Delete', 'Delete category');
$translator->AddTranslation($lang, 'News.CategoryList.Back', 'Back to parent archive');

/* Category form */
$translator->AddTranslation($lang, 'News.CategoryForm.Title', 'Edit category');
$translator->AddTranslation($lang, 'News.CategoryForm.Description', 'Fit the category settings to your needs, here.');
$translator->AddTranslation($lang, 'News.CategoryForm.Legend', 'Category Settings');
$translator->AddTranslation($lang, 'News.CategoryForm.Name', 'Name');
$translator->AddTranslation($lang, 'News.CategoryForm.Submit', 'Save');

/* article list */
$translator->AddTranslation($lang, 'News.ArticleList.Title', 'Articles in this Archive');
$translator->AddTranslation($lang, 'News.ArticleList.Description.Amount_{0}', '{0} article(s) written in this archive');
$translator->AddTranslation($lang, 'News.ArticleList.New', 'Write new article');
$translator->AddTranslation($lang, 'News.ArticleList.ArticleTitle', 'Title');
$translator->AddTranslation($lang, 'News.ArticleList.Edit', 'Edit article');
$translator->AddTranslation($lang, 'News.ArticleList.Delete', 'Delete article');

/* Article form */
$translator->AddTranslation($lang, 'News.ArticleForm.Title', 'Edit Article');
$translator->AddTranslation($lang, 'News.ArticleForm.Description', 'Define Headline and content texts of your article, here.');
$translator->AddTranslation($lang, 'News.ArticleForm.Legend', 'Article Settings');
$translator->AddTranslation($lang, 'News.ArticleForm.Category', 'Category');
$translator->AddTranslation($lang, 'News.ArticleForm.Author', 'Author');
$translator->AddTranslation($lang, 'News.ArticleForm.Title', 'Title');
$translator->AddTranslation($lang, 'News.ArticleForm.Teaser', 'Teaser Text');
$translator->AddTranslation($lang, 'News.ArticleForm.Text', 'Main Text');
$translator->AddTranslation($lang, 'News.ArticleForm.PublishLegend', 'Publishing');
$translator->AddTranslation($lang, 'News.ArticleForm.Publish', 'Publish');
$translator->AddTranslation($lang, 'News.ArticleForm.PublishFromDate', 'Visible from');
$translator->AddTranslation($lang, 'News.ArticleForm.PublishFromHour', 'Hrs.');
$translator->AddTranslation($lang, 'News.ArticleForm.PublishFromMinute', 'Min.');
$translator->AddTranslation($lang, 'News.ArticleForm.PublishToDate', 'Visible to');
$translator->AddTranslation($lang, 'News.ArticleForm.PublishToHour', 'Hrs.');
$translator->AddTranslation($lang, 'News.ArticleForm.PublishToMinute', 'Min.');
$translator->AddTranslation($lang, 'News.ArticleForm.Submit', 'Save');

//News Article List Content
$translator->AddTranslation($lang, 'News.ArticleList.BackendName', 'Article List');
$translator->AddTranslation($lang, 'News.ArticleListForm.Title', 'Article List');
$translator->AddTranslation($lang, 'News.ArticleListForm.Description', 'The article list element shows articles within a category or a complete archive.');
$translator->AddTranslation($lang, 'News.ArticleListForm.Legend', 'Article List Settings');
$translator->AddTranslation($lang, 'News.ArticleListForm.ArchiveCategory', 'Archive / Category');
$translator->AddTranslation($lang, 'News.ArticleListForm.ArticlePage', 'Article Page');
$translator->AddTranslation($lang, 'News.ArticleListForm.NoArticles', 'Empty result');
$translator->AddTranslation($lang, 'News.ArticleListForm.DisplayArticles-From_{0}-To_{1}-Of_{2}', 'Showing Articles {0] to {1} of {2}');
$translator->AddTranslation($lang, 'News.ArticleListForm.Submit', 'Save');
$translator->AddTranslation($lang, 'News.ArticleListForm.ArchiveCategory.Validation.Required.Missing', 'Select an archive or a category');

//News Article Content

$translator->AddTranslation($lang, 'News.ArticleContent.BackendName', 'Article');
$translator->AddTranslation($lang, 'News.ArticleContentForm.Title', 'Article');
$translator->AddTranslation($lang, 'News.ArticleContentForm.Description', 'The article element displays a single article, technically given by url parameter article containing the clean title.');
$translator->AddTranslation($lang, 'News.ArticleContentForm.Legend', 'Article Element Settings');
$translator->AddTranslation($lang, 'News.ArticleContentForm.NotAvailable', 'Article not available');
$translator->AddTranslation($lang, 'News.ArticleContentForm.Submit', 'Save');

