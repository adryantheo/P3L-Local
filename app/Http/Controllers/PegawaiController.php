<?php

namespace App\Http\Controllers;

use App\Pegawai;
use Illuminate\Http\Request;
use Validator;
use Auth;

class PegawaiController extends Controller
{

    
    
    public function index()
    {
        return response()->json(Pegawai::all(),200);
    }


    public function login(Request $request)
    {

        $request->validate([
            'Email' => 'required',
            'Password' => 'required',
            
        ]);
        $credentials = request(['Email', 'Password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->Pegawai();
        $tokenResult = $user->createToken('AtmaAuto');
        $token = $tokenResult->token;
        
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
        

        // if (Auth::attempt($request->only(['Email', 'Password']))) {
        //     $status = 200;
        //     $response = [
        //         'pegawai' => Auth::pegawai(),
        //         'token' => Auth::pegawai()->createToken('AtmaAuto')->accessToken,
        //     ];
        //     return response()->json([$response, $status]);
        // }

        
    }

    public function register(Request $request)
    {
        $request->validate([
            
            'Email' => 'required',
            'Password' => 'required'
        ]);
        $pegawai = new Pegawai([
            'Nama' => $request->Nama,
            'Email' => $request->Email,
            //'Password' => bcrypt($request->Password)
            'Password' => $request->Password,
            'Alamat' => $request->Alamat,
            'Gaji' => $request->Gaji,
            'Role' => $request->Role,
        ]);
        $pegawai->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);

        // $validator = Validator::make($request->all(), [
        //     'Nama' => 'required|max:50',
        //     'Email' => 'required|email',
        //     'Password' => 'required|min:6',
        //     'Alamat' => 'required|max:50',
        //     'Gaji' => 'required',
        //     'Role' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()], 401);
        // }

      
        // $data = $request->only(['Nama', 'Email', 'Password', 'Alamat', 'Gaji', 'Role']);
        

        // $pegawai = Pegawai::create($data);


        // return response()->json([
        //     'pegawai' => $pegawai,
        //     'token' => $pegawai->createToken('AtmaAuto')->accessToken,
            
        // ]);
    }

    public function gantiPassword(Request $request, Pegawai $pegawai)
    {
        $status = $pegawai->update(
            $request->only([
                'Password' => $request->Password
            ])
        );
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Password Diupdate!' : 'Error Mengupdate Password'
        ]);
    }

    public function show(Pegawai $pegawai)
    {
        return response()->json($pegawai,200);
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $status = $pegawai->update(
            $request->only([
                'Nama' => $request->Nama,
                'Email' => $request->Email,
                'Alamat' => $request->Alamat,
                'Gaji' => $request->Gaji,
                'Role' => $request->Role,                 
        
            ])
        );
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Pegawai Diupdate!' : 'Error Mengupdate Pegawai'
        ]);
    }

    public function destroy(Pegawai $pegawai)
    {
        $status = $pegawai->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Pegawai Berhasil di Hapus!' : 'Error Menghapus Pegawai'
        ]);
    }
}
