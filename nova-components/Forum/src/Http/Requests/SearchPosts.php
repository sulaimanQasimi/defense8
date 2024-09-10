<?php

namespace Acme\Forum\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Acme\Forum\Actions\SearchPosts as Action;
use Acme\Forum\Events\UserSearchedPosts;
use Acme\Forum\Http\Requests\Traits\AuthorizesAfterValidation;
use Acme\Forum\Interfaces\FulfillableRequest;
use Acme\Forum\Models\Category;

class SearchPosts extends FormRequest implements FulfillableRequest
{
    use AuthorizesAfterValidation;

    private ?Category $category = null;

    public function rules(): array
    {
        return [
            'term' => ['required', 'string'],
        ];
    }

    public function authorizeValidated(): bool
    {
        $category = $this->getCategory();

        return $category == null || ! $category->is_private || $category->isAccessibleTo($this->user());
    }

    public function fulfill()
    {
        $category = $this->getCategory();
        $term = $this->validated()['term'];
        $action = new Action($category, $this->validated()['term']);
        $posts = $action->execute();

        if ($posts !== null) {
            UserSearchedPosts::dispatch($this->user(), $category, $term, $posts);
        }

        return $posts;
    }

    private function getCategory()
    {
        $categoryId = $this->query('category_id');

        if (! isset($this->category) && $categoryId != null && is_numeric($categoryId)) {
            $this->category = Category::find($categoryId);
        }

        return $this->category;
    }
}
