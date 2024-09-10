<?php

namespace Acme\Forum\Http\Requests\Bulk;

use Illuminate\Foundation\Http\FormRequest;
use Acme\Forum\Actions\Bulk\RestorePosts as Action;
use Acme\Forum\Events\UserBulkRestoredPosts;
use Acme\Forum\Http\Requests\Traits\AuthorizesAfterValidation;
use Acme\Forum\Interfaces\FulfillableRequest;
use Acme\Forum\Models\Post;

class RestorePosts extends FormRequest implements FulfillableRequest
{
    use AuthorizesAfterValidation;

    public function rules(): array
    {
        return [
            'posts' => ['required', 'array'],
        ];
    }

    public function authorizeValidated(): bool
    {
        $posts = Post::whereIn('id', $this->validated()['posts'])->onlyTrashed()->get();
        foreach ($posts as $post) {
            if (! ($this->user()->can('restorePosts', $post->thread) && $this->user()->can('restore', $post))) {
                return false;
            }
        }

        return true;
    }

    public function fulfill()
    {
        $action = new Action($this->validated()['posts']);
        $posts = $action->execute();

        if ($posts !== null) {
            UserBulkRestoredPosts::dispatch($this->user(), $posts);
        }

        return $posts;
    }
}
