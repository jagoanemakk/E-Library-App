<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class ManajemenBukuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.manajemen.index', [
            'data' => User::where('user_id', auth()->user()->id)->with('users'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBukuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'nama_buku' => 'required',
                'author' => 'required',
            ],
            [
                'nama_buku.required' => 'Nama buku wajib di isi',
                'author.required' => 'Author wajib di isi',
            ],
        );

        $validatedData['user_id'] = auth()->user()->id;
        // dd($validatedData);

        Buku::create($validatedData);

        return redirect('/manajemen-buku')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Buku::find($id);
        return response()->json($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBukuRequest  $request
     * @param  \App\Models\Buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = validator(
            $request->all(),
            [
                // 'user_id' => "required",
                'nama_buku' => 'required',
                'author' => 'required',
            ],
            [
                'nama_buku.required' => 'Nama wajib di isi',
                'author.required' => 'Author wajib di isi',
            ],
        );

        // dd($validatedData);

        if ($validatedData->fails()) {
            return response()->json([
                'status' => 201,
                'message' => $validatedData->errors()->first(),
            ]);
        }

        // dd($data);
        // $data->update([
        //     'user_id' => auth()->user()->id,
        //     'nama_buku' => $request->input('nama_buku'),
        //     'author' => $request->input('author'),
        // ]);

        // dd($validatedData);
        $validatedData = Buku::find($request->id);
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['nama_buku'] = $request->input('nama_buku');
        $validatedData['author'] = $request->input('author');
        $validatedData->save();
        // Buku::where('id', $request->id)->update($validatedData);

        return response()->json([
            'status' => 200,
            'success' => 'Data Berhasil Diubah',
        ]);

        // return redirect('/manajemen-buku');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Buku::find($id)->destroy($id);

        return response()->json([
            'success' => 'Data Berhasil Dihapus',
        ]);
    }

    public function listBuku()
    {
        $list_data = Buku::where('user_id', auth()->user()->id)->with('users');
        // $list_data = Buku::where('user_id' );
        // dd($list_data);
        return Datatables::of($list_data)
            ->addColumn('nama_buku', function ($item) {
                // dd($item);
                return $item->nama_buku;
            })
            ->addColumn('author', function ($item) {
                // dd($item->users);
                return $item->author;
            })
            ->addColumn('action', function ($item) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $item->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editBukuPost">Edit</a>';

                $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $item->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteBukuPost">Delete</a>';

                return $btn;
            })
            ->addIndexColumn()
            ->make(true);
    }
}
