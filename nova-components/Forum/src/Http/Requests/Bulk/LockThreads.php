<?php

namespace Acme\Forum\Http\Requests\Bulk;

use Illuminate\Foundation\Http\FormRequest;
use Acme\Forum\Actions\Bulk\LockThreads as Action;
use Acme\Forum\Events\UserBulkLockedThreads;
use Acme\Forum\Http\Requests\Traits\AuthorizesAfterValidation;
use Acme\Forum\Interfaces\FulfillableRequest;
use Acme\Forum\Models\Category;
use Acme\Forum\Models\Thread;
use Acme\Forum\Support\CategoryPrivacy;

class LockThreads extends FormRequest implements FulfillableRequest
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
        $query = Thread::whereIn('id', $this->validated()['threads']);

        if ($this->user()->can('viewTrashedThreads')) {
            $query = $query->withTrashed();
        }

        $categoryIds = $query->select('category_id')->distinct()->pluck('category_id');
        $categories = Category::whereIn('id', $categoryIds)->get();

        $accessibleCategoryIds = CategoryPrivacy::getFilteredFor($this->user())->keys();

        foreach ($categories as $category) {
            if (! ($accessibleCategoryIds->contains($category->id) || $this->user()->can('lockThreads', $category))) {
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
            UserBulkLockedThreads::dispatch($this->user(), $threads);
        }

        return $threads;
    }
}
