<?php

namespace Acme\Forum\Events;

use Acme\Forum\Events\Types\ThreadEvent;
use Acme\Forum\Models\Category;
use Acme\Forum\Models\Thread;

class UserMovedThread extends ThreadEvent
{
    public Category $destinationCategory;

    public function __construct($user, Thread $thread, Category $destinationCategory)
    {
        parent::__construct($user, $thread);

        $this->destinationCategory = $destinationCategory;
    }
}
