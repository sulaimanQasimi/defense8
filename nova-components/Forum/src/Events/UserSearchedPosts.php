<?php

namespace Acme\Forum\Events;

use Illuminate\Pagination\LengthAwarePaginator;
use Acme\Forum\Events\Types\BaseEvent;
use Acme\Forum\Models\Category;

class UserSearchedPosts extends BaseEvent
{
    /** @var mixed */
    public $user;

    public ?Category $category;
    public string $term;
    public LengthAwarePaginator $results;

    public function __construct($user, ?Category $category, string $term, LengthAwarePaginator $results)
    {
        $this->category = $category;
        $this->term = $term;
        $this->results = $results;
    }
}
