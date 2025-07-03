<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class GoogleController extends Controller
{

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Googleからのコールバック処理
    public function handleGoogleCallback()
    {
        /** @var Provider $driver */
        $driver= Socialite::driver('google');
        $googleUser = $driver->stateless()->user();

        // 既存ユーザー確認 or 作成
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'password' => bcrypt(uniqid()), // ダミーのパスワード
            ]
        );

        Auth::login($user);

        return redirect()->route('dashboard'); // ログイン後に遷移させたい場所
    }
    
}
