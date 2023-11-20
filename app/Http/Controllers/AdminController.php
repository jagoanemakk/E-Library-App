<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;

class AdminController extends Controller
{
    public function index()
    {
        return view('dashboard.admin.index', [
            'data' => User::where('hak_akses', '!=', 'Super Admin')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'nama' => "required|string|min:3|unique:users,nama,$request->id",
                'email' => "required|string|email|unique:users,email,$request->id",
                'password' => 'required|min:5',
            ],
            [
                'nama.unique' => 'Username sudah digunakan',
                'email.unique' => 'Email sudah digunakan',
            ],
        );

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['hak_akses'] = 'Member';

        User::create($validatedData);

        return redirect('/add-admin')->with('success', 'Akun berhasil ditambahkan');

    }

    public function edit($id)
    {
        $id = User::find($id);
        return response()->json($id);
    }

    public function update(Request $request)
    {
        $validatedData = validator(
            $request->all(),
            [
                'nama' => "required|string|min:3|unique:users,nama,$request->id",
                'email' => "required|string|email|unique:users,email,$request->id",
                'hak_akses' => 'required',
            ],
            [
                'nama.min' => 'Minimal 3 Karakter',
                'nama.unique' => 'Username sudah digunakan',
                'email.max' => 'Email terlalu panjang',
                'email.unique' => 'Email sudah digunakan',
            ],
        );

        if ($validatedData->fails()) {
            return response()->json([
                'status' => 201,
                'message' => $validatedData->errors()->first(),
            ]);
        }

        $validatedData = User::find($request->id);
        $validatedData->nama = $request->input('nama');
        $validatedData->email = $request->input('email');
        $validatedData->hak_akses = $request->input('hak_akses');
        $validatedData->save();

        return response()->json([
            'success' => 'Data Berhasil Diubah',
        ]);
    }

    public function destroy($id)
    {
        User::destroy($id);

        return response()->json([
            'success' => 'Data Berhasil Dihapus',
        ]);
    }

    public function listAdmin()
    {
        $list_data = User::where('hak_akses', '!=', 'Super Admin')->get();
        // dd($list_data);

        return Datatables::of($list_data)
            ->addColumn('nama', function ($item) {
                // dd($item);
                return $item->nama;
            })
            ->addColumn('email', function ($item) {
                // dd($item->users);
                return $item->email;
            })
            ->addColumn('hak_akses', function ($item) {
                // dd($item->users);
                return $item->hak_akses;
            })
            ->addColumn('action', function ($item) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $item->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editAdminPost">Edit</a>';

                $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $item->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteAdminPost">Delete</a>';

                return $btn;
            })
            ->addIndexColumn()
            ->make(true);
    }
}
