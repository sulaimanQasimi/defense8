<?php

namespace Acme\Forum\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Acme\Forum\Actions\DeleteThread as Action;
use Acme\Forum\Events\UserDeletedThread;
use Acme\Forum\Http\Requests\Traits\HandlesDeletion;
use Acme\Forum\Interfaces\FulfillableRequest;

class DeleteThread extends FormRequest implements FulfillableRequest
{
    use HandlesDeletion;

    public function authorize(): bool
    {
        $thread = $this->route('thread');

        return $this->user()->can('deleteThreads', $thread->category) && $this->user()->can('delete', $thread);
    }

    public function rules(): array
    {
        return [
            'permadelete' => ['boolean'],
        ];
    }

    public function fulfill()
    {
        $action = new Action($this->route('thread'), $this->isPermaDeleting());
        $thread = $action->execute();

        if (! $thread === null) {
            UserDeletedThread::dispatch($this->user(), $thread);
        }

        return $thread;
    }
}
