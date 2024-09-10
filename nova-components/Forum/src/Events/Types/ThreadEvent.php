<?php

namespace Acme\Forum\Events\Types;

use Acme\Forum\Models\Thread;

class ThreadEvent extends BaseEvent
{
    /** @var mixed */
    public $user;

    public Thread $thread;

    public function __construct($user, Thread $thread)
    {
        $this->user = $user;
        $this->thread = $thread;
    }
}
