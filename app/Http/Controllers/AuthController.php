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

        $user = User::where('username','=', $request->username)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('loginUser', $user->id);

                // ตรวจสอบว่า username เป็น 'admin'
                if ($user->username === 'admin') {
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

    public function AddUser(Request $request)
    {

        $user = new User;
        $user->username = 'admin';
        $user->password = 'admin';
        $user->save();

        return back()->with('success', 'User added successfully.');
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
