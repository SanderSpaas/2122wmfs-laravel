@extends('layout')
@section('title', 'Blogotopia | '.$blogpost[0]->title)
@section('content')
    <main class="container">
        <div class="row g-5">
            <div class="col-md-8">
                <article class="blog-post">
                    <h2 class="blog-post-title">{{ $blogpost[0]->title }}</h2>
                    <p class="blog-post-meta">{{ $blogpost[0]->created_at }} by <a
                            href="{{ url('author/' . $blogpost[0]->author->id) }}">{{ $blogpost[0]->author->first_name . ' ' . $blogpost[0]->author->last_name }}</a>
                    </p>
                    <p><img src="{{ asset('storage/' . $blogpost[0]->image) }}" class="rounded"
                            alt="{{ $blogpost[0]->title }}">
                    </p>
                    <p>{{ $blogpost[0]->content }}</p>
                    <h3>Comments</h3>
                    @foreach ($commentsBlogpost as $commentBlogpost)
                        <p><strong>{{ $commentBlogpost->first_name . ' ' . $commentBlogpost->last_name }}</strong>
                            &bullet; <em>{{ $commentBlogpost->created_at }}</em>{{ $commentBlogpost->content }}</p>
                    @endforeach
                </article>
            </div>
            @include('sidebar')
        </div>
    </main>
@endsection
@section('footer')
