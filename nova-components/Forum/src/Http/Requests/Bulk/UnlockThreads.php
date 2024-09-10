<?php

namespace Acme\Forum\Http\Requests\Bulk;

use Acme\Forum\Actions\Bulk\UnlockThreads as Action;
use Acme\Forum\Events\UserBulkUnlockedThreads;

class UnlockThreads extends LockThreads
{
    public function fulfill()
    {
        $action = new Action($this->validated()['threads'], $this->user()->can('viewTrashedThreads'));
        $threads = $action->execute();

        if ($threads !== null) {
            UserBulkUnlockedThreads::dispatch($this->user(), $threads);
        }

        return $threads;
    }
}
