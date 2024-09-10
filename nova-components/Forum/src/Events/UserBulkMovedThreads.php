<?php

namespace Acme\Forum\Events;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Acme\Forum\Events\Types\CollectionEvent;
use Acme\Forum\Models\Category;

class UserBulkMovedThreads extends CollectionEvent
{
    public Collection $sourceCategories;
    public Category $destinationCategory;

    public function __construct($user, SupportCollection $threads, Collection $sourceCategories, Category $destinationCategory)
    {
        parent::__construct($user, $threads);

        $this->sourceCategories = $sourceCategories;
        $this->destinationCategory = $destinationCategory;
    }
}
