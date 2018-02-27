<?php

namespace Phine\Bundles\News\Modules\Backend;

use App\Phine\Database\Access;
use Phine\Bundles\Core\Logic\Module\BackendModule;
use Phine\Bundles\Core\Logic\Module\Traits;
use App\Phine\Database\News\Archive;
use App\Phine\Database\News\Article;
use App\Phine\Database\News\Category;
use Phine\Framework\System\Http\Request;
use Phine\Framework\Database\Sql;
use Phine\Bundles\Core\Logic\Routing\BackendRouter;
use Phine\Bundles\Core\Logic\Access\Backend\Enums\BackendAction;
/**
 * The backend article list
 */
class ArticleList extends BackendModule
{
    use Traits\TableObjectRemover;
    
    /**
     * The archive of the displayed articles
     * @var Archive
     */
    protected $archive;
    
    /**
     * The category of the displayed articles
     * @var Category
     */
    protected $category;
    /**
     * Items per page
     * @var int
     */
    private $perPage = 20;
   
    /**
     * The displayed articles
     * @var Article[]
     */
    protected $articles;
    
    /**
     * The total amount of articles in the archive or category
     * @var int
     */
    protected $articlesTotal;
    
    /**
     * 
     * @return boolean Returns false
     * @throws \Exception
     */
    protected function Init()
    {
        $this->archive = Archive::Schema()->ByID(Request::GetData('archive'));
        $this->category = Category::Schema()->ByID(Request::GetData('category'));
        if ($this->category) {
            $this->archive = $this->category->GetArchive();
        }
        if (!$this->archive) {
            throw new \Exception("Missing or invalid parameter 'archive' or 'category'");
        }
        $this->InitArticles();
        return parent::Init();
    }
    /**
     * Initializes the article array
     */
    private function InitArticles()
    {
        if ($this->category) {
            $this->InitCategoryArticles();
        }
        else {
            $this->InitArchiveArticles();
        }
    }
    
    /**
     * Initializes the article array by archive
     */
    private function InitArchiveArticles()
    {
        $tblArticle = Article::Schema()->Table();
        $tblCategory = Category::Schema()->Table();
        $sql = Access::SqlBuilder();
        $where = $sql->Equals($tblCategory->Field('Archive'), $sql->Value($this->archive->GetID()));
        $join = $sql->Join($tblCategory);
        $joinCondition = $sql->Equals($tblArticle->Field('Category'), $tblCategory->Field('ID'));
        $orderBy = $sql->OrderList($sql->OrderDesc($tblArticle->Field('Created')));
        $this->articles = Article::Schema()->Fetch(false, $where, $orderBy, null, $this->ArticleOffset(), $this->perPage, $join, Sql\JoinType::Inner(), $joinCondition);
        $this->articlesTotal = Article::Schema()->Count(false, $where, null, $join, Sql\JoinType::Inner(), $joinCondition);
    }
    
    /**
     * Initializes the article array by category
     */
    private function InitCategoryArticles()
    {
        $tblArticle = Article::Schema()->Table();
        $sql = Access::SqlBuilder();
        $orderBy = $sql->OrderList($sql->OrderDesc($tblArticle->Field('Created')));
        $this->articles = Article::Schema()->FetchByCategory(false, $this->category, $orderBy, null, $this->ArticleOffset(), $this->perPage);
        $this->articlesTotal = Article::Schema()->CountByCategory(false, $this->category);
    }
    
    /**
     * The offset for the database fetch limit
     * @return int Returns the offset evaluating the GET parameter 'page'
     */
    private function ArticleOffset()
    {
        $page = max(1, (int)Request::GetData('page'));
        return ($page - 1) * $this->perPage;
    }
    
    /**
     * Gets the object to remove in case there is any
     * @return Article Returns the article to remove or null if none is requested
     */
    protected function RemovalObject()
    {
        $id = Request::PostData('delete');
        return $id ? Article::Schema()->ByID($id) : null;
    }
    
    /**
     * The backlink; either links to the category list or the archive list
     * @return string Returns the link for the back button
     */
    protected function BackLink()
    {
        if ($this->category) {
            return BackendRouter::ModuleUrl(new CategoryList(), array('archive'=>$this->archive->GetID()));
        }
        else {
            return BackendRouter::ModuleUrl(new ArchiveList());
        }
    }
    protected function CanEdit(Article $article){
        return $this->Guard()->Allow(BackendAction::UseIt(), new ArticleForm());
    }
    
    protected function CanCreate() {
        return $this->Guard()->Allow(BackendAction::UseIt(), new ArticleForm());
    }
    
    protected function CanDelete(Article $article) {
        return $this->CanEdit($article);
    }
    
    protected function FormUrl(Article $article = null)
    {
        $args = array();
        if ($this->category) {
            $args['category'] = $this->category->GetID();
        }
        else {
            $args['archive'] = $this->archive->GetID();
        }
        if ($article) {
            $args['article'] = $article->GetID();
        }
        return BackendRouter::ModuleUrl(new ArticleForm(), $args);
    }
}
