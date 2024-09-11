<?php

namespace Acme\Forum;

use Acme\Forum\Nestedset\NestedSet;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class NestedSetServiceProvider extends ServiceProvider
{
    public function register()
    {
        Blueprint::macro('nestedColumns', function () {
            NestedSet::columns($this);
        });

        Blueprint::macro('dropNestedColumns', function () {
            NestedSet::dropColumns($this);
        });
    }
}
