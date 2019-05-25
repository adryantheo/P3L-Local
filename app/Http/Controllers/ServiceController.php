<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    
    public function index()
    {
        return response()->json(Service::all(),200);
    }

    
    public function store(Request $request)
    {
        $service = Service::create([
            'Nama_Service' => $request->Nama_Service,
            'Tarif' => $request->Tarif,
           
        ]);

        return response()->json([
            'status' => (bool) $service,
            'data'   => $service,
            'message' => $service ? 'Jasa Service Baru Berhasil Ditambahkan!' : 'Error Menambahkan Jasa Service Baru'
        ]);
    }

    
    public function show(Service $service)
    {
        return response()->json($service,200);
    }

    
    public function update(Request $request, Service $service)
    {
        $status = $service->update(
            $request->only([
                'Nama_Service', 
                'Tarif', 
               
        
            ])
        );
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Jasa Service Diupdate!' : 'Error Mengupdate Jasa Service'
        ]);
    }

    public function destroy(Service $service)
    {
        $status = $service->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Jasa Service Berhasil di Hapus!' : 'Error Menghapus Jasa Service'
        ]);
    }
}
