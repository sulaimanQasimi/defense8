<?php
namespace Acme\PriceTracker\Http\Controllers;

use Sq\Employee\Models\Department;

class LanguageController
{
    public function index()
    {
        $request=request()->all();
        return inertia('PriceTracker',compact('request'));
    }

}
