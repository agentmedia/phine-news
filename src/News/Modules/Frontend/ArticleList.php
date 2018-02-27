<?php
namespace Phine\Bundles\News\Modules\Frontend;
use App\Phine\Database\Access;
use Phine\Bundles\Core\Logic\Module\FrontendModule;
use Phine\Bundles\News\Modules\Backend\ArticleListForm;
use App\Phine\Database\News\ContentArticleList;
use App\Phine\Database\News\Category;
use App\Phine\Database\News\Archive;
use App\Phine\Database\News\Article;
use Phine\Framework\Database\Sql;
use Phine\Framework\System\Http\Request;
use Phine\Framework\System\Date;
use Phine\Bundles\Core\Logic\Routing\FrontendRouter;

/**
 * The frontend article list
 */
class ArticleList extends FrontendModule
{
    /**
     * The article list
     * @var ContentArticleList 
     */
    private $articleList;
    
    /**
     * The list of articles to display
     * @var Article[]
     */
    protected $articles;
    
    /**
     * The archive the articles are in
     * @var Archive
     */
    protected $archive;
    
    /**
     * The archive category, if applicable
     * @var Category
     */
    protected $category;
    
    /**
     * The amount of articles
     * @var int
     */
    private $articlesTotal;
    
    /**
     * Initializes the artlice list frontend view
     * @return bool Returns false So rendering process continues
     */
    protected function Init()
    {
        $this->articles = array();
        $this->articleList = ContentArticleList::Schema()->ByContent($this->Content());
        $this->articlesTotal = 0;
        $this->InitArticles();
        return parent::Init();
    }
    
    protected function HasArticleUrl()
    {
        return $this->articleList->GetArticlePage() !== null;
    }
    
    protected function ArticleUrl(Article $article)
    {
        $params = array('article' => $article->GetCleanTitle());
        return FrontendRouter::PageUrl($this->articleList->GetArticlePage(), $params);
    }
    
    /**
     * Gets teh formatted create date for the article
     * @param Article $article The article
     * @return string Returns the formatted create date
     */
    protected function CreateDate(Article $article)
    {
        return $article->GetCreated()->ToString($this->archive->GetDateFormat());
    }
    
    
    /**
     * Returns true if any articles are present
     * @return boolean
     */
    protected function HasArticles()
    {
        return count($this->articles) > 0;
    }
    
    /**
     * Initializes the article array
     */
    private function InitArticles()
    {
        $this->archive = Archive::Schema()->ByPage($this->CurrentPage());
        if ($this->archive) 
        {
            $this->InitArchiveArticles();
            return;
        }
        $this->category = Category::Schema()->ByPage($this->CurrentPage());
        if ($this->category)
        {
            $this->archive = $this->category->GetArchive();
            $this->InitCategoryArticles();
        }
    }
    
    /**
     * Initializes article array for a page assigned archive
     */
    private function InitArchiveArticles()
    {
        $sql = Access::SqlBuilder();
        $tblArticle = Article::Schema()->Table();
        $tblCategory = Category::Schema()->Table();
        $join = $sql->Join($tblCategory);
        $joinCond = $sql->Equals($tblArticle->Field('Category'), $tblCategory->Field('ID'));
        $orderBy = $sql->OrderList($sql->OrderDesc($tblArticle->Field('Created')));
        $where = $this->PublishedCondition()->
                And_($sql->Equals($tblCategory->Field('Archive'), $sql->Value($this->archive->GetID())));
        $this->articles = Article::Schema()->Fetch(false, $where, $orderBy, null, 
                $this->ArticleOffset(), $this->ArticleCount(), $join, Sql\JoinType::Inner(), $joinCond);
        $this->articlesTotal = Article::Schema()->Count(false, $where, null, $join, Sql\JoinType::Inner(), $joinCond);
    }
    
    /**
     * Initializes article array for a page assigned category
     */
    private function InitCategoryArticles()
    {
        $sql = Access::SqlBuilder();
        $tblArticle = Article::Schema()->Table();
        $orderBy = $sql->OrderList($sql->OrderDesc($tblArticle->Field('Created')));
        $where = $this->PublishedCondition()->
                And_($sql->Equals($tblArticle->Field('Category'), 
                        $sql->Value($this->category->GetID())));
        $this->articles = Article::Schema()->Fetch(false, $where, $orderBy);
        $this->articlesTotal = Article::Schema()->Count(false, $where);
    }
    /**
     * The condition to retreive published articles, only
     * @return Sql\Condition Returns the sql condition for published articles
     */
    private function PublishedCondition()
    {
        $sql = Access::SqlBuilder();
        $sqlNow = $sql->Value(Date::Now());
        $tblArticle = Article::Schema()->Table();
        return $sql->Equals($tblArticle->Field('Publish'), $sql->Value(true))
                    ->And_($sql->IsNull($tblArticle->Field('PublishFrom'))
                        ->Or_($sql->LTE($tblArticle->Field('PublishFrom'), $sqlNow)))
                    ->And_($sql->IsNull($tblArticle->Field('PublishTo'))
                        ->Or_($sql->GTE($tblArticle->Field('PublishTo'), $sqlNow)));
    }
    
    /**
     * Gets the author name, if available
     * @param Article $article
     * @return string Returns the author's full name
     */
    protected function AuthorName(Article $article)
    {
        $author = $article->GetAuthor();
        return $author ? $author->GetFirstName() . ' ' . $author->GetLastName() : '';
    }
    
    /**
     * The count for the paginated database limit
     * @return type
     */
    private function ArticleCount()
    {
        return $this->archive->GetItemsPerPage(); 
    }
    
    /**
     * The offset for the database limit
     * @return int 
     */
    private function ArticleOffset()
    {
        $page = max(1, (int)Request::GetData('page'));
        return ($page - 1) * $this->archive->GetItemsPerPage();
    }
    /**
     * The "from" number of the displayed items
     * @return int Returns the 1-based offset index of the first displayed article
     */
    protected function FromNumber()
    {
        return $this->ArticleOffset() + 1;
    }
    /**
     * The "to" number of the displayed items
     * @return int Returns the 1-based index of the last displayed article
     */
    protected function ToNumber()
    {
        return $this->ArticleOffset() + count($this->articles);
    }
    
    /**
     * Returns the total amount of articles
     * @return int Returns the active articles present in the archive or category
     */
    protected function ArticlesTotal()
    {
        return $this->articlesTotal;
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
     * Returns the related backend 
     * @return ArticleListForm
     */
    public function ContentForm()
    {
        return new ArticleListForm();
    }
   
    /**
     * Gets the backend name
     * @return string Returns the name displayed in backend content tree views
     */
    public function BackendName()
    {
        $name = parent::BackendName();
        if (!$this->content || !$this->content->GetPageContent())
        {
            return $name;
        }
        $page = $this->content->GetPageContent()->GetPage();
        $category = Category::Schema()->ByPage($page);
        if ($category)
        {
            return $name . " : " . $category->GetName() . " | " . $category->GetArchive()->GetName();
        }
        $archive = Archive::Schema()->ByPage($page);
        if ($archive)
        {
            return $name . " : " . $archive->GetName();
        }
        return $name;
    }

}

