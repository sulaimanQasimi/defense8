<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FacultyResource;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return FacultyResource::collection(Faculty::all())->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function store(Request $request)
    {
        $this->authorize('create',Faculty::class);
        
        $validate =  Validator::make($request->all(), [
            'name' => ['required', 'string','unique:faculties,name'],
        ]);

        if ($validate->fails()) {
            return response($validate->errors(),505);
        }
        // Authounticate user
        $faculty = Faculty::create([
            'user_id'=>auth()->id(),
            'name'=>$request->name,
        ]);
        return FacultyResource::make($faculty);
    }

    /**
     * Display the specified resource.
     */
    public function show(Faculty $faculty)
    {
        return FacultyResource::make($faculty);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faculty $faculty): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faculty $faculty): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faculty $faculty): void
    {
        //
    }
}
