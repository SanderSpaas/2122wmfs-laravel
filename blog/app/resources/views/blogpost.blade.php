@extends('layout')
@section('title', 'Blogotopia | ' . $blogpost->title)
@section('content')
    <main class="container">
        <div class="row g-5">
            <div class="col-md-8">
                <article class="blog-post">
                    <h2 class="blog-post-title">{{ $blogpost->title }}</h2>
                    <p class="blog-post-meta">{{ $blogpost->created_at }} by <a
                            href="{{ url('author/' . $blogpost->author->id) }}">{{ $blogpost->author->first_name . ' ' . $blogpost->author->last_name }}</a>
                    </p>
                    <p><img src="{{ asset('storage/' . $blogpost->image) }}" class="rounded"
                            alt="{{ $blogpost->title }}">
                    </p>
                    @foreach ($blogpost->tags as $tag)
                        <span class="badge bg-success">{{ $tag->title }}</span>
                    @endforeach

                    @if ($blogpost->author->id == Auth::id())
                        <form method="POST" action="{{ url('blogpost/' . $blogpost->id . '/delete') }}">
                            @csrf
                            <button class="btn btn-danger">Verwijderen</button>
                        </form>
                    @endif
                    <p>{{ $blogpost->content }}</p>

                    <h3>Comments</h3>
                    @foreach ($commentsBlogpost as $commentBlogpost)
                        <p><strong>{{ $commentBlogpost->author->first_name . ' ' . $commentBlogpost->author->last_name }}</strong>
                            &bullet; <em>{{ $commentBlogpost->created_at }}</em>{{ $commentBlogpost->content }}</p>
                    @endforeach
                </article>
            </div>
            @include('sidebar')
        </div>
    </main>
@endsection
@section('footer')
