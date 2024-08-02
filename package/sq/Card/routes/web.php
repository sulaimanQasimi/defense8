<?php
use Illuminate\Support\Facades\Route;
use Sq\Card\Http\Controllers\PrintCardController;
use Sq\Card\Livewire\CardDesign;

// Group for Desining and Printing Cards
Route::middleware(['auth'])->group(function () {

    // Card Frame Design Request Route
    Route::middleware('role:Design Card')->get('card-design/{printCardFrame:id}', CardDesign::class)->name('employee.design-card');

    // Card Frame Print Request Route

    // // Employee Card
    Route::middleware('role:Print Card')->get('print-employee-card-for/{cardInfo:id}/card/{printCardFrame}', (new PrintCardController())->employee(...))->name('employee.print-card-for');

    // Gun Card
    Route::middleware('role:Print Card')->get('print/gun/{cardInfo:id}/card/{printCardFrame}', (new PrintCardController())->gun(...))->name('gun.print-card-for');

    // Employee Car Card
    Route::middleware('role:Print Card')->get('print/employeeCar/{employeeVehicalCard:id}/card/{printCardFrame}', (new PrintCardController())->employee_car(...))->name('employee-car.print-card-for');
});
