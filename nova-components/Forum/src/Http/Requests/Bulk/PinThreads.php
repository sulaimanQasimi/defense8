<?php

namespace Acme\Forum\Http\Requests\Bulk;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Acme\Forum\Actions\Bulk\PinThreads as Action;
use Acme\Forum\Events\UserBulkPinnedThreads;
use Acme\Forum\Http\Requests\Traits\AuthorizesAfterValidation;
use Acme\Forum\Interfaces\FulfillableRequest;
use Acme\Forum\Models\Category;
use Acme\Forum\Models\Thread;

class PinThreads extends FormRequest implements FulfillableRequest
{
    use AuthorizesAfterValidation;

    public function rules(): array
    {
        return [
            'threads' => ['required', 'array'],
        ];
    }

    public function authorizeValidated(): bool
    {
        $categories = $this->categories();
        foreach ($categories as $category) {
            if (! $this->user()->can('pinThreads', $category)) {
                return false;
            }
        }

        return true;
    }

    public function fulfill()
    {
        $action = new Action($this->validated()['threads'], $this->user()->can('viewTrashedThreads'));
        $threads = $action->execute();

        if ($threads !== null) {
            UserBulkPinnedThreads::dispatch($this->user(), $threads);
        }

        return $threads;
    }

    protected function categories(): Collection
    {
        $query = Thread::whereIn('id', $this->validated()['threads']);

        if ($this->user()->can('viewTrashedThreads')) {
            $query = $query->withTrashed();
        }

        $categoryIds = $query->select('category_id')->distinct()->pluck('category_id');

        return Category::whereIn('id', $categoryIds)->get();
    }
}
