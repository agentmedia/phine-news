<?php

namespace Phine\Bundles\News\Modules\Backend;

use Phine\Framework\FormElements\Fields\Select;
use App\Phine\Database\Access;
use App\Phine\Database\News\ContentArticleList;
use App\Phine\Database\News\Archive;
use App\Phine\Database\News\Category;
use Phine\Bundles\Core\Logic\Module\ContentForm;
use Phine\Bundles\News\Modules\Frontend;
use Phine\Bundles\News\Logic\Tree\CategoryListProvider;
use Phine\Bundles\Core\Snippets\FormParts\PageSelector;

class ArticleListForm extends ContentForm
{

    /**
     * The article list content
     * @var ContentArticleList
     */
    protected $articleList;

    /**
     * True if the article list is within a page
     * @var boolean
     */
    protected $hasValidLocation;
    
    /**
     * The selector for the article page
     * @var PageSelector
     */
    protected $articlePageSelector;

    /**
     * Gets the related database table schema
     * @return \Phine\Database\News\ContentArticleListSchema
     */
    protected function ElementSchema()
    {
        return ContentArticleList::Schema();
    }

    /**
     * Returns the related frontend module used for rendering
     * @return ArticleList
     */
    protected function FrontendModule()
    {
        return new Frontend\ArticleList();
    }

    protected function InitForm()
    {
        $this->articleList = $this->LoadElement();
        $this->hasValidLocation = $this->Page()->Exists();
        if ($this->hasValidLocation) {
            $this->AddArchiveCategoryField();
            $this->AddArticlePageSelector();
            $this->AddCssClassField();
            $this->AddCssIDField();
            $this->AddTemplateField();
            $this->AddCacheLifetimeField();
            $this->AddSubmit();
        }
        return false;
    }

    /**
     * Gets the wordings necessary to customize frontend
     * @return string[]
     */
    protected function Wordings()
    {
        $wordings = array();
        $wordings[] = 'NoArticles';
        $wordings[] = 'DisplayArticles.From_{0}.To_{1}.Of_{2}';
        return $wordings;
    }
    private function AddArchiveCategoryField()
    {
        $name = 'ArchiveCategory';
        $field = new Select($name, $this->ArchiveCategoryValue());
        $field->AddOption('', Trans('Core.PleaseSelect'));
        $sql = Access::SqlBuilder();
        $tblArchive = Archive::Schema()->Table();
        $orderBy = $sql->OrderList($sql->OrderAsc($tblArchive->Field('Name')));
        $archives = Archive::Schema()->Fetch(false, null, $orderBy);
        foreach ($archives as $archive) {
            $field->AddOption($archive->GetID(), $archive->GetName());
            $list = new CategoryListProvider($archive);
            $categories = $list->ToArray();
            foreach ($categories as $category) {
                $field->AddOption($archive->GetID() . '-' . $category->GetID(), '- ' . $category->GetName());
            }
        }
        $this->AddField($field);
        $this->SetRequired($name);
    }
    
    /**
     * Adds the article page selector element
     */
    private function AddArticlePageSelector()
    {
        $name = 'ArticlePage';
        $this->articlePageSelector = new PageSelector($name, Trans($this->Label($name)), 
                $this->articleList->GetArticlePage());
        
        $this->articlePageSelector->SetSite($this->Page()->GetSite());
        $this->Elements()->AddElement($name, $this->articlePageSelector);
    }
    
    /**
     * Calculates the value for the combined archive/category select box
     * @return string Returns either the archive id or a archive id and category id joined by "-"
     */
    private function ArchiveCategoryValue()
    {
        if (!$this->articleList->Exists()) {
            return '';
        }
        $archive = Archive::Schema()->ByPage($this->Page());
        if ($archive) {
            return $archive->GetID();
        }
        $category = Category::Schema()->ByPage($this->Page());
        if ($category) {
            return $category->GetArchive()->GetID() . '-' .
                    $category->GetID();
        }
    }
    
    /**
     * Saves article list and attaches current page to chosen archive or category
     */
    protected function SaveElement()
    {
        $this->articleList->SetArticlePage($this->articlePageSelector->GetPage());
        $archiveCat = explode('-', $this->Value('ArchiveCategory'));
        $this->CleanPageArticleLists();
        if (count($archiveCat) == 1) {
            $this->SaveArchivePage($archiveCat[0]);
        }
        else if (count($archiveCat) == 2) {
            $this->SaveCategoryPage($archiveCat[1]);
        }
        return $this->articleList;
    }
    
    /**
     * Sets page null on any news archive/category relating to the current page
     */
    private function CleanPageArticleLists()
    {
        $oldArchive = Archive::Schema()->ByPage($this->Page());
        if ($oldArchive) {
            $oldArchive->SetPage(null);
            $oldArchive->Save();
        }
        $oldCategory = Category::Schema()->ByPage($this->Page());
        if ($oldCategory) {
            $oldCategory->SetPage(null);
            $oldCategory->Save();
        }
    }
    
    /**
     * Sets the current page to the chosen archive, if no category chosen
     * @param int $archiveID The id of the archive
     */
    private function SaveArchivePage($archiveID)
    {
        $archive = Archive::Schema()->ByID($archiveID);
        if ($archive) {
            $archive->SetPage($this->Page());
            $archive->Save();
        }
    }

    /**
     * Sets the current page tor the chosen category, if no archive chosen
     * @param int $categoryID The id of the category
     */
    private function SaveCategoryPage($categoryID)
    {
        $category = Category::Schema()->ByID($categoryID);
        if ($category) {
            $category->SetPage($this->Page());
            $category->Save();
        }
    }

}
