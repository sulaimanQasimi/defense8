<?php

namespace Acme\Forum\Events;

use Acme\Forum\Events\Types\BaseEvent;

class UserViewingIndex extends BaseEvent
{
    /** @var mixed */
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }
}
