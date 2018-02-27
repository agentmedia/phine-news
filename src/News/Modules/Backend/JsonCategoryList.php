<?php

namespace Phine\Bundles\News\Modules\Backend;

use Phine\Bundles\Core\Modules\Backend\Base\JsonTree;
use App\Phine\Database\News\Category;
use Phine\Bundles\News\Logic\Tree\CategoryListProvider;


class JsonCategoryList extends JsonTree
{    
    protected function TableSchema()
    {
        return Category::Schema();
    }
    
    protected function TreeProvider()
    {
        return new CategoryListProvider($this->item->GetArchive());
    }
}
