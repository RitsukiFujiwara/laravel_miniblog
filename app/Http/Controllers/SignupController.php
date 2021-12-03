<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\TokyoAddress;
use Illuminate\Support\Facades\Auth;

class SignupController extends Controller
{
    public function index()
    {
        return view('signup');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email:filter', Rule::unique('users')],
            'password' => ['required', 'string', 'min:8'],
            // 'address' => ['required_if:pref, 東京都'],
            // 'address' => [new TokyoAddress($request->input('pref'))]
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            //ハッシュ化
            'password' => bcrypt($data['password']),
        ]);
        Auth::login($user);

        return redirect('mypage');
    }
}
