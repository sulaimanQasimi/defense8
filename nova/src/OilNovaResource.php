<?php

namespace Laravel\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\DestructiveAction;
use Laravel\Nova\Http\Requests\NovaRequest;

abstract class OilNovaResource extends Resource
{
    // use Authorizable;

    public static function authorizable()
    {
        return true;
    }
    public function authorizeToViewAny(Request $request)
    {
        if (!request()->user()->hasPermissionTo('quota_oil_update')) {
            abort(403);
        }
    }

    public static function authorizedToViewAny(Request $request)
    {
        return $request->user()->hasPermissionTo('quota_oil_update');
    }

    public function authorizeToView(Request $request)
    {
        if (!request()->user()->hasPermissionTo('quota_oil_update')) {
            abort(403);
        }
    }

    public function authorizedToView(Request $request)
    {
        return $request->user()->hasPermissionTo('quota_oil_update');
    }

    public static function authorizeToCreate(Request $request)
    {
            abort(403);
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;

    }

    public function authorizeToUpdate(Request $request)
    {
        if (!request()->user()->hasPermissionTo('quota_oil_update')) {
            abort(403);
    }
        }

    public function authorizedToUpdate(Request $request)
    {
        return $request->user()->hasPermissionTo('quota_oil_update');
    }

    public function authorizeToReplicate(Request $request)
    {
        abort(403);
    }

    public function authorizedToReplicate(Request $request)
    {
        return false;
    }

    public function authorizeToDelete(Request $request)
    {
        abort(403);
    }

    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    public function authorizedToRestore(Request $request)
    {
        return false;
    }
    public function authorizedToForceDelete(Request $request)
    {
        return false;
    }

    public function authorizedToAdd(NovaRequest $request, $model)
    {
        return false;

    }

    public function authorizedToAttachAny(NovaRequest $request, $model)
    {
        return false;
    }

    public function authorizedToAttach(NovaRequest $request, $model)
    {
        return false;
    }

    public function authorizedToDetach(NovaRequest $request, $model, $relationship)
    {
        return false;
    }

    public function authorizedToRunAction(NovaRequest $request, Action $action)
    {
        return false;
    }

    public function authorizedToRunDestructiveAction(NovaRequest $request, DestructiveAction $action)
    {
        return false;
    }
    public function authorizedToImpersonate(NovaRequest $request)
    {
        return false;

    }
    public function authorizeTo(Request $request, $ability)
    {
        return false;

    }
    public function authorizedTo(Request $request, $ability)
    {
        return $request->user()->hasPermissionTo('quota_oil_update');
    }

}
