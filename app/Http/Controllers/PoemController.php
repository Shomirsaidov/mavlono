<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;


use App\Models\Poem;
use App\Models\Poet;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Subscription;
use App\Models\View;
use App\Models\Vocab;

use App\Jobs\SendPoemEmail;


class PoemController extends Controller
{
    //



    public function show(Poem $poem)
    {
        $user_id = 7777777;
        if (Auth::check()) {
            $user_id = Auth::user()->id;
        }

        // Create a new view record
        View::create([
            'user_id' => $user_id,
            'poem_id' => $poem->id,
            'poet_id' => $poem->poet->id
        ]);

        // Split the tags of the current poem into an array
        $tags = explode(',', $poem->tags);

        // Initialize an empty collection for similar poems
        $similar_poems = collect();

        // Loop through each tag and find poems that contain the tag, excluding the current poem
        foreach ($tags as $tag) {
            $similar_poems = $similar_poems->merge(
                Poem::where('id', '<>', $poem->id)
                    ->whereRaw('FIND_IN_SET(?, tags)', [trim($tag)])
                    ->get()
            );
        }

        // Remove duplicate poems that might have been merged multiple times
        $similar_poems = $similar_poems->unique('id');

        $poetId = $poem->poet->id;

        $thispoet = Poem::where('poet_id', $poetId) // Filter poems by the specified poet ID
            ->withCount(['likes', 'views']) // Count the likes and views for each poem
            ->orderBy('views_count', 'desc') // Order by the count of views in descending order
            ->orderBy('likes_count', 'desc') // Then order by the count of likes in descending order
            ->get();


        return view('poem', [
            'poem' => $poem,
            'similars' => $similar_poems,
            'thispoet' => $thispoet
        ]);
    }




    public function search(Request $request)
    {
        // Validate the input
        $request->validate([
            'query' => 'required|string',
        ]);

        $query = $request->input('query');

        // Perform the search
        $results = Poem::where('content', 'like', '%' . $query . '%')
            ->orWhere('tags', 'like', '%' . $query . '%')
            ->orWhere('genre', 'like', '%' . $query . '%')
            ->orWhereHas('poet', function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
            })
            ->leftJoin('views', 'poems.id', '=', 'views.poem_id') // Join with views table
            ->select('poems.id', 'poems.content', 'poems.tags', 'poems.poet_id', DB::raw('COUNT(views.id) as views_count')) // Select specific columns
            ->groupBy('poems.id', 'poems.content', 'poems.tags', 'poems.poet_id') // Group by poem ID and other selected columns
            ->orderBy('views_count', 'desc') // Order by views count
            ->get();


