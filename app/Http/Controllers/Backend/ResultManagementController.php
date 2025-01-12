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

        
        

        try {
            $validated = $request->validate([
                'Title_RI' => 'required|string|max:255',
                'Latitude_SRI' => 'required|numeric',
                'Longitude_SRI' => 'required|numeric',
                'Kabupaten_SRI' => 'required|string|max:255',
                'Desa_SRI' => 'required|string|max:255',
                'Kecamatan_SRI' => 'required|string|max:255',
                'Umur_SORI' => 'required|string|max:50',
                'Lereng_SORI' => 'required|string|max:50',
                'Drainase_SORI' => 'required|string|max:255',
                'Genangan_SORI' => 'required|string|max:50',
                'Topografi_SORI' => 'required|string|max:255',
                'BahayaErosi_SORI' => 'required|string|max:255',
                'BatuanPer_SORI' => 'required|string|max:50',
                'BatuanSin_SORI' => 'required|string|max:50',
                'Ketinggian_SORI' => 'required|string|max:50',
                'ALB_PRI' => 'required|numeric|between:0,100',
                'Rendemen_PRI' => 'required|numeric|between:0,100',
                'Densitas_PRI' => 'required|numeric|between:0,10',
                'Min_TRI' => 'required|numeric',
                'Max_TRI' => 'required|numeric|gt:Min_TRI',
                'Min_GRI' => 'required|numeric',
                'Max_GRI' => 'required|numeric|gt:Min_GRI'
            ], [
                'Title_RI.required' => 'Title field is required',
                'Latitude_SRI.required' => 'Latitude field is required',
                'Latitude_SRI.numeric' => 'Latitude must be a number',
                'Longitude_SRI.required' => 'Longitude field is required',
                'Longitude_SRI.numeric' => 'Longitude must be a number',
                'Kabupaten_SRI.required' => 'Kabupaten field is required',
                'Desa_SRI.required' => 'Desa field is required',
                'Kecamatan_SRI.required' => 'Kecamatan field is required',
                'ALB_PRI.numeric' => 'ALB must be a number',
                'ALB_PRI.between' => 'ALB must be between 0 and 100',
                'Rendemen_PRI.numeric' => 'Rendemen must be a number',
                'Rendemen_PRI.between' => 'Rendemen must be between 0 and 100',
                'Densitas_PRI.numeric' => 'Densitas must be a number',
                'Max_TRI.gt' => 'Maximum transmittan must be greater than minimum transmittan',
                'Max_GRI.gt' => 'Maximum gelombang must be greater than minimum gelombang'
            ]);
        
            $data = [
                'title' => $request->Title_RI,
                'latitude' => (float)$request->Latitude_SRI,
                'longitude' => (float)$request->Longitude_SRI,
                'kabupaten' => $request->Kabupaten_SRI,
                'desa' => $request->Desa_SRI,
                'kecamatan' => $request->Kecamatan_SRI,
                'umur' => $request->Umur_SORI,
                'lereng' => $request->Lereng_SORI,
                'drainase' => $request->Drainase_SORI,
                'genangan' => $request->Genangan_SORI,
                'topografi' => $request->Topografi_SORI,
                'erosi' => $request->BahayaErosi_SORI,
                'batuanper' => $request->BatuanPer_SORI,
                'batuansin' => $request->BatuanSin_SORI,
                'ketinggian' => $request->Ketinggian_SORI,
                'alb' => (float)$request->ALB_PRI,
                'rendemen' => (float)$request->Rendemen_PRI,
                'densitas' => (float)$request->Densitas_PRI,
                'min_transmittan' => (float)$request->Min_TRI,
                'max_transmittan' => (float)$request->Max_TRI,
                'min_gelombang' => (float)$request->Min_GRI,
                'max_gelombang' => (float)$request->Max_GRI
            ];
            Log::info('Request Data', $data);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->post(env('APP_API') . '/' . env('RESULT_MANAGEMENT') . '/create', $data);

            Log::info('API Response', [
                'status' => $response->status(),
                'body' => $response->json()
            ]);

            if ($response->successful()) {
                Log::info('Data created successfully', [
                    'title' => $request->Title_RI
                ]);
                return redirect()->route('result.index')->with('message', 'Data created successfully');
            }

            Log::error('Failed to create data', [
                'status' => $response->status(),
                'error' => $response->json()
            ]);
            return redirect()->back()->with('error', 'Failed to create data');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Data validation failed', [
                'errors' => $e->errors()
            ]);
            return redirect()->back()->with('error', 'Failed to create data: ' . collect($e->errors())->first()[0]);
        }
    }

}
