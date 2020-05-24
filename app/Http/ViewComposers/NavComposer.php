<?php

namespace App\Http\ViewComposers;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

use App\Categorie;


class NavComposer {

    function compose(View $view) {

        $view->with('navCategories', Cache::remember('navCategories', 60,
            function() {
                return Categorie::all();
            }));
    }
}
