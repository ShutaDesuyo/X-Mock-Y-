<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function showProfile()
    {
        return view('settings.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:50'],
            'username'     => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z0-9_]+$/', Rule::unique('users')->ignore($user->id)],
            'bio'          => ['nullable', 'string', 'max:160'],
            'avatar'       => ['nullable', File::image()->max(2 * 1024)->dimensions(Rule::dimensions()->maxWidth(2048)->maxHeight(2048))],
            'header_image' => ['nullable', File::image()->max(5 * 1024)->dimensions(Rule::dimensions()->maxWidth(4096)->maxHeight(4096))],
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        } else {
            unset($validated['avatar']);
        }

        if ($request->hasFile('header_image')) {
            if ($user->header_image) {
                Storage::disk('public')->delete($user->header_image);
            }
            $validated['header_image'] = $request->file('header_image')->store('headers', 'public');
        } else {
            unset($validated['header_image']);
        }

        $user->update($validated);

        return back()->with('success', 'プロフィールを更新しました');
    }

    public function showPassword()
    {
        return view('settings.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        Auth::user()->update([
            'password' => $request->password,
        ]);

        return back()->with('success', 'パスワードを変更しました');
    }
}
