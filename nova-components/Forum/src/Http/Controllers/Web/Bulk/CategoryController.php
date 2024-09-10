<?php

namespace Acme\Forum\Http\Controllers\Web\Bulk;

use Illuminate\Http\JsonResponse;
use Acme\Forum\Http\Requests\Bulk\ManageCategories;

class CategoryController
{
    public function manage(ManageCategories $request): JsonResponse
    {
        $request->fulfill();

        return new JsonResponse(['success' => true], 200);
    }
}
