<?php

use Illuminate\Support\Facades\Route;
use Sq\Card\Http\Controllers\PrintCardController;
use Sq\Card\Http\Controllers\PrintPaperCardController;
use Sq\Card\Http\Controllers\TestCardController;
use Sq\Card\Livewire\CardDesign;
use Sq\Card\Livewire\CustomCardDesign;
use Sq\Card\Models\Contracts\DefaultCardAttribute;
use Sq\Card\Models\PrintCardFrame;
// Group for Desining and Printing Cards
Route::middleware(['auth'])
    ->group(function () {



        /**
         * Define a route for previewing a custom paper card.
         *
         * This route responds to a GET request at the URL pattern "paper-card/{customPaperCard:id}".
         * It uses the 'custom' method of the TestCardController to handle the request.
         * The route is named 'employee.paper-test-card'.
         *
         * @param int $customPaperCard:id The ID of the custom paper card to preview.
         * @return \Illuminate\Http\Response
         */
        Route::get("paper-card-preview/{customPaperCard:id}", [TestCardController::class, 'custom'])
            ->name('employee.paper-test-card');


        /**
         * Route to preview a paper card.
         *
         * This route handles GET requests to the URL "pvc-card-preview/{printCardFrame:id}".
         * It uses the 'pvc' method of the TestCardController to generate the preview.
         * The route is named 'employee.pvc-test-card'.
         *
         * @param int $printCardFrame:id The ID of the print card frame to preview.
         * @return \Illuminate\Http\Response
         */
        Route::get("pvc-card-preview/{printCardFrame:id}", [TestCardController::class, 'pvc'])
            ->name('employee.pvc-test-card');




            
        Route::get("paper-card/{customPaperCard:id}", CustomCardDesign::class)
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
        Route::middleware('permission:print-card')

            ->controller(PrintPaperCardController::class)
            ->name('paper.print-card.')
            ->group(function () {
                Route::get('employee/{mainCard:id}/card/{printCardFrame}', 'employee')->name('employee');
                Route::get('gun/{gunCard:id}/card/{printCardFrame}', 'gun')->name('gun');
                Route::get('employeeCar/{employeeVehicalCard:id}/card/{printCardFrame}', 'employee_car')->name('employee_car');
            });
    });
