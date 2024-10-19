<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\TestEmail;

use App\Models\Poet;
use App\Models\Poem;

class MailController extends Controller
{

    public function sendRandomSimilar(Request $request) {
        $poet_name = $request->poet_name;
        $poet = Poet::where('name', $poet_name)->first();

        $poet_for_reco = Poet::where('category', $poet->category)
            ->where('id', '<>', $poet->id)
            ->inRandomOrder()
            ->first();

        if ($poet_for_reco) {
            if ($poet_for_reco->poems->isNotEmpty()) {
                $poem_for_reco = $poet_for_reco->poems->random();
                Mail::to(Auth::user()->email)->send(new TestEmail(['user' => Auth::user(), 'poem' => $poem_for_reco]));
                return '200';
            } 
        } 
        


    }









}
