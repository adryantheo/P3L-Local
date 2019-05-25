<?php

namespace App\Http\Controllers;

use App\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    
    public function index()
    {
        return response()->json(Sales::all(),200);
    }

    public function all()
    {
        return response()->json(
            Sales::with(['pesanan_barangs.detail_pesanans' ])->get(),200);
    }

    
    public function store(Request $request)
    {
        $sales = Sales::create([
            'Nomor_Telphone_Sales' => $request->Nomor_Telphone_Sales,
            'Nama_Sales' => $request->Nama_Sales,
            'Nama_Supplier' => $request->Nama_Supplier,
            'Alamat_Sales' => $request->Alamat_Sales,
            
            
        ]);

        return response()->json([
            'status' => (bool) $sales,
            'data'   => $sales,
            'message' => $sales ? 'Sales Baru Berhasil Ditambahkan!' : 'Error Menambahkan Sales Baru'
        ]);
    }

   
    public function show(Sales $sales)
    {
        return response()->json($sales,200);
    }

 
    public function update(Request $request, Sales $sales)
    {
        $status = $sales->update(
            $request->only([
                'Nomor_Telphone_Sales', 
                'Nama_Sales',
                'Nama_Supplier',
                'Alamat_Sales'
               
        
            ])
        );
        return response()->json([
            'status' => $status,
            'message' => $status ? ' Sales Diupdate!' : 'Error Mengupdate Sales'
        ]);
    }

   
    public function destroy(Sales $sales)
    {
        $status = $sales->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Sales Berhasil di Hapus!' : 'Error Menghapus Sales'
        ]);
    }
}
