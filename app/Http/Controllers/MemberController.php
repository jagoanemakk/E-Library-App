<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.member.koleksi', [
            'data' => Buku::where('status_buku', '=', 'Ada')->with('users')->get(),
        ]);
    }

    public function library()
    {
        return view('dashboard.peminjaman.library', [
            // 'data' => Buku::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book = Buku::find($request->id);

        return response()->json($book);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function listKoleksi()
    {
        // $list_data = Buku::where('user_id', auth()->user()->id)->with('users');
        $list_data = Buku::where('status_buku', '=', 'Ada');

        return Datatables::of($list_data)
            ->addColumn('nama_buku', function ($item) {
                // dd($item);
                return $item->nama_buku;
            })
            ->addColumn('author', function ($item) {
                // dd($item->users);
                return $item->author;
            })
            ->addColumn('deskripsi', function ($item) {
                // dd($item->users);
                return $item->deskripsi;
            })
            ->addColumn('status', function ($item) {
                // dd($item->users);
                return $item->status_buku;
            })
            ->addColumn('action', function ($item) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $item->id . '" data-original-title="Pinjam" class="edit btn btn-primary btn-sm pinjamBuku">Pinjam</a>';

                return $btn;
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function listPinjam()
    {
        $list_data = Peminjaman::where('user_id', auth()->user()->id)
        ->with('users', 'buku');

        return Datatables::of($list_data)
            ->addColumn('nama_buku', function ($item) {
                // dd($item);
                return $item->buku->nama_buku;
            })
            ->addColumn('tanggal_pinjam', function ($item) {
                // dd($item->users);
                return $item->tanggal_pinjam;
            })
            ->addColumn('tanggal_kembali', function ($item) {
                // dd($item->users);
                return $item->tanggal_kembali;
            })
            ->addColumn('status', function ($item) {
                // dd($item->users);
                return $item->status_pinjam;
            })
            ->addColumn('denda', function ($item) {
                // dd($item->users);
                return $item->denda;
            })
            ->addColumn('action', function ($item) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $item->id . '" data-original-title="Bayar Denda" class="edit btn btn-primary btn-sm bayarDenda">Bayar Denda</a>';

                return $btn;
            })
            ->addIndexColumn()
            ->make(true);
    }
}
