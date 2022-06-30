<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Buku;
use App\Models\Category;

class BukuController extends Controller
{
    // hanya user yang sudah terautentikasi login yang bisa mengakses controller ini
     public function __construct()
    {
        $this->middleware('auth');
    }

    // function untuk menampilkan data buku
    public function index()
    {
        // memanggil model buku dengan relasi user dan category,
        // dimana user = user yang sedang login dan dibungkus dengan variabel books
        $books = Buku::with(['user', 'category'])->where('users_id', Auth::user()->id)->paginate(5);

        // kembali ke view dengan membawa variabel books
        return view('buku.index', [
            'books' => $books
        ]);
    }

    // function untuk membuat buku
    public function create()
    {
        // memanggil category yang statusnya aktif dan dibungkus dengan variabel category
        $category = Category::where('status', 'Aktif')->get();

        // kembali ke view dengan membawa variabel category
        return view('buku.create', [
            'category'  => $category,
        ]);
    }

    // function untuk menyimpan buku
    public function store(Request $request)
    {
        // memvalidasi request
        $request->validate([
            'category_id'   => 'required',
            'name'          => 'required|min:5|unique:buku',
            'status'        => 'required'
        ]);

        // membuat buku
        Buku::create([
            'users_id'      => Auth::user()->id,
            'category_id'   => $request->category_id,
            'name'          => $request->name,
            'status'        => $request->status,
        ]);

        // kembali ke route yang bernamakan buku.index, yang dimana buku.index itu
        // akan mengarah ke BukuController yang functionnya bernamakan index
        // dengan pesan sukses
        return redirect()->route('buku.index')->with('success', 'Successfully Add New Book!');
    }

    // function untuk mengedit buku
    public function edit($id)
    {
        // mencari buku berdasarkan paramater yaitu id yang di request dari blade dan dibungkus dengan variabel books
        $books = Buku::findOrfail($id);

        // memanggil category yang statusnya aktif dan dibungkus dengan variabel category
        $category = Category::where('status', 'Aktif')->get();

        // kembali ke view dengan membawa variabel books dan category 
        return view('buku.edit', [
            'books'     => $books,
            'category'  => $category,
        ]);
    }

    // function untuk mengupdate buku
    public function update(Request $request, $id)
    {
        // memvalidasi request
        $data = $request->validate([
                    'category_id'   => 'required',
                    'name'          => 'required|min:5|unique:buku'
                ]);

        // mencari buku berdasarkan paramater yaitu id yang di request dari blade dan dibungkus dengan variabel books
        $books = Buku::findOrfail($id);

        // update buku
        $books->update($data);

        // kembali ke route yang bernamakan buku.index, yang dimana buku.index itu
        // akan mengarah ke BukuController yang functionnya bernamakan index
        // dengan pesan sukses
        return redirect()->route('buku.index')->with('success', 'Successfully Edit Book!');
    }

    // function untuk menghapus buku atau hard delete buku
    public function destroy($id)
    {
        // mencari buku berdasarkan paramater yaitu id yang di request dari blade dan dibungkus dengan variabel books
        $books = Buku::findOrfail($id);

        // menghapus buku
        $books->delete();

        // kembali ke route yang bernamakan buku.index, yang dimana buku.index itu
        // akan mengarah ke BukuController yang functionnya bernamakan index
        // dengan pesan sukses
        return redirect()->route('buku.index')->with('success', 'Successfully Delete Book!');;
    }

    // function ini untuk soft delete kategori
    public function status($id)
    {
        // mencari buku berdasarkan paramater yaitu id yang di request dari blade dan dibungkus dengan variabel item
        $item = Buku::findOrfail($id);

        // jika buku statusnya aktif,
        if($item->status == "Aktif"){
            // maka update buku status menjadi nonaktif.
            $update = Buku::where('id', $id)->update(['status' => 'Nonaktif']);
        } else { # dan jika buku statusnya nonaktif,
            // maka update buku status menjadi aktif
            $update = Buku::where('id', $id)->update(['status' => 'Aktif']);
        }

        // kembali ke route yang bernamakan buku.index, yang dimana buku.index itu
        // akan mengarah ke BukuController yang functionnya bernamakan index
        return redirect()->route('buku.index');
    }
}
