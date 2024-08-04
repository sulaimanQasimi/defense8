<?php
namespace Acme\PriceTracker\Http\Controllers;

use Sq\Employee\Models\Department;

class LanguageController
{
    public function index()
    {
        $years = [];
        $departments = Department::all();
        for ($i = 1388; $i <= verta()->year; $i++) {
            $years[] = $i;
        }
        return inertia('PriceTracker', compact('departments','years'));
    }

}
