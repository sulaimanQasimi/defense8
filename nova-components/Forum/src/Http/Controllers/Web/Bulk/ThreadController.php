<?php

namespace Acme\Forum\Http\Controllers\Web\Bulk;

use Illuminate\Http\RedirectResponse;
use Acme\Forum\Http\Controllers\Web\BaseController;
use Acme\Forum\Http\Requests\Bulk\DeleteThreads;
use Acme\Forum\Http\Requests\Bulk\LockThreads;
use Acme\Forum\Http\Requests\Bulk\MoveThreads;
use Acme\Forum\Http\Requests\Bulk\PinThreads;
use Acme\Forum\Http\Requests\Bulk\RestoreThreads;
use Acme\Forum\Http\Requests\Bulk\UnlockThreads;
use Acme\Forum\Http\Requests\Bulk\UnpinThreads;

class ThreadController extends BaseController
{
    public function move(MoveThreads $request): RedirectResponse
    {
        $result = $request->fulfill();

        if ($result === null) {
            return $this->invalidSelectionResponse();
        }

        return $this->bulkActionResponse($result->count(), 'threads.updated');
    }

    public function lock(LockThreads $request): RedirectResponse
    {
        $result = $request->fulfill();

        if ($result === null) {
            return $this->invalidSelectionResponse();
        }

        return $this->bulkActionResponse($result->count(), 'threads.updated');
    }

    public function unlock(UnlockThreads $request): RedirectResponse
    {
        $result = $request->fulfill();

        if ($result === null) {
            return $this->invalidSelectionResponse();
        }

        return $this->bulkActionResponse($result->count(), 'threads.updated');
    }

    public function pin(PinThreads $request): RedirectResponse
    {
        $result = $request->fulfill();

        if ($result === null) {
            return $this->invalidSelectionResponse();
        }

        return $this->bulkActionResponse($result->count(), 'threads.updated');
    }

    public function unpin(UnpinThreads $request): RedirectResponse
    {
        $result = $request->fulfill();

        if ($result === null) {
            return $this->invalidSelectionResponse();
        }

        return $this->bulkActionResponse($result->count(), 'threads.updated');
    }

    public function delete(DeleteThreads $request): RedirectResponse
    {
        $result = $request->fulfill();

        if ($result === null) {
            return $this->invalidSelectionResponse();
        }

        return $this->bulkActionResponse($result->count(), 'threads.deleted');
    }

    public function restore(RestoreThreads $request): RedirectResponse
    {
        $result = $request->fulfill();

        if ($result === null) {
            return $this->invalidSelectionResponse();
        }

        return $this->bulkActionResponse($result->count(), 'threads.updated');
    }
}
