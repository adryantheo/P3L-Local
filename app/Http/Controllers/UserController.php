<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Validator;
use Carbon\Carbon;


class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all(),200);
    }


    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ];
        
        $status = 401;
        $response = ['error' => 'Unauthorised'];
        
        if (Auth::attempt($credentials)) {
            $status = 200;
            $response = [
                'token' => Auth::user()->createToken('AtmaAuto')->accessToken,
                'user' => Auth::user()
            ];
        }
        
        return response()->json($response, $status);


        
    }

    public function register(Request $request)
    {
        $request->validate([
            
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = new User([
            'Nama' => $request->Nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),            
            'Alamat' => $request->Alamat,
            'Gaji' => $request->Gaji,
            'Role' => $request->Role, 
        ]);
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);

       
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function gantipassword(Request $request, $user)
    {
       
       $status = User::find($user);
       $status->password = bcrypt($request->password);
       $status->update();
        
        return response()->json([
            'status' => $status,
            'message' => $status ? 'password Diupdate!' : 'Error Mengupdate password'
        ]);
    }

    public function show(User $user)
    {
        return response()->json($user,200);
    }

    public function update(Request $request, $user)
    {
        // $status = $user->update(
        //     $request->only([
        //         'Nama' => $request->Nama,
        //         'email' => $request->email,
        //         'Alamat' => $request->Alamat,
        //         'Gaji' => $request->Gaji,
        //         'Role' => $request->Role,
        //         'password' => bcrypt($request->password) 
        //     ])
        // );

        $status = User::find($user);
        $status->Nama= $request['Nama'];
        $status->email= $request['email'];
        $status->Alamat= $request['Alamat'];
        $status->Gaji= $request['Gaji'];
        $status->Role= $request['Role'];
        $status->password = bcrypt($request['password']);
        $status->update();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'User Diupdate!' : 'Error Mengupdate User'
        ]);
    }

    public function destroy(User $user)
    {
        $status = $user->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'User Berhasil di Hapus!' : 'Error Menghapus User'
        ]);
    }
}
