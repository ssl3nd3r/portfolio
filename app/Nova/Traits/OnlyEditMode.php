<?php

namespace App\Nova\Traits;

use Illuminate\Http\Request;

trait OnlyEditMode
{
    public function authorizedToView(Request $request)
    {
        return false;
    }

    public function authorizedToReplicate(Request $request)
    {
        return false;
    }

    

    public static function redirectAfterUpdate(Request $request, $resource)
    {
        return '/resources/' . $request->route('resource') . '/' . $resource->getKey() . '/edit';
    }

    public static function redirectAfterCreate(Request $request, $resource)
    {
        return '/resources/' . $request->route('resource') . '/' . $resource->getKey() . '/edit';
    }
} 