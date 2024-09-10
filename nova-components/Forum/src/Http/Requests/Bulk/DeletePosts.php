<?php

namespace Acme\Forum\Http\Requests\Bulk;

use Illuminate\Foundation\Http\FormRequest;
use Acme\Forum\Actions\Bulk\DeletePosts as Action;
use Acme\Forum\Events\UserBulkDeletedPosts;
use Acme\Forum\Http\Requests\Traits\AuthorizesAfterValidation;
use Acme\Forum\Http\Requests\Traits\HandlesDeletion;
use Acme\Forum\Interfaces\FulfillableRequest;
use Acme\Forum\Models\Post;
use Acme\Forum\Support\CategoryPrivacy;

class DeletePosts extends FormRequest implements FulfillableRequest
{
    use AuthorizesAfterValidation, HandlesDeletion;

    public function rules(): array
    {
        return [
            'posts' => ['required', 'array'],
            'permadelete' => ['boolean'],
        ];
    }

    public function authorizeValidated(): bool
    {
        $query = Post::query();

        if ($this->user()->can('viewTrashedPosts')) {
            $query = $query->withTrashed();
        }

        $posts = $query->with(['thread', 'thread.category'])->whereIn('id', $this->validated()['posts']);

        $accessibleCategoryIds = CategoryPrivacy::getFilteredFor($this->user())->keys();

        foreach ($posts as $post) {
            $canView = $accessibleCategoryIds->contains($post->thread->category_id) && $this->user()->can('view', $post->thread);
            $canDelete = $this->user()->can('deletePosts', $post->thread) && $this->user()->can('delete', $post);

            if (! ($canView && $canDelete)) {
                return false;
            }
        }

        return true;
    }

    public function fulfill()
    {
        $action = new Action(
            $this->validated()['posts'],
            $this->user()->can('viewTrashedPosts'),
            $this->isPermaDeleting()
        );
        $posts = $action->execute();

        if ($posts !== null) {
            UserBulkDeletedPosts::dispatch($this->user(), $posts);
        }

        return $posts;
    }
}
