<?php

namespace Acme\Forum\Actions\Bulk;

use Illuminate\Support\Facades\DB;
use Acme\Forum\Actions\BaseAction;
use Acme\Forum\Models\Thread;

class UnpinThreads extends BaseAction
{
    private array $threadIds;
    private bool $includeTrashed;

    public function __construct(array $threadIds, bool $includeTrashed)
    {
        $this->threadIds = $threadIds;
        $this->includeTrashed = $includeTrashed;
    }

    protected function transact()
    {
        $query = DB::table(Thread::getTableName())
            ->whereIn('id', $this->threadIds)
            ->where(['pinned' => true]);

        if (! $this->includeTrashed) {
            $query = $query->whereNull(Thread::DELETED_AT);
        }

        $threads = $query->get();

        // Return early if there are no eligible threads in the selection
        if ($threads->count() == 0) {
            return null;
        }

        $query->update(['pinned' => false]);

        return $threads;
    }
}
