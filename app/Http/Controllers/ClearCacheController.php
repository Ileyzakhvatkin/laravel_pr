<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class ClearCacheController extends Controller
{
    public function __invoke()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        return "Кэш очищен.";
    }
}
