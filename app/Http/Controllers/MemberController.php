<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
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
            'data' => Buku::where('status', '=', 'Ada')->with('users')->get(),
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
    public function detailBuku(Request $request)
    {
        $book = Buku::find($request->id);

        return response()->json($book);
    }

    public function actionPinjam(Request $request)
    {

        $book = Buku::where('id', $request->id)->first();
        $book->update([
            'status' => 'Dipinjam'
        ]);

        $book = Peminjaman::create([
            'user_id' => $request->id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => Carbon::now(),
            'tanggal_kembali' => Carbon::now()->addDays(5)
        ]);

        if ($book) {
            return redirect()->route('admin.game-setting.index')->with(['success' => 'Buku Berhasil Dipinjam']);
        } else {
            return redirect()->route('admin.game-setting.index')->with(['error' => 'Gagal']);
        }
    }

    public function listKoleksi()
    {
        $list_data = Buku::where('status', '=', 'Ada');

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
                return $item->status;
            })
            ->addColumn('action', function ($item) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $item->id . '" data-original-title="Pinjam" class="pinjamBuku"><i class="fas fa-solid fa-cart-plus"></i></a>';

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
