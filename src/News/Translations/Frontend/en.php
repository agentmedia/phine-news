<?php

use Phine\Framework\Localization\PhpTranslator;
$translator = PhpTranslator::Singleton();
$lang = 'en';

$translator->AddTranslation($lang, 'News.ArticleList.DisplayArticles.From_{0}.To_{1}.Of_{2}', 'Article {0} to {1} out of {2}');
$translator->AddTranslation($lang, 'News.ArticleList.ReadMore', 'Read More');