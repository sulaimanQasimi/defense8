<?php

namespace Acme\Forum\Http\Requests\Bulk;

use Illuminate\Foundation\Http\FormRequest;
use Acme\Forum\Actions\Bulk\ManageCategories as Action;
use Acme\Forum\Events\UserBulkManagedCategories;
use Acme\Forum\Interfaces\FulfillableRequest;

class ManageCategories extends FormRequest implements FulfillableRequest
{
    public function rules(): array
    {
        return [
            'categories' => ['required', 'array'],
        ];
    }

    public function authorizeValidated(): bool
    {
        return $this->user()->can('manageCategories');
    }

    public function fulfill()
    {
        $categoryData = $this->validated()['categories'];
        $action = new Action($categoryData);
        $categoriesAffected = $action->execute();

        UserBulkManagedCategories::dispatch($this->user(), $categoriesAffected, $categoryData);

        return $categoriesAffected;
    }
}
