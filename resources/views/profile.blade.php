@extends('layouts.frontend.app')

@section('title')
    {{$author->name}}
    @endsection

@push('css')
    <link href="{{ asset('assets/frontend/css/profile/css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/frontend/css/profile/css/responsive.css') }}" rel="stylesheet">
    <style>
        .favorite_posts{
            color: blue;
        }
        .slider {
            height: 400px;
            width: 100%;
            background-image: url({{asset('storage/profile/'.$author->image)}});
            background-size: cover;
        }
    </style>
@endpush

@section('content')
    <div class="slider display-table center-text">
        <h1 class="title display-table-cell"><b>ALL POSTS OF {{$author->name}}</b></h1>
    </div><!-- slider -->

    <section class="blog-area section">
        <div class="container">

            <div class="row">

                <div class="col-lg-8 col-md-12">
                    <div class="row">
                        @if($posts->count()>0)
        @foreach($posts as $post)
                        <div class="col-md-6 col-sm-12">
                            <div class="card h-100">
                                <div class="single-post post-style-1">

                                    <div class="blog-image"><img src="{{ asset('storage/post/'.$post->image) }}" alt="{{ $post->title }}"></div>

                                    <a class="avatar" href="{{route('author.profile',$post->user->username)}}"><img src="{{asset('storage/profile/'.$post->user->image) }}" alt="Profile Image"></a>

                                    <div class="blog-info">

                                        <h4 class="title"><a href="{{ route('post.details',$post->slug) }}"><b>{{ $post->title }}</b></a></h4>

                                        <ul class="post-footer">

                                            <li>
                                                @guest
                                                    <a href="javascript:void(0);" onclick="toastr.info('To add favorite list. You need to login first.','Info',{
                                                    closeButton: true,
                                                    progressBar: true,
                                                })"><i class="ion-heart"></i>{{ $post->favorite_to_users->count() }}</a>
                                                @else
                                                    <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{ $post->id }}').submit();"
                                                       class="{{ !Auth::user()->favorite_posts->where('pivot.post_id',$post->id)->count()  == 0 ? 'favorite_posts' : ''}}"><i class="ion-heart"></i>{{ $post->favorite_to_users->count() }}</a>

                                                    <form id="favorite-form-{{ $post->id }}" method="POST" action="{{ route('post.favorite',$post->id) }}" style="display: none;">
                                                        @csrf
                                                    </form>
                                                @endguest

                                            </li>
                                            <li>
                                                <a href="#"><i class="ion-chatbubble"></i>{{ $post->comments->count() }}</a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="ion-eye"></i>{{ $post->view_count }}</a>
                                            </li>
                                        </ul>

                                    </div><!-- blog-info -->
                                </div><!-- single-post -->
                            </div>
                        </div><!-- col-md-6 col-sm-12 -->
                        <!-- col-md-6 col-sm-12 -->
        @endforeach
                            @else
                            <div class="col-lg-12 col-md-6">
                                <div class="card h-100">
                                    <div class="single-post post-style-1">

                                        <div class="blog-image"><img src="" alt=""></div>

                                        <div class="blog-info">

                                            <h4 class="title">Sorry, No post found <strong style="color: red">{{$author->name}}</strong></h4>

                                        </div><!-- blog-info -->
                                    </div><!-- single-post -->
                                </div><!-- card -->
                            </div><!-- col-lg-4 col-md-6 -->
                        @endif
                    </div><!-- row -->

                </div><!-- col-lg-8 col-md-12 -->

                <div class="col-lg-4 col-md-12 ">

                    <div class="single-post info-area ">

                        <div class="about-area">
                            <h4 class="title"><b>ABOUT BONA</b></h4>
                            <p>{{$author->name}}</p><br>
                            <p>{{$author->about}}</p><br>
                            <strong>Author Since :{{$author->created_at->toDateString()}} </strong><br>
                            <strong>Total Post :{{$author->posts->count()}} </strong>
                        </div>

                        <div class="subscribe-area">

                            <h4 class="title"><b>SUBSCRIBE</b></h4>
                            <div class="input-area">
                                <form method="POST" action="{{ route('subscriber.store') }}">
                                    @csrf
                                    <input class="email-input" name="email" type="email" placeholder="Enter your email">
                                    <button class="submit-btn" type="submit"><i class="icon ion-ios-email-outline"></i></button>
                                </form>
                            </div>

                        </div><!-- subscribe-area -->


                    </div><!-- info-area -->

                </div><!-- col-lg-4 col-md-12 -->

            </div><!-- row -->

        </div><!-- container -->
    </section><!-- section -->



@endsection

@push('js')

@endpush