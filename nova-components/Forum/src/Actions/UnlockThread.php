<?php

namespace Acme\Forum\Actions;

use Acme\Forum\Models\Thread;

class UnlockThread extends BaseAction
{
    private Thread $thread;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

    protected function transact()
    {
        if (! $this->thread->locked) {
            return null;
        }

        $this->thread->updateWithoutTouch([
            'locked' => false,
        ]);

        return $this->thread;
    }
}
