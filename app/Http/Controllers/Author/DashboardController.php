<?php

namespace App\Http\Controllers\Author;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $post = $user->posts();
        $pending = $post->where('is_approved',false)->count();
        $allviews = $post->sum('view_count');
        $populars = $user->posts()
                    ->withCount('comments')
                    ->withCount('favorite_to_users')
                    ->orderBy('view_count','desc')
                    ->orderBy('comments_count')
                    ->orderBy('favorite_to_users_count')
                    ->take(5)->get();


        return view('author.dashboard',compact('post','pending','allviews','populars'));
    }
}
