<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SudoToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    //
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = User::where('email', $request->email)->first();
            $tokenResult = $user->createToken($user->name);
            $token = $tokenResult->plainTextToken;
            return response()->json(['status' => 'successfull', 'user' => $user, 'token' => $token], 200);
        }
        return response()->json(['email' => 'The provided credentials do not match our records.'], 400);
    }

    public function register(Request $request){
        if($request->sudo !== null) {
            SudoToken::where('token', $request->sudo)->update(['status' => 'used']);
            $request->validate([
                'email' => ['required', 'email'],
                'name'  => ['required'],
                'password' => ['required'],
            ]);
    
           $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'super'     => 'superadmin',
                'authority' => 'boss',
                'alias'     => 'boss',
                'status'    => 'active'
           ]);
        //    $request->session()->regenerate();
           return response()->json(['data' => $user], 200);
        }else{
            $request->validate([
                'email' => ['required', 'email'],
                'name'  => ['required'],
                'password' => ['required'],
            ]);
    
           $user = User::create([
                'name'  => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
                
           ]);
        //    $request->session()->regenerate();
           return response()->json(['data' => $user], 200);
        }
        
    }


    public function logout(Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
        return response()->json(['status' => 'successfull'], 200);
    }


    public function getListOfAdminStaff() {
        $data = User::where('super', 'admin')->whereIn('status', ['active','intern','nysc','training','contract'])->get();
        return response()->json($data);
    }
}
