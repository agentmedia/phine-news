<?php

namespace Phine\Bundles\News\Modules\Backend;
use Phine\Bundles\Core\Logic\Module\BackendForm;
use App\Phine\Database\News\Category;
use App\Phine\Database\News\Archive;

use Phine\Framework\System\Http\Request;
use Phine\Framework\System\Http\Response;
use Phine\Framework\FormElements\Fields\Input;
use Phine\Framework\Validation\DatabaseCount;
use App\Phine\Database\Access;
use Phine\Bundles\News\Logic\Tree\CategoryListProvider;
use Phine\Bundles\Core\Logic\Tree\TreeBuilder;
use Phine\Bundles\Core\Logic\Routing\BackendRouter;

class CategoryForm extends BackendForm
{
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
     *
     * @var category;
     */
    protected $previous;
    protected function Init()
    {
        $this->archive = Archive::Schema()->ByID(Request::GetData('archive'));
        if (!$this->archive)
        {
            throw new \Exception("Missing or invalid parameter 'archive'");
        }
        $this->category = new Category(Request::GetData('category'));
        $this->previous = Category::Schema()->ByID(Request::GetData('previous'));
        $this->AddNameField();
        $this->AddSubmit();
        return parent::Init();
    }
    
    private function AddNameField()
    {
        $name = 'Name';
        $field = Input::Text($name, $this->category->GetName());
        $this->AddField($field);
        $this->SetRequired($name);
        $sql = Access::SqlBuilder();
        $tblCategory = Category::Schema()->Table();
        $andCondition = $sql->Equals($tblCategory->Field('Archive'), $sql->Value($this->archive->GetID()));
        $validator = DatabaseCount::UniqueFieldAnd($this->category, $name, $andCondition);
        $this->AddValidator($name, $validator);
    }
    protected function OnSuccess()
    {
        $isNew = !$this->category->Exists();
        $this->category->SetName($this->Value('Name'));
        if ($isNew)
        {
            $this->category->SetArchive($this->archive);
            $tree = new TreeBuilder(new CategoryListProvider($this->archive));
            $tree->Insert($this->category, null, $this->previous);
        }
        else
        {
            $this->category->Save();
        }
        Response::Redirect($this->BackLink());
    }
    
    protected function BackLink()
    {
        return BackendRouter::ModuleUrl(new CategoryList(), array('archive'=>$this->archive->GetID()));
    }

}

