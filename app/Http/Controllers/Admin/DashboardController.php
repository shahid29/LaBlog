<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Post;
use App\Tag;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $posts = Post::all()->count();

        $populars = Post::withCount('comments')
                        ->withCount('favorite_to_users')
                        ->orderBy('view_count','desc')
                        ->orderBy('comments_count','desc')
                        ->orderBy('favorite_to_users_count','desc')
                        ->take(5)->get();

        $pending = Post::where('is_approved',false)->count();
        $viewCount  = Post::sum('view_count');
        $category = Category::all()->count();
        $tag = Tag::all()->count();
        $authorToday = User::authors()->whereDate('created_at',Carbon::today())->count();
        $authorCount = User::authors()->count();

        $authorActive = User::authors()
                        ->withCount('posts')
                        ->withCount('comments')
                        ->withCount('favorite_posts')
                        ->orderBy('posts_count','desc')
                        ->orderBy('comments_count','desc')
                        ->orderBy('favorite_posts_count','desc')
                        ->take(10)->get();

        return view('admin.dashboard',compact('posts','populars','pending',
                                    'viewCount','category','tag','authorToday','authorCount','authorActive'));
    }
}
