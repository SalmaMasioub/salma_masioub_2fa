<?php

namespace App\Http\Controllers;

use App\Mail\TwoFactorCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class TwoFactorController extends Controller
{
    public function enable(Request $request)
    {
        $user = $request->user();
        $user->two_factor_enabled = true;

        $this->sendTwoFactorCode($user);

        $user->save();

        session(['two_factor:user_id' => $user->id]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session(['two_factor:user_id' => $user->id]);

        return redirect()->route('two-factor.verify')->with('status', 'Two-factor authentication enabled. Please check your email for the code.');
    }

    public function showVerifyForm()
    {
        return view('auth.two-factor-verify');
    }

    public function verify(Request $request)
    {
        dd($request->code);
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $userId = session('two_factor:user_id');
     if (!$userId) {
            return redirect()->route('login')->withErrors('Session expired. Please login again.');
        }

        $user = User::find($userId);

        if (!$user || !$user->two_factor_code || $user->two_factor_code !== $request->code || $user->two_factor_expires_at < now()) {
            return back()->withErrors(['code' => 'Invalid or expired code.']);
        }

        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;
        $user->save();

        Auth::login($user);
       session(['two_factor_verified' => true]);
$request->session()->save(); 

        return redirect()->route('dashboard');
    }

    protected function sendTwoFactorCode($user)
    {
        $code = random_int(100000, 999999);
        $user->two_factor_code = $code;
        $user->two_factor_expires_at = now()->addMinutes(10);
        $user->save();

        Mail::to($user->email)->send(new TwoFactorCodeMail($code));
    }
}
