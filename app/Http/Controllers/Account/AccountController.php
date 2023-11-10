<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        $user = Auth::user();

        return Inertia::render('Profile/Account', [
            'user' => $user,
            'tweets' => Tweet::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Tweet $tweet, Request $request)
    {
        $user = User::find($tweet->id);

        if ($request->has('updatedName')) {
            $user->name = $request->input('updatedName');
        }

        if ($request->hasFile('file')) {
            $oldImagePath = $user->image;

            $file = $request->file('file');
            $fileName = $file->storeAs('public', $file->getClientOriginalName());

            if ($fileName) {
                $user->image = basename($fileName);

                if ($oldImagePath && $oldImagePath !== 'default.jpg') {
                    Storage::delete('public/' . $oldImagePath);
                }
            }
        }

        if ($user->isDirty()) {
            $user->update();
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
