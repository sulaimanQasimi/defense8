<?php

namespace Acme\Forum\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Acme\Forum\Actions\RenameThread as Action;
use Acme\Forum\Events\UserRenamedThread;
use Acme\Forum\Interfaces\FulfillableRequest;

class RenameThread extends FormRequest implements FulfillableRequest
{
    public function authorize(): bool
    {
        $thread = $this->route('thread');

        return $this->user()->can('rename', $thread);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3'],
        ];
    }

    public function fulfill()
    {
        $action = new Action($this->route('thread'), $this->validated()['title']);
        $thread = $action->execute();

        UserRenamedThread::dispatch($this->user(), $thread);

        return $thread;
    }
}
