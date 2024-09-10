<?php

namespace Acme\Forum\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Acme\Forum\Actions\MoveThread as Action;
use Acme\Forum\Events\UserMovedThread;
use Acme\Forum\Http\Requests\Traits\AuthorizesAfterValidation;
use Acme\Forum\Interfaces\FulfillableRequest;
use Acme\Forum\Models\Category;

class MoveThread extends FormRequest implements FulfillableRequest
{
    use AuthorizesAfterValidation;

    private Category $destinationCategory;

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'int', 'exists:forum_categories,id'],
        ];
    }

    public function authorizeValidated(): bool
    {
        $thread = $this->route('thread');
        $destinationCategory = $this->getDestinationCategory();

        return $this->user()->can('moveThreadsFrom', $thread->category) && $this->user()->can('moveThreadsTo', $destinationCategory);
    }

    public function fulfill()
    {
        $thread = $this->route('thread');
        $sourceCategory = $thread->category;
        $destinationCategory = $this->getDestinationCategory();

        $action = new Action($thread, $destinationCategory);
        $thread = $action->execute();

        if (! $thread === null) {
            UserMovedThread::dispatch($this->user(), $thread, $sourceCategory, $destinationCategory);
        }

        return $thread;
    }

    private function getDestinationCategory(): Category
    {
        if (! isset($this->destinationCategory)) {
            $this->destinationCategory = Category::find($this->input('category_id'));
        }

        return $this->destinationCategory;
    }
}
