<?php

use Illuminate\Support\Facades\Route;
use Sq\Card\Http\Controllers\PrintCardController;
use Sq\Card\Http\Controllers\TestCardController;
use Sq\Card\Livewire\CardDesign;
use Sq\Card\Livewire\CustomCardDesign;
use Sq\Card\Models\Contracts\DefaultCardAttribute;
use Sq\Card\Models\PrintCardFrame;
// Group for Desining and Printing Cards
Route::middleware(['auth'])
    ->group(function () {



        Route::get("r-preview/{customPaperCard:id}", [TestCardController::class,'custom'])
        ->name('employee.paper-test-card');
        ;

        Route::get("r-test/{customPaperCard:id}", CustomCardDesign::class)
            ->name('employee.paper-design-card');
        // Card Frame Design Request Route
        Route::middleware('permission:design-card')
            ->get('card-design/{printCardFrame:id}', CardDesign::class)
            ->name('employee.design-card');
        Route::middleware('permission:design-card')
            ->get('card-design/{printCardFrame:id}/fix', function (PrintCardFrame $printCardFrame) {
                $printCardFrame->attr = array_replace(DefaultCardAttribute::attribute(), $printCardFrame->attr);
                $printCardFrame->save();
            });
        // Card Frame Print Request Route

        // // Employee Card
        Route::middleware('permission:print-card')->get('print-employee-card-for/{mainCard:id}/card/{printCardFrame}', (new PrintCardController())->employee(...))->name('employee.print-card-for');

        // Gun Card
        Route::middleware('permission:print-card')->get('print/gun/{gunCard:id}/card/{printCardFrame}', (new PrintCardController())->gun(...))->name('gun.print-card-for');

        // Employee Car Card
        Route::middleware('permission:print-card')->get('print/employeeCar/{employeeVehicalCard:id}/card/{printCardFrame}', (new PrintCardController())->employee_car(...))->name('employee-car.print-card-for');
    });
