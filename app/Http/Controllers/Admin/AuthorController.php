<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    public function index(){
        $authors = User::authors()->get();
        return view('admin.authors',compact('authors'));
    }

    public function destroy($id){
        $author = User::findorFail($id);
        $author->delete();
        Toastr::success('Author Successfully Deleted','Success');
        return redirect()->back();
    }
}
