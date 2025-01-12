<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ResultManagementController extends Controller
{
    public function index(Request $request)
    {
        $dataUser = $request->session()->get('user');
        $token = $request->session()->get('token');

        if ($request->ajax()) {
            $token = session()->get('token');
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get(env('APP_API') . '/' . env('RESULT_MANAGEMENT') . '/find/all');

            if ($response->successful()) {
                $data = $response->json()['data'];
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
            }
        }

        return view('dashboard.result-management.index', compact('dataUser'));
    }

    public function create(Request $request)
    {
        $dataUser = $request->session()->get('user');
        $token = $request->session()->get('token');
        return view('dashboard.result-management.create', compact('dataUser'));
    }

    public function store(Request $request)
    {
        $token = session()->get('token');
        
        $data = [
            'title' => $request->Title_RI,
            'latitude' => (float)$request->Latitude_SRI,
            'longitude' => (float)$request->Longitude_SRI,
            'kabupaten' => $request->Kabupaten_SRI,
            'desa' => $request->Desa_SRI,
            'kecamatan' => $request->Kecamatan_SRI,
            'umur' => (string)$request->Umur_SORI,
            'lereng' => (string)$request->Lereng_SORI,
            'drainase' => (string)$request->Drainase_SORI,
            'genangan' => (string)$request->Genangan_SORI,
            'topografi' => (string)$request->Topografi_SORI,
            'erosi' => (string)$request->BahayaErosi_SORI,
            'batuanper' => (string)$request->BatuanPer_SORI,
            'batuansin' => (string)$request->BatuanSin_SORI,
            'ketinggian' => (string)$request->Ketinggian_SORI,
            'alb' => (float)$request->ALB_PRI,
            'rendemen' => (float)$request->Rendemen_PRI,
            'densitas' => (float)$request->Densitas_PRI,
            'min_transmittan' => (float)$request->Min_TRI,
            'max_transmittan' => (float)$request->Max_TRI,
            'min_gelombang' => (float)$request->Min_GRI,
            'max_gelombang' => (float)$request->Max_GRI
        ];

        Log::info('Request Data:', $data);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->post(env('APP_API') . '/' . env('RESULT_MANAGEMENT') . '/create', $data);

        Log::info('API Response:', ['status' => $response->status(), 'body' => $response->json()]);

        if ($response->successful()) {
            return redirect()->route('result.index')->with('success', 'Data created successfully');
        }

        return redirect()->back()->with('error', 'Failed to create data');
    }
}
