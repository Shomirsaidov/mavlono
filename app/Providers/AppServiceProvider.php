<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

use App\Models\Poet;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {

            $poets = Poet::withCount(['poems as views_count' => function($query) {
                $query->join('views', 'poems.id', '=', 'views.poem_id');
            }])
            ->orderBy('views_count', 'desc') // Order by the views count
            ->get();


            $tags = DB::table('poems')
                ->select(DB::raw('tag, COUNT(tag) as frequency'))
                ->from(DB::raw('(SELECT TRIM(BOTH " " FROM SUBSTRING_INDEX(SUBSTRING_INDEX(tags, ",", numbers.n), ",", -1)) as tag
                                FROM poems
                                JOIN (SELECT 1 n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) numbers
                                ON CHAR_LENGTH(tags) - CHAR_LENGTH(REPLACE(tags, ",", "")) >= numbers.n - 1) subquery'))
                ->groupBy('tag')
                ->orderBy('frequency', 'desc')
                ->limit(10)
                ->get();

            $view->with(['poets'=> $poets, 'tags'=>$tags]);
        });
    }
}
