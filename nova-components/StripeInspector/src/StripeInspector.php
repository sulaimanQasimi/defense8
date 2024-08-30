<?php

namespace Acme\StripeInspector;

use Laravel\Nova\ResourceTool;

class StripeInspector extends ResourceTool
{
    public function name()
    {
        return 'Stripe Inspector';
    }

    public function component()
    {
        return 'stripe-inspector';
    }
}
