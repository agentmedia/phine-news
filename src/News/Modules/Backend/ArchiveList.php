<?php

namespace Phine\Bundles\News\Modules\Backend;
use Phine\Bundles\Core\Logic\Module\BackendModule;
use Phine\Bundles\Core\Logic\Module\Traits;
use App\Phine\Database\News\Archive;
use App\Phine\Database\Access;
use Phine\Framework\System\Http\Request;
use Phine\Bundles\Core\Logic\Routing\BackendRouter;
use Phine\Bundles\Core\Modules\Backend\Overview;
use Phine\Bundles\Core\Logic\Access\Backend\Enums\BackendAction;

class ArchiveList extends BackendModule
{
    use Traits\TableObjectRemover;
    /**
     * The archives
     * @var Archive[]
     */
    protected $archives;
    protected function Init()
    {
        $sql = Access::SqlBuilder();
        $tblArchive = Archive::Schema()->Table();
        $orderBy = $sql->OrderList($sql->OrderAsc($tblArchive->Field('Name')));
        $this->archives = Archive::Schema()->Fetch(false, null, $orderBy);
        
        return parent::Init();
    }
    public function SideNavIndex()
    {
        return 1;
    }

    protected function RemovalObject()
    {
        $id = Request::PostData('delete');
        return $id ? Archive::Schema()->ByID($id) : null;
    }
    
    protected function BackLink()
    {
        return BackendRouter::ModuleUrl(new Overview());
    }
    protected function CanCreate()
    {
        return $this->Guard()->Allow(BackendAction::UseIt(), new ArchiveForm());
    }
    
    protected function CanEdit(Archive $archive)
    {
        return $this->Guard()->Allow(BackendAction::UseIt(), new ArchiveForm());
    }
    protected function ArticlesUrl(Archive $archive)
    {
        return BackendRouter::ModuleUrl(new ArticleList(), array('archive'=>$archive->GetID()));
    }
    protected function CategoriesUrl(Archive $archive)
    {
        return BackendRouter::ModuleUrl(new CategoryList(), array('archive'=>$archive->GetID()));
    }
    
    protected function CanDelete(Archive $archive)
    {
        return $this->CanEdit($archive);
    }
    
    
    protected function FormUrl(Archive $archive = null)
    {
        $params = array();
        if ($archive)
        {
            $params['archive'] = $archive->GetID();
        }
        return BackendRouter::ModuleUrl(new ArchiveForm(), $params);
    }
}
