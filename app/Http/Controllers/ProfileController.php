<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

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

    public function enable2fa(Request $request)
    {
        $user = $request->user();
        $code = random_int(100000, 999999);
        $user->two_factor_code = $code;
        $user->two_factor_expires_at = now()->addMinute();
        $user->save();

        Mail::send('emails.2fa-enable', ['code' => $code], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Your 2FA Enable Code');
        });

        return redirect()->route('profile.2fa.verify');
    }

    public function show2faVerify()
    {
        return view('profile.2fa-verify');
    }

    public function check2faCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $user = $request->user();
        if (
            $user->two_factor_code === $request->code &&
            $user->two_factor_expires_at &&
            now()->lessThanOrEqualTo($user->two_factor_expires_at)
        ) {
            $user->two_factor_code = null;
            $user->two_factor_expires_at = null;
            $user->two_factor_enabled = true;
            $user->save();
            return redirect()->route('profile.edit')->with('status', '2fa-enabled');
        }
        return redirect()->back()->withErrors(['code' => 'Invalid or expired code.']);
    }

    public function disable2fa(Request $request)
    {
        $user = $request->user();
        $code = random_int(100000, 999999);
        $user->two_factor_code = $code;
        $user->two_factor_expires_at = now()->addMinute();
        $user->save();
        Mail::send('emails.2fa-disable', ['code' => $code], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Your 2FA Disable Code');
        });
        return redirect()->route('profile.2fa.disable.verify');
    }

    public function show2faDisableVerify()
    {
        return view('profile.2fa-disable-verify');
    }

    public function check2faDisableCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);
        $user = $request->user();
        if (
            $user->two_factor_code === $request->code &&
            $user->two_factor_expires_at &&
            now()->lessThanOrEqualTo($user->two_factor_expires_at)
        ) {
            $user->two_factor_enabled = false;
            $user->two_factor_code = null;
            $user->two_factor_expires_at = null;
            $user->save();
            return redirect()->route('profile.edit')->with('status', '2fa-disabled');
        }
        return redirect()->back()->withErrors(['code' => 'Invalid or expired code.']);
    }
}
