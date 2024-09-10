<?php

namespace Acme\Forum\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Acme\Forum\Actions\DeleteCategory as Action;
use Acme\Forum\Events\UserDeletedCategory;
use Acme\Forum\Http\Requests\Traits\AuthorizesAfterValidation;
use Acme\Forum\Http\Requests\Traits\HandlesDeletion;
use Acme\Forum\Interfaces\FulfillableRequest;

class DeleteCategory extends FormRequest implements FulfillableRequest
{
    use AuthorizesAfterValidation, HandlesDeletion;

    public function rules(): array
    {
        return [
            'force' => ['boolean'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('force', 'required', function ($input) {
            return ! $this->route('category')->isEmpty();
        });
    }

    public function authorizeValidated(): bool
    {
        return $this->user()->can('delete', $this->route('category'));
    }

    public function fulfill()
    {
        $category = $this->route('category');

        $action = new Action($category);
        $action->execute();

        UserDeletedCategory::dispatch($this->user(), $category);

        return $category;
    }
}
