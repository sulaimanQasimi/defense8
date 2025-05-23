<?php

namespace Acme\Forum\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Acme\Forum\Actions\CreateCategory as Action;
use Acme\Forum\Events\UserCreatedCategory;
use Acme\Forum\Interfaces\FulfillableRequest;

class CreateCategory extends FormRequest implements FulfillableRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('createCategories');
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3'],
            'description' => ['nullable', 'string'],
            'color' => ['string'],
            'accepts_threads' => ['boolean'],
            'is_private' => ['boolean'],
        ];
    }

    public function fulfill()
    {
        $input = $this->validated();

        $action = new Action(
            $input['title'],
            isset($input['description']) ? $input['description'] : '',
            isset($input['color']) ? $input['color'] : '#007bff',
            isset($input['accepts_threads']) && $input['accepts_threads'],
            isset($input['is_private']) && $input['is_private']
        );

        $category = $action->execute();

        UserCreatedCategory::dispatch($this->user(), $category);

        return $category;
    }
}
