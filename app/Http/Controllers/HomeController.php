<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Buku;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::where('id', Auth::user()->id)->count();

        $books = Buku::where('users_id', Auth::user()->id)->count();

        $widget = [
            'users' => $users,
            'books' => $books,
        ];

        return view('home', [
            'widget' => $widget,
        ]);
    }
}
