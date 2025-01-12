<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        $apiUrl = env('APP_API') . '/' . env('USER_MANAGEMENT') . '/auth';
        $response = Http::post($apiUrl, [
            'email' => $request->email,
            'password' => $request->password,
        ]);
    
        $apiData = $response->json();
    
        if ($response->successful() && isset($apiData['status'], $apiData['data']['user'], $apiData['data']['token'])) {
            $request->session()->put([
                'message' => $apiData['message'],
                'user' => [
                    'id' => $apiData['data']['user']['id'],
                    'name' => $apiData['data']['user']['name'], 
                    'email' => $apiData['data']['user']['email'],
                    'role' => $apiData['data']['user']['role'],
                    'photo' => $apiData['data']['user']['photo'],
                ],
                'token' => $apiData['data']['token']
            ]);
    
            return redirect()->route('dashboard');
        }
    
        return response()->json([
            'message' => 'Login gagal atau data tidak lengkap',
            'error' => $apiData,
        ], $response->status());
    }    

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }
}
