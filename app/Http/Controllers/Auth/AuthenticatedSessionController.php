<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = $request->user();
        if ($user->two_factor_enabled) {
            $code = random_int(100000, 999999);
            $user->two_factor_code = $code;
            $user->two_factor_expires_at = now()->addMinute();
            $user->save();
            Mail::send('emails.2fa-login', ['code' => $code], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Your 2FA Login Code');
            });
            \Auth::logout();
            $request->session()->put('2fa:user:id', $user->id);
            return redirect()->route('auth.2fa.verify');
        }
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function show2faVerify(Request $request): View
    {
        return view('auth.2fa-verify');
    }

    public function check2faCode(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);
        $userId = $request->session()->get('2fa:user:id');
        $user = \App\Models\User::find($userId);
        if ($user && $user->two_factor_code === $request->code && $user->two_factor_expires_at && now()->lessThanOrEqualTo($user->two_factor_expires_at)) {
            $user->two_factor_code = null;
            $user->two_factor_expires_at = null;
            $user->save();
            \Auth::login($user);
            $request->session()->forget('2fa:user:id');
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard', absolute: false));
        }
        return redirect()->back()->withErrors(['code' => 'Invalid or expired code.']);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
