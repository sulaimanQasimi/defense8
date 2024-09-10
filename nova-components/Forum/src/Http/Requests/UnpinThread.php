<?php

namespace Acme\Forum\Http\Requests;

use Acme\Forum\Actions\UnpinThread as Action;
use Acme\Forum\Events\UserUnpinnedThread;

class UnpinThread extends PinThread
{
    public function fulfill()
    {
        $action = new Action($this->route('thread'));
        $thread = $action->execute();

        if ($thread !== null) {
            UserUnpinnedThread::dispatch($this->user(), $thread);
        }

        return $thread;
    }
}
