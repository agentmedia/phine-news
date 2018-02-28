<?php

use Phine\Framework\Localization\PhpTranslator;
$translator = PhpTranslator::Singleton();
$lang = 'de';

$translator->AddTranslation($lang, 'News.ArticleList.DisplayArticles.From_{0}.To_{1}.Of_{2}', 'Artikel {0} bis {1} von {2}');
$translator->AddTranslation($lang, 'News.ArticleList.ReadMore', 'Weiterlesen');