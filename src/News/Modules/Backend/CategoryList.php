<?php
namespace Phine\Bundles\News\Modules\Backend;
use Phine\Bundles\Core\Logic\Module\BackendModule;
use Phine\Bundles\Core\Logic\Module\Traits;
use App\Phine\Database\News\Archive;
use App\Phine\Database\News\Category;
use Phine\Framework\System\Http\Request;
use Phine\Bundles\Core\Logic\Routing\BackendRouter;
use Phine\Bundles\Core\Logic\Access\Backend\Enums\BackendAction;
use Phine\Bundles\News\Logic\Tree\CategoryListProvider;
/**
 * The category list
 */
class CategoryList extends BackendModule
{
    
    use Traits\TableObjectRemover;
    /**
     * The current category of the archive
     * @var Category
     */
    protected $category;
    
    /**
     * The archive
     * @var Archive
     */
    protected $archive;
    
    /**
     *
     * @var CategoryListProvider
     */
    private $catList;
    
    /**
     * True if the archive has categories
     * @var boolean
     */
    protected $hasCategories;
    function Init()
    {
        $this->archive = Archive::Schema()->ByID(Request::GetData('archive'));
        
        if (!$this->archive)
        {
            throw new \Exception('Missing or invalid parameter archive');
        }
        
        $this->catList = new CategoryListProvider($this->archive);
        $this->category = $this->catList->TopMost();
        $this->hasCategories = (bool)$this->category;
        return parent::Init();
    }
    
    protected function NextCategory()
    {
        $category = $this->category;
        $this->category = $this->catList->NextOf($this->category);
        return $category;
    }
    protected function RemovalObject()
    {
        $id = Request::PostData('delete');
        return $id ? Category::Schema()->ByID($id) : null;
    }
    
    
    protected function CreateAfterUrl(Category $category){
        $args = array('archive'=>$this->archive->GetID(), 'previous'=>$category->GetID());
        return BackendRouter::ModuleUrl(new CategoryForm(), $args);
    }
    
    protected function FormUrl(Category $category = null)
    {
        $args = array('archive'=>$this->archive->GetID());
        if ($category)
        {
            $args['category'] = $category->GetID();
        }
        return BackendRouter::ModuleUrl(new CategoryForm(), $args);
    }
    protected function CanCreate()
    {
        return $this->Guard()->Allow(BackendAction::UseIt(), new CategoryForm());
    }
    
     /**
     * Checks the current user for having sufficient rights to delete the category
     * @param Category $category
     * @return boolean Returns true if user can delete the category
     */
    protected function CanEdit(Category $category)
    {
        return $this->Guard()->Allow(BackendAction::UseIt(), new CategoryForm());
    }
    
    /**
     * Checks the current user for having sufficient rights to delete the category
     * @param Category $category
     * @return boolean Returns true if user can delete the category
     */
    protected function CanDelete(Category $category)
    {
        return $this->CanEdit($category);
    }
    
    /**
     * The url back to the archive list
     * @return string
     */
    protected function BackLink()
    {
        return BackendRouter::ModuleUrl(new ArchiveList());
    }
    
    /**
     * The url to the json category list
     * @return type
     */
    protected function JsonUrl()
    {
        return BackendRouter::AjaxUrl(new JsonCategoryList());
    }
}