        // Return the search results to the view
        return view('search-results', ['results' => $results]);
    }





    public function create(Request $request)
    {
        $request->validate([
            'content' => ['required', 'string'],
        ]);

        $poem = Poem::create([
            'poet_id' => $request->input('author'),
            'content' => $request->input('content'),
            'user_id' => Auth::user()->id,
            'tags' => $request->input('tags'),
            'genre' => $request->input('genre')
        ]);

       if($request->input('vocabs')) {
            Vocab::create([
                'user_id' => Auth::user()->id,
                'poem_id' => $poem->id,
                'word' => $request->input('vocabs')
            ]);
       }

        $users_interested = Subscription::where('poet_id', $request->input('author'))->get();
        foreach($users_interested as $sub) {
            // Mail::to($sub->user->email)->send(new TestEmail(['user' => $sub->user, 'poem' => $poem]));
            SendPoemEmail::dispatch($sub->user, $poem);
        }



        return redirect()->route('poems.show', $poem);
    }

    public function delete(Request $request) {
        $poem = Poem::find($request->input('poem_id')); 
        $poem->delete(); 

        return redirect('/');
    }

    public function recent()
    {
        // Fetch 30 most recent poems
        $recentPoems = Poem::orderBy('created_at', 'desc')->take(30)->get();

        // Fetch 30 most viewed poems
        $mostViewedPoems = Poem::withCount('views')->orderBy('views_count', 'desc')->take(30)->get();

        // Fetch 20 latest poems by subscribed poets that are not viewed by the user
        $unviewedSubscribedPoems = [];
        if (Auth::check()) {
            $user = Auth::user();
            $unviewedSubscribedPoems = Poem::whereHas('poet.subscriptions', function($query) use ($user) {
                                        $query->where('user_id', $user->id);
                                    })
                                    ->whereDoesntHave('views', function($query) use ($user) {
                                        $query->where('user_id', $user->id);
                                    })
                                    ->orderBy('created_at', 'desc')
                                    ->take(20)
                                    ->get();
        }

        // Merge all poems into a single collection
        $allPoems = $recentPoems->concat($mostViewedPoems)->concat($unviewedSubscribedPoems);

        // Convert the collection to an array and shuffle it
        $allPoemsArray = $allPoems->all();
        shuffle($allPoemsArray);

        // Optionally, convert back to a collection if needed
        $shuffledPoems = collect($allPoemsArray);

        // Return the shuffled poems to the view
        return view('recent', ['poems' => $shuffledPoems]);
    }



    public function like(Request $request) {
        $userId = Auth::user()->id;

        Log::info('intend to like');

        Like::create([
            'user_id'=> $userId,
            'poem_id'=> $request->poem_id
        ]);

        return response()->json(['status'=>'success']);

    }

    public function comment(Request $request) {


        $request->validate([
            'text' => ['required', 'string', 'min:1'],
        ]);

        Comment::create([
            'user_id' => Auth::user()->id,
            'poem_id' => $request->poem_id,
            'text' => $request->text
        ]);
        return back();

        


    }

    public function edit(Request $request) {
        $id = $request->input('poem_id');
        $request->validate([
            'content' => ['required', 'string'],
        ]);
    
        // Retrieve the poem by its ID
        $poem = Poem::findOrFail($id);
    
        // Update the poem's attributes
        $poem->update([
            'poet_id' => $request->input('author'),
            'content' => $request->input('content'),
            'tags' => $request->input('tags'),
            'genre' => $request->input('genre')
        ]);


        if(!is_null($request->input('vocabs'))) {
            $poem->vocabulary()->updateOrCreate(
                ['poem_id' => $poem->id], // Condition to check if the vocab for this poem exists
                [
                    'word' => $request->input('vocabs'),
                    'user_id' => Auth::user()->id
                ],     // Data to update or create
            );    
        }
       
    
        // Notify users interested in this poet
        $users_interested = Subscription::where('poet_id', $request->input('author'))->get();
        foreach ($users_interested as $sub) {
            SendPoemEmail::dispatch($sub->user, $poem);
        }
    
        return redirect()->route('poems.show', $poem);
    }
    
    public function createForm() {

        $poets = Poet::all();
        $genres = Poem::select('genre')->distinct()->pluck('genre');
        Log::info($genres);
        return view('create', ['authors' => $poets, 'genres'=>$genres]);

    }

    public function editForm(Request $request, $poem_id) {

        $poem = Poem::where('id', $poem_id)->first();   
        $genres = Poem::select('genre')->distinct()->pluck('genre');
     

        if(Auth::user()->poems->contains('id', $poem->id) || Auth::user()->role == 'admin') {
            $poets = Poet::all();
            return view('edit', ['poem' => $poem,'authors' => $poets, 'genres' => $genres]);
        }

        return redirect()->back();

    }


    public function subscribe(Request $request) {

        Subscription::create([
            'poet_id'=> $request->input('poet_id'),
            'user_id'=>Auth::user()->id
        ]);


        return redirect()->route('poets.show',  $request->input('poet_name'));
        


    }

    public function full_vocab(Request $request, $poem_id) {
        $vocabs = Vocab::where('poem_id', $poem_id)->get();
        
        return view('vocab', ['vocab'=>$vocabs]);
    }



}

