<?php

namespace Phine\Bundles\News\Modules\Backend;
use App\Phine\Database\News\ContentArticle;
use Phine\Bundles\Core\Logic\Module\ContentForm;
use Phine\Bundles\News\Modules\Frontend\ArticleContent;

/**
 * The form for the article content 
 */
class ArticleContentForm extends ContentForm
{
    /**
     * The article content element
     * @var ContentArticle
     */
    protected $article;
    /**
     * Gets the related content schema
     * @return \Phine\Database\News\ContentArticleSchema
     */
    protected function ElementSchema()
    {
        return ContentArticle::Schema();
    }

    protected function FrontendModule()
    {
        return new ArticleContent();
    }
    protected function InitForm()
    {
        $this->article = $this->LoadElement();
        $this->AddCssClassField();
        $this->AddCssIDField();
        $this->AddTemplateField();
        $this->AddCacheLifetimeField();
        $this->AddSubmit();
    }

    protected function SaveElement()
    {
        return $this->article;
    }
    
    protected function Wordings()
    {
        $wordings = array();
        $wordings[] = 'NotAvailable';
        return $wordings;
    }

}
