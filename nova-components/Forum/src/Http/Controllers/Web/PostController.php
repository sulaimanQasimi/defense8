<?php

namespace Acme\Forum\Http\Controllers\Web;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View as ViewFactory;
use Illuminate\View\View;
use Acme\Forum\Events\UserCreatingPost;
use Acme\Forum\Events\UserEditingPost;
use Acme\Forum\Events\UserViewingPost;
use Acme\Forum\Http\Requests\CreatePost;
use Acme\Forum\Http\Requests\DeletePost;
use Acme\Forum\Http\Requests\RestorePost;
use Acme\Forum\Http\Requests\UpdatePost;
use Acme\Forum\Support\Web\Forum;

class PostController extends BaseController
{
    public function show(Request $request): View
    {
        $thread = $request->route('thread');

        if (! $thread->category->isAccessibleTo($request->user())) {
            abort(404);
        }

        if ($thread->category->is_private) {
            $this->authorize('view', $thread);
        }

        $post = $request->route('post');
        if ($request->user() !== null) {
            UserViewingPost::dispatch($request->user(), $post);
        }

        return ViewFactory::make('forum.post.show', compact('thread', 'post'));
    }

    public function create(Request $request): View
    {
        $thread = $request->route('thread');

        $this->authorize('reply', $thread);

        UserCreatingPost::dispatch($request->user(), $thread);

        $post = $request->has('post') ? $thread->posts->find($request->input('post')) : null;

        return ViewFactory::make('forum.post.create', compact('thread', 'post'));
    }

    public function store(CreatePost $request): RedirectResponse
    {
        $thread = $request->route('thread');

        $this->authorize('reply', $thread);

        $post = $request->fulfill();

        Forum::alert('success', 'general.reply_added');

        return new RedirectResponse(Forum::route('thread.show', $post));
    }

    public function edit(Request $request): View
    {
        $post = $request->route('post');

        if ($post->trashed()) {
            return abort(404);
        }

        $this->authorize('edit', $post);

        UserEditingPost::dispatch($request->user(), $post);

        $thread = $post->thread;
        $category = $post->thread->category;

        return ViewFactory::make('forum.post.edit', compact('category', 'thread', 'post'));
    }

    public function update(UpdatePost $request): RedirectResponse
    {
        $post = $request->route('post');

        $this->authorize('edit', $post);

        $post = $request->fulfill();

        Forum::alert('success', 'posts.updated');

        return new RedirectResponse(Forum::route('thread.show', $post));
    }

    public function confirmDelete(Request $request): View
    {
        $thread = $request->route('thread');
        $post = $request->route('post');

        return ViewFactory::make('forum.post.confirm-delete', ['category' => $thread->category, 'thread' => $thread, 'post' => $post]);
    }

    public function confirmRestore(Request $request): View
    {
        $thread = $request->route('thread');
        $post = $request->route('post');

        return ViewFactory::make('forum.post.confirm-restore', ['category' => $thread->category, 'thread' => $thread, 'post' => $post]);
    }

    public function delete(DeletePost $request): RedirectResponse
    {
        $post = $request->fulfill();

        if ($post === null) {
            return $this->invalidSelectionResponse();
        }

        Forum::alert('success', 'posts.deleted', 1);

        return new RedirectResponse(Forum::route('thread.show', $post->thread));
    }

    public function restore(RestorePost $request): RedirectResponse
    {
        $post = $request->fulfill();

        if ($post === null) {
            return $this->invalidSelectionResponse();
        }

        Forum::alert('success', 'posts.updated', 1);

        return new RedirectResponse(Forum::route('thread.show', $post));
    }
}
