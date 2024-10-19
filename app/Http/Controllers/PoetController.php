<?php

namespace App\Http\Controllers;

use App\Models\Poet;
use App\Models\Poem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use App\Mail\TestEmail;


class PoetController extends Controller
{
    public function show(Request $request, $poet_name)
    {
        $poet = Poet::where('name', $poet_name)->first();

        if($request->input('filter') == 'recent') {
            $poet_id = $poet->id;
            $recent_poems = Poem::where('poet_id', $poet_id)->orderBy('created_at','desc')->get();
            return view('poet', ['poet' => $poet, 'poems' => $recent_poems]);

        } 
        else {
            $poetId = $poet->id;

            $poems = Poem::where('poet_id', $poetId) // Filter poems by the specified poet ID
                ->withCount(['likes', 'views']) // Count the likes and views for each poem
                ->orderBy('views_count', 'desc') // Order by the count of views in descending order
                ->orderBy('likes_count', 'desc') // Then order by the count of likes in descending order
                ->get();


            return view('poet', ['poet' => $poet, 'poems' => $poems]);
        }
        

    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
        ]);


        $imagePath = '';
        if ($request->hasFile('image')) {
            Log::info("has file !");
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $imagePath = $image->storeAs('images', $imageName, 'public');
            $imagePath = '/storage/' . $imagePath;

        } else {
            Log::info("no file !");

        }


        $post = Poet::create([
            'name' => $request->input('name'),
            'category' => $request->input('category'),
            'avatar' => $imagePath,
            'lifetime' => $request->input('lifetime'),
            'bio' => $request->input('bio')
        ]);

        return redirect()->route('poets.show', $request->input('name'));
    }


    public function bio(Request $request, $poet_name) {
        $poet = Poet::where('name', $poet_name)->first();
        $poetId = $poet->id;
        $poet = Poet::where('name', $poet_name)->first();
        $poems = Poem::where('poet_id', $poetId) // Filter poems by the specified poet ID
            ->withCount(['likes', 'views']) // Count the likes and views for each poem
            ->orderBy('views_count', 'desc') // Order by the count of views in descending order
            ->orderBy('likes_count', 'desc') // Then order by the count of likes in descending order
            ->get();
        $similarPoets = Poet::where('category', $poet->category)->get();
        
        return view('bio', ['poet'=> $poet, 'poems' => $poems, 'similarPoets' => $similarPoets]);
    }

    

}
