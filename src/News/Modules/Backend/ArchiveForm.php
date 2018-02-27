<?php
namespace Phine\Bundles\News\Modules\Backend;
use Phine\Bundles\Core\Logic\Module\BackendForm;
use Phine\Bundles\Core\Logic\Routing\BackendRouter;
use Phine\Framework\System\Http\Response;
use Phine\Framework\System\Http\Request;
use Phine\Framework\FormElements\Fields\Input;
use Phine\Bundles\News\Logic\Enums\MetaPlacement;
use App\Phine\Database\News\Archive;
use Phine\Framework\FormElements\Fields\Select;
use Phine\Framework\Validation\Integer;
/**
 * Form for a news archive
 */
class ArchiveForm extends BackendForm
{
    /**
     * The archive stored in database
     * @var Archive
     */
    protected $archive;
    
    protected function Init()
    {
        $this->archive = new Archive(Request::GetData('archive'));
        $this->AddNameField();
        $this->AddItemsPerPageField();
        $this->AddDateFormatField();
        $this->AddMetaTitlePlacementField();
        $this->AddMetaDescriptionPlacementField();
        $this->AddSubmit();
        return parent::Init();
    }
    /**
     * Adds the items per page field
     */
    private function AddItemsPerPageField()
    {
        $name = 'ItemsPerPage';
        $val = $this->archive->Exists() ? $this->archive->GetItemsPerPage() : 10;
        $this->AddField(Input::Text($name, $val));
        $this->SetRequired($name);
        $this->AddValidator($name, new Integer(1));
    }
    
    /**
     * Adds the name text field
     */
    private function AddNameField()
    {
        $name = 'Name';
        $field = Input::Text($name, $this->archive->GetName());
        $this->AddField($field);
        $this->SetRequired($name);
    }
    
    /**
     * Adds the date format text field
     */
    private function AddDateFormatField()
    {
        $name = 'DateFormat';
        $value = $this->archive->GetDateFormat() ?: Trans('News.ArchiveForm.DateFormat.Default');
        $field = Input::Text($name, $value);
        $this->AddField($field);
        $this->SetRequired($name);
    }
    
    /**
     * Adds the meta title placement select field
     */
    private function AddMetaTitlePlacementField()
    {
        $name = 'MetaTitlePlacement';
        $value = $this->archive->GetMetaTitlePlacement() ?: MetaPlacement::Prepend()->Value();
        $this->AddMetaPlacementSelect($name, $value);
    }
    
    /**
     * Adds the meta descripton placement field
     */
    private function AddMetaDescriptionPlacementField()
    {
        $name = 'MetaDescriptionPlacement';
        $value = $this->archive->GetMetaDescriptionPlacement() ?: MetaPlacement::Prepend()->Value();
        $this->AddMetaPlacementSelect($name, $value);
    }
    
    private function AddMetaPlacementSelect($name, $value)
    {
        $field = new Select($name, $value);
        foreach (MetaPlacement::AllowedValues() as $val)
        {
            $field->AddOption($val, Trans("News.MetaPlacement.$val"));
        }
        $this->AddField($field);
    }
    
    protected function BackLink()
    {
        return BackendRouter::ModuleUrl(new ArchiveList());
    }
    
    protected function OnSuccess()
    {
        $isNew = !$this->archive->Exists();
        $this->archive->SetName($this->Value('Name'));
        $this->archive->SetItemsPerPage($this->Value('ItemsPerPage'));
        $this->archive->SetDateFormat($this->Value('DateFormat'));
        $this->archive->SetMetaTitlePlacement($this->Value('MetaTitlePlacement'));
        $this->archive->SetMetaDescriptionPlacement($this->Value('MetaDescriptionPlacement'));
        $this->archive->Save();
        $this->Redirect($isNew);
    }
    
    private function Redirect($isNew)
    {
        if (!$isNew)
        {
            Response::Redirect(BackendRouter::ModuleUrl(new ArchiveList()));
        }
        else
        {
            Response::Redirect(BackendRouter::ModuleUrl(new CategoryList(), array('archive'=>$this->archive->GetID())));
        }
    }

}

