<?php

namespace Acme\Forum\Events;

use Illuminate\Database\Eloquent\Collection;
use Acme\Forum\Events\Types\CollectionEvent;
use Acme\Forum\Models\Category;

class UserMarkedThreadsAsRead extends CollectionEvent
{
    public ?Category $category;

    public function __construct($user, ?Category $category, Collection $threads)
    {
        parent::__construct($user, $threads);

        $this->category = $category;
    }
}
