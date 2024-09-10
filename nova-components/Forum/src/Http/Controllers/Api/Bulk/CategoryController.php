<?php

namespace Acme\Forum\Http\Controllers\Api\Bulk;

use Illuminate\Http\Response;
use Acme\Forum\Http\Requests\Bulk\ManageCategories;

class CategoryController
{
    public function manage(ManageCategories $request): Response
    {
        $request->fulfill();

        return new Response(['success' => true], 200);
    }
}
