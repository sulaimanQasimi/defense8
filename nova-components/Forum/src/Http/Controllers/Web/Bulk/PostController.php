<?php

namespace Acme\Forum\Http\Controllers\Web\Bulk;

use Illuminate\Http\RedirectResponse;
use Acme\Forum\Http\Controllers\Web\BaseController;
use Acme\Forum\Http\Requests\Bulk\DeletePosts;
use Acme\Forum\Http\Requests\Bulk\RestorePosts;

class PostController extends BaseController
{
    public function delete(DeletePosts $request): RedirectResponse
    {
        $result = $request->fulfill();

        if ($result === null) {
            return $this->invalidSelectionResponse();
        }

        return $this->bulkActionResponse($result->count(), 'posts.deleted');
    }

    public function restore(RestorePosts $request): RedirectResponse
    {
        $result = $request->fulfill();

        if ($result === null) {
            return $this->invalidSelectionResponse();
        }

        return $this->bulkActionResponse($result->count(), 'posts.updated');
    }
}
