<?php

namespace Acme\Forum\Actions\Bulk;

use Acme\Forum\Actions\BaseAction;
use Acme\Forum\Models\Category;

class ManageCategories extends BaseAction
{
    private array $categoryData;

    public function __construct(array $categoryData)
    {
        $this->categoryData = $categoryData;
    }

    protected function transact()
    {
        return Category::rebuildTree($this->categoryData);
    }
}
