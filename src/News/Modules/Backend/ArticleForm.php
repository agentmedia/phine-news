<?php

namespace Phine\Bundles\News\Modules\Backend;

use Phine\Bundles\Core\Logic\Module\BackendForm;
use Phine\Framework\System\Http\Request;
use Phine\Framework\System\Http\Response;
use Phine\Bundles\Core\Logic\Routing\BackendRouter;
use App\Phine\Database\News\Archive;
use App\Phine\Database\News\Category;
use App\Phine\Database\News\Article;
use Phine\Framework\FormElements\Fields\Input;
use Phine\Framework\FormElements\Fields\Select;
use Phine\Bundles\News\Logic\Tree\CategoryListProvider;
use App\Phine\Database\Core\User;
use App\Phine\Database\Access;
use Phine\Framework\System\Date;
use Phine\Framework\System\Str;
use Phine\Framework\FormElements\Fields\Checkbox;
/**
 * The article form
 */
class ArticleForm extends BackendForm
{
    /**
     * The pre-defined category for the article
     * @var Category
     */
    protected $category;
    
    /**
     * The archive for the article
     * @var Archive
     */
    protected $archive;
    
    /**
     * The article currently edited
     * @var Article
     */
    private $article;
    
    /**
     * The date format as defined in the current backend language
     * @var string
     */
    private $dateFormat;
    
    /**
     * Initializes the form
     * @return boolean Returns true in case rendering process can start
     */
    protected function Init()
    {
        $this->InitMembers();
        $this->InitForm();
        return parent::Init();
    }
    
    /**
     * Adds all form fields
     */
    private function InitForm()
    {
        $this->AddCategoryField();
        $this->AddTitleField();
        $this->AddTeaserField();
        $this->AddTextField();
        $this->AddPublishField();
        $this->AddPublishFromDateField();
        $this->AddPublishFromHourField();
        $this->AddPublishFromMinuteField();
        $this->AddPublishToDateField();
        $this->AddPublishToHourField();
        $this->AddPublishToMinuteField();
        $this->AddAuthorField();
        $this->AddSubmit();
    }
    
    /**
     * Initializes the class members
     * @throws \Exception Raises an error in case the archive url parameter is missing
     */
    private function InitMembers()
    {
        $this->archive = Archive::Schema()->ByID(Request::GetData('archive'));
        if (!$this->archive) {
            throw new \Exception("Missing or invalid parameter 'archive'" );
        }
        $this->article = new Article(Request::GetData('article'));
        $this->dateFormat = Trans('Core.DateFormat');
    }
    
    /**
     * Adds the category select box
     */
    private function AddCategoryField()       
    {
        $name = 'Category';
        $value = '';
        if ($this->article->Exists()) {
            $value = $this->article->GetCategory()->GetID();
        }
        $field = new Select($name, $value);
        $field->AddOption('', Trans('Core.PleaseSelect'));
        $catList = new CategoryListProvider($this->archive);
        $categories = $catList->ToArray();
        foreach ($categories as $category) {
            $field->AddOption($category->GetID(), $category->GetName());
        }
        $this->AddField($field);
        $this->SetRequired($name);
    }
    
    /**
     * Adds the title field
     */
    private function AddTitleField()
    {
        $name = 'Title';
        $this->AddField(Input::Text($name, $this->article->GetTitle()));
        $this->SetRequired($name);
    }
    
    /**
     * Adds the teaser field
     */
    private function AddTeaserField()
    {
        $name = 'Teaser';
        $this->AddRichTextField($name, $this->article->GetTeaser());
    }
    
    /**
     * Adds the text field
     */
    private function AddTextField()
    {
        $name = 'Text';
        $this->AddRichTextField($name, $this->article->GetText());
        $this->SetRequired($name);
    }
    /**
     * Adds the publish check box
     */
    private function AddPublishField()
    {
        $name = 'Publish';
        $field = new Checkbox($name, '1', (bool)$this->article->GetPublish());
        $this->AddField($field);
    }
    
    
    /**
     * Adds the publish from date field
     */
    private function AddPublishFromDateField()
    {
        $name = 'PublishFromDate';
        $from = $this->article->GetPublishFrom();
        $field = Input::Text($name, $from ? $from->ToString($this->dateFormat) : '');
        $field->SetHtmlAttribute('data-type', 'date');
        $this->AddField($field);
    }
    
    
    /**
     * Adds the publish from hour field
     */
    private function AddPublishFromHourField()
    {
        $name = 'PublishFromHour';
        $from = $this->article->GetPublishFrom();
        $field = Input::Text($name, $from ? $from->ToString('H') : '');
        $field->SetHtmlAttribute('data-type', 'hour');
        $this->AddField($field);
    }
    
    
    /**
     * Adds the publish from minute field
     */
    private function AddPublishFromMinuteField()
    {
        $name = 'PublishFromMinute';
        $from = $this->article->GetPublishFrom();
        $field = Input::Text($name, $from ? $from->ToString('i') : '');
        $field->SetHtmlAttribute('data-type', 'minute');
        $this->AddField($field);
    }
    
