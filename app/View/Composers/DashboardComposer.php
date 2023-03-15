<?php

namespace App\View\Composers;

use App\Models\Result;
use App\Models\Search;
use Illuminate\View\View;

class DashboardComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $pendding = Search::where('status',0)->count();
        $success = Search::where('status',1)->count();
        $fail = Search::where('status',-1)->count();
        $links = Result::count();
        $view->with('searches', [
            'pending' => $pendding,
            'success' => $success,
            'fail' => $fail,
            'links' => $links,
        ]);
    }
}
