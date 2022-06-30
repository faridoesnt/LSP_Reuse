<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // model ini akan mengakses kepada tabel category
    protected $table = 'category';

    // memberitahu kolom apa saja yang bisa di isi
    protected $fillable = [
        'users_id',
        'name',
        'status',
    ];
    
    // function untuk relasi ke tabel user
    public function user()
    {
        // satu kategori hanya bisa memiliki satu user
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    // function untuk relasi ke tabel buku
    public function buku()
    {
        // satu kategori bisa memiliki banyak buku
        return $this->hasMany(Buku::class, 'category_id', 'id');
    }
}
