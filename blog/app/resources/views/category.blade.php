@extends('layout')
@section('title', 'Blogotopia | ' . $blogposts[0]->category->title)
@section('content')
    <main class="container">
        <div class="row g-5">
            <div class="col-md-8">
                <h3 class="pb-4 mb-4 fst-italic border-bottom">
                    {{ ucfirst($blogposts[0]->category->title) }}
                </h3>
                @foreach ($blogposts as $blogpost)
                    <article class="blog-post">
                        <h2 class="blog-post-title">{{ $blogpost->title }}</h2>
                        <p class="blog-post-meta">{{ $blogpost->created_at }} by <a
                                href="{{ url('author/' . $blogpost->author->id) }}">{{ $blogpost->author->first_name . ' ' . $blogpost->author->last_name }}</a>
                        </p>
                        <p><img src="{{ asset('storage/' . $blogpost->image) }}" class="rounded"
                                alt="{{ $blogpost->title }}">
                        </p>@foreach ($blogpost->tags as $tag)
                                <span class="badge bg-success">{{ $tag->title }}</span>
                            @endforeach
                        <p>{{ $blogpost->content }}</p>
                        <a href="{{ url('blogpost/' . $blogpost->id) }}">Read comments &hellip;</a>
                    </article>
                @endforeach
            </div>
            @include('sidebar')
        </div>
        <div class="d-flex justify-content-center">
            {!! $blogposts->links() !!}
        </div>
    </main>
@endsection
