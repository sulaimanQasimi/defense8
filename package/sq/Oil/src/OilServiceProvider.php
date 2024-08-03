<?php
namespace Sq\Oil;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;
use Livewire\Livewire;
use Sq\Card\Livewire\CardDesign;
use Sq\Card\Nova\PrintCardFrame;

class OilServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Nova::resources([
            \Sq\Oil\Nova\Oil::class,
            \Sq\Oil\Nova\OilDisterbution::class,
        ]);

    }
    public function register()
    {

    }
    public function routes()
    {

    }
    protected function routeConfiguration()
    {
    }
}
