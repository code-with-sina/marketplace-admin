<?php

namespace App\Http\Controllers;

use App\Models\SudoToken;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules\File;

class AdminController extends Controller
{

    public function fetchUsers() {
        $response = Http::get('https://userbased.ratefy.co/api/admin/all');
        // $user = json_decode($response->body(), true);
        return response()->json(['data' => $response->body()]);
        // if($response->status() ==  200){
        //     return response()->json(['data' => $response->object(), 'staffbased' => 'i was here'], 200);
        // }else {
        //     return response()->json($response); 
        // }
    }

    public function fetchSingleUser(Request $request) {
        $response = Http::post('https://userbased.ratefy.co/api/admin/singleuser', [
            'uuid' => $request->uuid
        ]);

        return response()->json(['data' => $response->object()]);
    }

    public function fetchType(Request $request) {
        $response = Http::get('https://userbased.ratefy.co/api/admin/type');
        if($response->status() ==  200){
            return response()->json(['data' => $response->object()], 200);
        }else {
            return response()->json($response); 
        }
    }


    public function fetchStaff(Request $request) {
        $user = User::where('super', 'admin')->get();
        return response()->json(['data' => $user]);
    }

    /*
    *   Section by sesction is created for the what they contain #@User Section
    *   Neccessary comment later on here.
    */


    public function fetchWallet() {
        $response =  Http::get('https://offerbased.ratefy.co/api/admin/fetch-ewallet');
        if($response->status() ==  200){
            return response()->json(['data'  => $response->body()]);      
        }else {
            return response()->json(['data' => $response->body()], 200); 
        }
    }


    public function pauseWallet(Request $request) {
        $response = Http::post('https://offerbased.ratefy.co/api/admin/pause-ewallet', [
            'uuid'  => $request->uuid
        ]);
        if($response->status() ==  200){
            return response()->json(['data'  => $response->body()]);      
        }else {
            return response()->json(['data' => $response->body()], 200); 
        }
    }


    public function activateWallet(Request $request) {
        $response = Http::post('https://offerbased.ratefy.co/api/admin/activate-ewallet', [
            'uuid'  => $request->uuid
        ]);
        if($response->status() ==  200){
            return response()->json(['data'  => $response->body()]);      
        }else {
            return response()->json(['data' => $response->body()], 200); 
        }
    }

    public function createWalletOption(Request $request){
        $request->validate([
            'uuid'  => 'required|string',
            'option' => 'required|string'
        ]);

        $response = Http::post('https://offerbased.ratefy.co/api/admin/create-ewallet-option', [
            'uuid' => $request->uuid,
            'option' => $request->option
        ]);

        if($response->status() ==  200){
           
            return response()->json($response->body());      
        }else {
            return response()->json(['data' => $response->body()], 200); 
        }
    }

    public function fetchWalletOption(Request $request) {
        $request->validate([
            'uuid'  => 'required|string',
        ]);

        $response = Http::post('https://offerbased.ratefy.co/api/admin/fetch-ewallet-option', [
            'uuid' => $request->uuid,
        ]);

        if($response->status() ==  200){
            return response()->json($response->body());      
        }else {
            return response()->json(['data' => $response->body()], 200); 
        }
    }

    public function createWalletOptionRequirement(Request $request) {
        $request->validate([
            'uuid'          =>  'required|string',
            'requirement'   =>  'required|string',
            'option'        =>  'required|string'
        ]);

        $response = Http::post('https://offerbased.ratefy.co/api/admin/create-ewallet-option-requirement', [
            'uuid'          => $request->uuid,
            'requirement'   => $request->requirement, 
            'option'        => $request->option
        ]);

        if($response->status() ==  200){
            return response()->json(['data'  => $response->object()]);      
        }else {
            return response()->json(['data' => $response], 200); 
        }
    }


    public function getP2POrders(){
        $response = Http::get('https://transactionbased.ratefy.co/api/admin/get-p2p-data');
        if($response->status() == 200) {
            return response()->json($response->body());
        }else {
            return response()->json($response->body());
        }
        
    }

    public function getOngoingTransaction(){
        $response = Http::get('https://transactionbased.ratefy.co/api/get-p2p-by-latest-5');
        if($response->status() == 200) {
            return response()->json($response->body());
        }else {
            return response()->json($response->body());
        }
    }


    public function getCurrentTickets() {
        $response = Http::get('https://transactionbased.ratefy.co/api/get-tickets-by-latest-5');
        if($response->status() == 200) {
            return response()->json($response->body());
        }else {
            return response()->json($response->body());
        }
    }


    public function getFullOrderDetails(Request $request) {
        $request->validate([
            "session" => ['required', 'string']
        ]);

        $response = Http::get("https://transactionbased.ratefy.co/api/get-full-order-detail/{$request->session}");

        return response()->json([
            "data" => $response->body()
        ]);
    }


    


    public function cancelSession(Request $request) {
        $request->validate([
            "session" => ['required', 'string']
        ]);

        $response = Http::post("https://transactionbased.ratefy.co/api/cancel-session", [
            'session_id' => $request->session
        ]);
        return response()->json([
            "data" => $response->body()
        ]);
    }

    public function completeTransaction(Request $request) {
        $request->validate([
            "session" => ['required', 'string']
        ]);

        $response = Http::post("https://transactionbased.ratefy.co/api/complete-transaction", [
            'session_id' => $request->session
        ]);
        return response()->json([
            "data" => $response->body()
        ]);
    }


    public function reinburseSeller(Request $request) {
        $request->validate([
            "session" => ['required', 'string']
        ]);

        $response = Http::post("https://transactionbased.ratefy.co/api/complete-transaction", [
            'session_id' => $request->session
        ]);
        return response()->json([
            "data" => $response->body()
        ]);
    }

    /*
    *   Section by sesction is created for the what they contain #@Offer Section
    *   Neccessary comment later on here.
    */


    


    
    
    /*
    *   Section by sesction is created for the what they contain #@Offer Section
    *   Neccessary comment later on here.
    */








}
