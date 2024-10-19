<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\View;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */ 
    public function selfUser()
    {
        $rank = User::select('id')
            ->withCount('poems')
            ->orderBy('poems_count', 'desc')
            ->pluck('id')
            ->search(Auth::id()) + 1;

        // Step 1: Get all views for the current user
        $views = View::where('user_id', Auth::id());

        // Step 2: Select poem_id and count the number of views
        $mostViewedPoems = $views->select('poem_id', \DB::raw('count(*) as views_count'))

            // Step 3: Group by poem_id to get unique counts
            ->groupBy('poem_id')

            // Step 4: Order by views_count in descending order
            ->orderBy('views_count', 'desc')

            // Step 5: Load the associated poem data
            ->with('poem') // Ensure the Poem relationship is defined in the View model
            ->take(5) // Limit to top 5 most viewed poems
            ->get();

        Log::info($mostViewedPoems);

        return view('home',['rank' => $rank, 'favPoems' => $mostViewedPoems]);
    }

    public function profile(Request $request, $user_id) {

        $user = User::where('id', $user_id)->first();

        $rank = User::select('id')
            ->withCount('poems')
            ->orderBy('poems_count', 'desc')
            ->pluck('id')
            ->search($user_id) + 1;

        $views = View::where('user_id', $user_id);

        $mostViewedPoems = $views->select('poem_id', \DB::raw('count(*) as views_count'))
            ->groupBy('poem_id')
            ->orderBy('views_count', 'desc')
            ->with('poem') 
            ->take(5) 
            ->get();




        return view('profile', ['user' => $user,'rank' => $rank, 'favPoems' => $mostViewedPoems]);
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }
}
