<?php

namespace Acme\Forum\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Acme\Forum\Http\Requests\CreateCategory;
use Acme\Forum\Http\Requests\DeleteCategory;
use Acme\Forum\Http\Requests\UpdateCategory;
use Acme\Forum\Http\Resources\CategoryResource;
use Acme\Forum\Policies\CategoryPolicy;
use Acme\Forum\Support\CategoryPrivacy;

class CategoryController extends BaseController
{
    /**
     * Summary of resourceClass
     * @var \Acme\Forum\Http\Resources\CategoryResource
     */
    protected $resourceClass = null;

    public function __construct()
    {
        $this->resourceClass = CategoryResource::class;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        if ($request->has('parent_id')) {
            $categories = CategoryPrivacy::getFilteredDescendantsFor($request->user(), $request->query('parent_id'));
        } else {
            $categories = CategoryPrivacy::getFilteredFor($request->user());
        }

        return $this->resourceClass::collection($categories);
    }

    public function fetch(Request $request): JsonResource|Response
    {
        $category = $request->route('category');
        if (! $category->isAccessibleTo($request->user())) {
            return $this->notFoundResponse();
        }

        return new $this->resourceClass($category);
    }

    public function store(CreateCategory $request): JsonResource
    {
        $category = $request->fulfill();

        return new $this->resourceClass($category);
    }

    public function update(UpdateCategory $request): JsonResource
    {
        $category = $request->fulfill();

        return new $this->resourceClass($category);
    }

    public function delete(DeleteCategory $request): Response
    {
        $request->fulfill();

        return new Response(['success' => true], 200);
    }
}