    /**
     * Adds the publish to date field
     */
    private function AddPublishToDateField()
    {
        $name = 'PublishToDate';
        $to = $this->article->GetPublishTo();
        $field = Input::Text($name, $to ? $to->ToString($this->dateFormat) : '');
        $field->SetHtmlAttribute('data-type', 'date');
        $this->AddField($field);
    }
    
    /**
     * Adds the publish to hour field
     */
    private function AddPublishToHourField()
    {
        $name = 'PublishToHour';
        $to = $this->article->GetPublishTo();
        $field = Input::Text($name, $to ? $to->ToString('H') : '');
        $field->SetHtmlAttribute('data-type', 'hour');
        $this->AddField($field);
    }
    
    /**
     * Adds the publish to minute field
     */
    private function AddPublishToMinuteField()
    {
        $name = 'PublishToMinute';
        $to = $this->article->GetPublishTo();
        $field = Input::Text($name, $to ? $to->ToString('i') : '');
        $field->SetHtmlAttribute('data-type', 'minute');
        $this->AddField($field);
    }
    
    /**
     * Adds the author field
     */
    private function AddAuthorField()
    {
        $name = 'Author';
        if ($this->article->Exists()) {
            $value = $this->article->GetAuthor() ? $this->article->GetAuthor()->GetID() : '';
        }
        else {
            $value = self::Guard()->GetUser()->GetID();
        }
        $field = new Select($name, $value);
        $field->AddOption('', Trans('News.Article.Author.Anonymous'));
        $sql = Access::SqlBuilder();
        $tblUser = User::Schema()->Table();
        $users = User::Schema()->Fetch(false, null, $sql->OrderList($sql->OrderAsc($tblUser->Field('Name'))));
        foreach ($users as $user) {
            $userName = $user->GetName();
            if ($user->GetFirstName() && $user->GetLastName()) {
                $userName .= ' ('. $user->GetFirstName() . ' ' . $user->GetLastName() . ')';
            }
            $field->AddOption($user->GetID(), $userName);
        }
        $this->AddField($field);
        if (!self::Guard()->GetUser()->GetIsAdmin()) {
            $field->SetHtmlAttribute('readonly', 'readonly');
        }
    }
    
    /**
     * Gets a publishing date
     * @param string $baseName The base name; 'PublishFrom' or 'PublishTo'
     * @return Date Returns the date
     */
    private function PublishDate($baseName)
    {
        if (!$this->article->GetPublish())
        {
            return null;
        }
        $strDate = $this->Value($baseName . 'Date');
        if (!$strDate)
        {
            return null;
        }
        $date = \DateTime::createFromFormat($this->dateFormat, $strDate);
        $date->setTime((int)$this->Value($baseName . 'Hour'), (int)$this->Value($baseName . 'Minute'), 0);
        return Date::FromDateTime($date);
    }
    
    /**
     * Saves the article
     */
    protected function OnSuccess()
    {
        $this->article->SetPublish($this->Value('Publish'));
        $this->article->SetPublishFrom($this->PublishDate('PublishFrom'));
        $this->article->SetPublishTo($this->PublishDate('PublishTo'));
        $this->article->SetCategory(Category::Schema()->ByID($this->Value('Category')));
        $this->article->SetTitle($this->Value('Title'));
        $this->article->SetTeaser($this->Value('Teaser'));
        $this->article->SetText($this->Value('Text'));
        $author = User::Schema()->ByID($this->Value('Author'));
        $this->article->SetAuthor($author);
        $now = Date::Now();
        $this->article->SetChanged($now);
        if (!$this->article->Exists()) {
            $this->article->SetCreated($now);
        }
        $this->article->SetCleanTitle($this->CalcCleanTitle());
        $this->article->Save();
        Response::Redirect($this->BackLink());
    }
    
    private function CalcCleanTitle() {
        $cleanTitle = Str::ToLower(Str::DefuseName($this->article->GetTitle()));
        $result = $cleanTitle;
        $exArticle = Article::Schema()->ByCleanTitle($result);
        $index = 1;
        while ($exArticle && !$exArticle->Equals($this->article)) {
            $result = $cleanTitle . '-' . $index;
            $exArticle = Article::Schema()->ByCleanTitle($result);
            ++$index;
        }
        return $result;
    }
    /**
     * Returns the best available backlink
     * @return string 
     */
    protected function BackLink()
    {  
        return BackendRouter::ModuleUrl(new ArticleList(), array('archive'=>$this->archive->GetID()));
    }
}

