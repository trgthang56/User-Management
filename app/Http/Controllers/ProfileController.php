<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's avatar.
     */
    public function updateAvatar(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,svg',
        ]);
        $user = User::find($request->user()->id);

        if ($user->avatar == null) {
            $avatarName = time() . '-' . $request->user()->id . '_image.' . $validatedData['avatar']->extension();
            $request->file('avatar')->move(public_path('uploads'), $avatarName);
        } else {
            $currentFilePath = public_path('uploads') . '/' . $user->avatar;
            unlink($currentFilePath);
            $avatarName = time() . '-' . $request->user()->id . '_image.' . $validatedData['avatar']->extension();
            $request->file('avatar')->move(public_path('uploads'), $avatarName);
        }

        $user ->avatar = $avatarName;
        $user -> save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
