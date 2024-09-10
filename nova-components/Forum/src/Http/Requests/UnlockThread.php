<?php

namespace Acme\Forum\Http\Requests;

use Acme\Forum\Actions\UnlockThread as Action;
use Acme\Forum\Events\UserUnlockedThread;

class UnlockThread extends LockThread
{
    public function fulfill()
    {
        $action = new Action($this->route('thread'));
        $thread = $action->execute();

        if ($thread !== null) {
            UserUnlockedThread::dispatch($this->user(), $thread);
        }

        return $thread;
    }
}
