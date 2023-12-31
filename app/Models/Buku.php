<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $table = "table_buku";

    protected $fillable = [
        'nama_buku',
        'author',
        'user_id',
        'deskripsi',
        'status_buku',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transaksi()
    {
        return $this->belongsTo(Peminjaman::class, 'buku_id', 'id');
    }
}
