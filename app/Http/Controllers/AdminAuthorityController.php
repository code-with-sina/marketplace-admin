<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\SudoToken;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;



class AdminAuthorityController extends Controller
{
    //

    public function generateToken() {

        $six_digit_random_number = random_int(100000, 999999);
        $check = SudoToken::where('status', 'generated')->first();
        if($check == null){
            $token = SudoToken::create([
                'token' => $six_digit_random_number,
                'storeId' => Str::uuid(),
                'status'  => 'generated'
            ]);
            Http::post('https://api.ng.termii.com/api/sms/send', [
                'from'  => 'Ratefy',
                'to'    => '+2347049251830',
                'sms'   => "Dear Ratefy Super Admin, your authentication code :: ".$token->token. ". Do not share.",
                'type'  => 'dnd',
                'channel' => 'generic',
                'api_key'   => 'TLN6WXNS4VtM5n08puP15RPhsZhDRfyH64Ybi47mEkG5dFyQQ7DtCnYpk4eNk4',
            ]);
            return response()->json([
                'data' => $token->token
            ]);
        }else{
            Http::post('https://api.ng.termii.com/api/sms/send', [
                'from'  => 'Ratefy',
                'to'    => '+2348141868261',
                'sms'   => "Super Admin token has been generated before. kindly use it",
                'type'  => 'plain',
                'channel' => 'generic',
                'api_key'   => 'TLN6WXNS4VtM5n08puP15RPhsZhDRfyH64Ybi47mEkG5dFyQQ7DtCnYpk4eNk4',
            ]);

            return response()->json([
                'data' => 'Token has been generated and not used'
            ]);
        }
        
    }


    public function createAdmin(Request $request) 
    {
        $request->validate([
            'email'     => ['required', 'email'],
            'name'      => ['required', 'string'],
            'alias'     => ['required', 'string'],
            'mobile'    => ['required', 'string'],
            'authority' => ['required', 'string'],
            'status'    => ['required', 'string']
        ]);
        $getPassword = $this->generatePassword();
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($getPassword),
            'status'    => $request->status,
            'alias'         => $request->alias,
            'authority'     => $request->authority,
            'mobile'        => $request->mobile
       ]);

       //send email to the admin with thier credentials
       return response()->json(['data' => $user, 'password' => $getPassword], 200);

    }

    public function generatePassword() {
        $length = 16;
        $characters = '*&^%$#@!0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $str = '';
        $max = mb_strlen($characters, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $characters[random_int(0, $max)];
        }
        return $str;
    }

    public function revokeAdmin(Request $request)
    {
        User::find($request->id)->update(['status' => $request->status]);
        return response()->json(['message' => 'success'], 200);
    }

    public function sackAdmin(Request $request)
    {
        User::find($request->id)->update(['status' => $request->status]);
        return response()->json(['message' => 'success'], 200);
    }

    public function promoteAdmin(Request $request)
    {
        User::find($request->id)->update(['authority' => $request->authority]);
        return response()->json(['message' => 'success'], 200);
    }

    public function queryAdmin(Request $request)
    {
        User::find($request->id)->update(['status' => $request->status]);
        return response()->json(['message' => 'success'], 200);
    }

    public function changeAdminStatus(Request $request)
    {
        User::find($request->id)->update(['status' => $request->status]);
        return response()->json(['message' => 'success'], 200);
    }

    public function getTrackFromFrontEnd() {
        $data = Http::get('https://p2p.ratefy.co/api/auditrail');

        return response()->json($data->object());
    }

    public function getTrackFromFrontEndForSingleUser($uuid) {
        $data = Http::get('https://p2p.ratefy.co/api/user-trail/'.$uuid);

        return response()->json($data->object());
    }

    public function getErrorLogFromFrontEnd() {
        $data = Http::get('https://p2p.ratefy.co/api/logtrail');

        return response()->json($data->object());
    }

    public function getErrorLogFromFrontEndForSingleUser($uuid) {
        $data = Http::get('https://p2p.ratefy.co/api/logtrail/'.$uuid);

        return response()->json($data->object());
    }


    public function getUserTrail(Request $rquest) {

     
        // $data = Http::get('https://p2p.ratefy.co/api/user-trail/'.$request->uuid);

        // return response()->json($data->object());
    }

    public function getUserTrailByDate($uuid, $date) {
        $data = Http::get('https://p2p.ratefy.co/api/user-trail/'.$uuid.'/'.$date);

        return response()->json($data->object());
    }

}
