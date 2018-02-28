<?php
namespace Phine\Bundles\News\Modules\Frontend;

use Phine\Bundles\Core\Logic\Module\FrontendModule;
use Phine\Bundles\News\Modules\Backend\ArticleContentForm;
use App\Phine\Database\News\Article;
use Phine\Framework\System\Http\Request;
use Phine\Bundles\Core\Logic\Util\PublishDateUtil;
use App\Phine\Database\News\Archive;
use App\Phine\Database\News\Category;
use Phine\Bundles\News\Logic\Enums\MetaPlacement;
use Phine\Bundles\Core\Logic\Rendering\PageRenderer;

/**
 * The frontend article view
 */
class ArticleContent extends FrontendModule
{
    /**
     * The news article 
     * @var Article
     */
    protected $article;
    
    /**
     *
     * @var Category
     */
    protected $category;
    
    /**
     *
     * @var Archive
     */
    protected $archive;
    /**
     * Initializes the artlice list frontend view
     * @return bool Returns false So rendering process continues
     */
    protected function Init()
    {
        $this->article = Article::Schema()->ByCleanTitle(Request::GetData('article'));
        if ($this->article && !$this->CheckPublished()) {
            $this->article = null;
        }
        if ($this->article) {
            $this->category = $this->article->GetCategory();
            $this->archive = $this->category->GetArchive();
            $this->InitMetaTitle();
            $this->InitMetaDescription();
        }
        return parent::Init();
    }
    
    private function InitMetaTitle() {
        switch ($this->archive->GetMetaTitlePlacement()) {
            case MetaPlacement::Append():
                PageRenderer::AppendToTitle($this->article->GetTitle());
                break;
            
            case MetaPlacement::Prepend():
                PageRenderer::PrependToTitle($this->article->GetTitle());
                break;
            
            case MetaPlacement::Replace():
                PageRenderer::$Title = $this->article->GetTitle();
                break;
        }
    }
    
    private function InitMetaDescription() {
        $teaser = trim(strip_tags($this->article->GetTeaser()));
        if (!$teaser) {
            return;
        }
        switch ($this->archive->GetMetaDescriptionPlacement()) {
            case MetaPlacement::Append():
                PageRenderer::AppendToDescriptoin($teaser);
                break;
            
            case MetaPlacement::Prepend():
                PageRenderer::PrependToDescription($teaser);
                break;
            
            case MetaPlacement::Replace():
                PageRenderer::$Description = $teaser;
                break;
        }
    }
    
    /**
     * Checks if current article is published at this moment
     * @return boolean Returns true if the article exists and is published now
     */
    private function CheckPublished()
    {
        return PublishDateUtil::IsPublishedNow($this->article->GetPublish(), 
                $this->article->GetPublishFrom(), $this->article->GetPublishTo());
    }
    
    /**
     * Gets the formatted create date for the article
     * @return string Returns the formatted create date
     */
    protected function CreateDate()
    {  
        return $this->article->GetCreated()->ToString($this->archive->GetDateFormat());
    }
    
    /**
     * Gets the author name, if available
     * @return string Returns the author's full name
     */
    protected function AuthorName()
    {
        $author = $this->article->GetAuthor();
        return $author ? $author->GetFirstName() . ' ' . $author->GetLastName() : '';
    }
    
    /**
     * The article list has no children
     * @return boolean
     */
    public function AllowChildren()
    {
        return false;
    }

    /**
     * Returns the related backend form
     * @return ArticleContentForm
     */
    public function ContentForm()
    {
        return new ArticleContentForm();
    }

}

