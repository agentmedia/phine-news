<?php

namespace Phine\Bundles\News\Logic\Tree;
use Phine\Bundles\Core\Logic\Tree\TableObjectTreeProvider;
use Phine\Bundles\Core\Logic;
use App\Phine\Database\News\Archive;
use App\Phine\Database\News\Category;
use App\Phine\Database\Access;

class CategoryListProvider extends TableObjectTreeProvider
{
    use Logic\Tree\ListProvider;
    
    /**
     * The news archive
     * @var Archive
     */
    private $archive;
    
    /**
     * Creates the category list provicer
     * @param Archive $archive The archive the categories belong to
     */
    function __construct(Archive $archive)
    {
        $this->archive = $archive;
    }
    /**
     * Gets the next category in the archive
     * @param Category $item The category the next neighbor relates to
     */
    public function NextOf($item)
    {
        return Category::Schema()->ByPrevious($item);
    }

    /**
     * Gets the previous category in the archive
     * @param Category $item The category whose predecessor is asked for
     */
    public function PreviousOf($item)
    {
        return $item->GetPrevious();
    }

    /**
     * Sets the previous category
     * @param Category $item The category whose previous item is set
     * @param Category $previous The previous category
     */
    public function SetPrevious($item, $previous)
    {
        $item->SetPrevious($previous);
    }
    
    /**
     * Gets the very first category in the archive
     * @return Category
     */
    public function TopMost()
    {
        $sql = Access::SqlBuilder();
        $tblCategory = Category::Schema()->Table();
        $where = $sql->Equals($tblCategory->Field('Archive'), $sql->Value($this->archive->GetID()))
                ->And_($sql->IsNull($tblCategory->Field('Previous')));
        
        return Category::Schema()->First($where);
    }

}
