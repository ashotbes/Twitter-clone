<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return Inertia::render('Welcome', [
            'tweets' => Tweet::orderBy('id', 'desc')->get(),
            'user' => $user,
        ]);
    }

    public function store(Request $request)
    {
        $file = null;
        $extension = null;
        $fileName = null;
        $path = '';

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $request->validate([
                'file' => 'required|mimes:jpg,jpeg,png,mp4,video/mp4',
            ]);
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $extension === 'mp4' ? $path = '/videos/' : $path = '/pics/';

            $file->move(public_path($path), $fileName);
        }

        $tweet = new Tweet();
        $tweet->name = "AshotLavTxayeee";
        $tweet->user_id = 1;
        $tweet->image = 'https://randomuser.me/api/portraits/men/59.jpg';
        $tweet->tweet = $request->tweet;
        $tweet->handle = $request->handle;
        $tweet->file = $path . $fileName;
        $tweet->is_video = $extension === 'mp4' ? true : 0;
        $tweet->save();

        return redirect()->route('tweets.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet)
    {
        $tweet->delete();
        return redirect()->back(302);
    }



}
