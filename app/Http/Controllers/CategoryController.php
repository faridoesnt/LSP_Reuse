<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;

class CategoryController extends Controller
{
    // hanya user yang sudah terautentikasi login yang bisa mengakses controller ini
    public function __construct()
    {
        $this->middleware('auth');
    }

    // function untuk menampilkan data category
    public function index()
    {
        // memanggil model category dengan relasi user,
        // dimana user = user yang sedang login dan dibungkus dengan variabel category 
        $category = Category::with(['user'])->where('users_id', Auth::user()->id)->paginate(5);

        // kembali ke view dengan membawa variabel kategori
        return view('category.index', [
            'category' => $category
        ]);
    }

    // function untuk membuat kategori
    public function create()
    {
        // kembali ke view
        return view('category.create');
    }

    // function untuk menyimpan kategori
    public function store(Request $request)
    {
        // memvalidasi request
        $request->validate([
            'name'      => 'required|min:5|unique:category',
            'status'    => 'required'
        ]);

        // membuat category
        Category::create([
            'users_id'  => Auth::user()->id,
            'name'      => $request->name,
            'status'    => $request->status,
        ]);

        // kembali ke route yang bernamakan category.index, yang dimana category.index itu
        // akan mengarah ke CategoryController yang functionnya bernamakan index
        // dengan pesan sukses
        return redirect()->route('category.index')->with('success', 'Successfully Add New Category!');
    }

    // function untuk mengedit kategori
    public function edit($id)
    {
        // mencari category berdasarkan paramater yaitu id yang di request dari blade dan dibungkus dengan variabel category
        $category = Category::findOrfail($id);

        // kembali ke view dengan membawa variabel category
        return view('category.edit', [
            'category' => $category
        ]);
    }

    // function untuk mengupdate kategori
    public function update(Request $request, $id)
    {
        // memvalidasi request dibungkus dengan variabel data
        $data = $request->validate([
                    'name' => 'required|min:5|unique:category'
                ]);

        // mencari category berdasarkan paramater yaitu id yang di request dari blade dan dibungkus dengan variabel category
        $category = Category::findOrfail($id);

        // update kategori
        $category->update($data);

        // kembali ke route yang bernamakan category.index, yang dimana category.index itu
        // akan mengarah ke CategoryController yang functionnya bernamakan index
        // dengan pesan sukses
        return redirect()->route('category.index')->with('success', 'Successfully Edit Category!');
    }

    // function untuk menghapus kategori atau hard delete kategori
    public function destroy($id)
    {
        // mencari category berdasarkan paramater yaitu id yang di request dari blade dan dibungkus dengan variabel category
        $category = Category::findOrfail($id);

        // menghapus kategori
        $category->delete();

        // kembali ke route yang bernamakan category.index, yang dimana category.index itu
        // akan mengarah ke CategoryController yang functionnya bernamakan index
        // dengan pesan sukses
        return redirect()->route('category.index')->with('success', 'Successfully Delete Category!');;
    }

    // function ini untuk soft delete kategori
    public function status($id)
    {
        // mencari category berdasarkan paramater yaitu id yang di request dari blade dan dibungkus dengan variabel item
        $item = Category::findOrfail($id);

        // jika category statusnya aktif,
        if($item->status == "Aktif"){
            // maka update kategori status menjadi nonaktif.
            $update = Category::where('id', $id)->update(['status' => 'Nonaktif']);
        } else { # dan jika category statusnya nonaktif,
            // maka update kategori status menjadi aktif
            $update = Category::where('id', $id)->update(['status' => 'Aktif']);
        }

        // kembali ke route yang bernamakan category.index, yang dimana category.index itu
        // akan mengarah ke CategoryController yang functionnya bernamakan index
        return redirect()->route('category.index');
    }
}
