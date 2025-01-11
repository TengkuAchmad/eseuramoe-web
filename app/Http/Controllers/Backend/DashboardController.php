<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $dataUser = $request->session()->get('user');
        $message = $request->session()->get('message');
        $token = $request->session()->get('token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get(env('APP_API') . '/' . env('DATA_MANAGEMENT') . '/get/dashboard');

        $responseData = $response->json();

        $resultCount = $responseData['data']['resultCount'];
        $modelCount = $responseData['data']['modelCount'];
        $detectedCount = $responseData['data']['detectedCount'];
        $timestamp = $responseData['data']['timestamp'];

        return view('dashboard.index', compact(
            'dataUser',
            'message',
            'token',
            'resultCount',
            'modelCount',
            'detectedCount',
            'timestamp'
        ));
    }
}
