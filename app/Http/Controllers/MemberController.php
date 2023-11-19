<?php

namespace App\Http\Controllers;

use App\Models\Buku;
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
            'data' => Buku::all(),
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
        //
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

    public function listBuku()
    {
        // $list_data = Buku::where('user_id', auth()->user()->id)->with('users');
        $list_data = Buku::all();

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
            ->addColumn('action', function ($item) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $item->id . '" data-original-title="Konfirmasi" class="edit btn btn-primary btn-sm KonfirmPost">Pinjam</a>';

                return $btn;
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function listPinjam(){
        $list_data = Buku::all();

        return Datatables::of($list_data)
            ->addColumn('nama_buku', function ($item) {
                // dd($item);
                return $item->nama_buku;
            })
            ->addColumn('tanggal_pinjam', function ($item) {
                // dd($item->users);
                return $item->peminjaman->tanggal_pinjam;
            })
            ->addColumn('tanggal_kembali', function ($item) {
                // dd($item->users);
                return $item->peminjaman->tanggal_kembali;
            })
            ->addColumn('tanggal_kembali', function ($item) {
                // dd($item->users);
                return $item->peminjaman->status;
            })
            ->addColumn('tanggal_kembali', function ($item) {
                // dd($item->users);
                return $item->peminjaman->denda;
            })
            // ->addColumn('action', function ($item) {
            //     $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $item->id . '" data-original-title="Konfirmasi" class="edit btn btn-primary btn-sm KonfirmPost">Bayar Denda</a>';

            //     return $btn;
            // })
            ->addIndexColumn()
            ->make(true);
    }
}
