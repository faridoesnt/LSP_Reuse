<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    // model ini akan mengakses kepada tabel buku
    protected $table = 'buku';

    // memberitahu kolom apa saja yang bisa di isi
    protected $fillable = [
        'users_id',
        'category_id',
        'name',
        'status',
    ];
    
    // function untuk relasi ke tabel user
    public function user()
    {
        // satu buku hanya bisa memiliki satu user
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    // function untuk relasi ke tabel category
    public function category()
    {
        // satu buku hanya bisa memiliki satu kategori
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
