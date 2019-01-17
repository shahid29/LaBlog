<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::latest()->approved()->published()->paginate(6);
        return view('posts',compact('posts'));
    }


    public function details($slug)
    {
        $post = Post::where('slug',$slug)->first();
        $blogKey = 'blog_' . $post->id;

        if (!Session::has($blogKey)) {
            $post->increment('view_count');
            Session::put($blogKey,1);
        }
        $randomposts = Post::approved()->published()->InRandomOrder(3)->get();
        return view('post',compact('post','randomposts'));

    }



    public function categoyBySlug($slug){

        $category =  Category::where('slug',$slug)->first();
        $posts = $category->posts()->approved()->published()->get();
        return view('category_posts',compact('category','posts'));

    }


    public function tagBySlug($slug){

        $tag =  Tag::where('slug',$slug)->first();
        $posts = $tag->posts()->approved()->published()->get();
        return view('tag_posts',compact('tag','posts'));

    }
}
