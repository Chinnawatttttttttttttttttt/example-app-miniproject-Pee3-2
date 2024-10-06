<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;

class AuthController extends Controller
{
    public function login()
    {
        return view('Auth.login');
    }

    public function loginUser(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($loginType, '=', $request->username)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('loginUser', $user->id);

                if ($user->username === 'admin' || $user->email === 'admin@gmail.com') {
                    return redirect('home');
                } else {
                    return redirect('homee');
                }
            } else {
                return back()->with('fail', 'ชื่อผู้ใช้หรือรหัสผ่านไม่ตรงกัน');
            }
        } else {
            return back()->with('fail', 'ชื่อผู้ใช้นี้ยังไม่ได้ลงทะเบียน');
        }
    }

    public function register()
    {
        return view('Auth.register');
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            return redirect('login')->with('success', 'ลงทะเบียนเรียบร้อย');
        } else {
            return back()->with('fail', 'ลงทะเบียนไม่สําเร็จ');
        }
    }


    public function getUserAccount(Request $request)
    {
    $userId = $request->session()->get('loginUser');
    $user = User::find($userId);

    return $user;
    }

    public function logout(Request $request)
    {
        if(Session::has('loginUser')){
            Session::pull('loginUser');
            return redirect('login');
        }
    }
}
