@extends('layout')
@section('title', 'Blogotopia | ' . $author->first_name . ' ' . $author->last_name)
@section('content')
    <main class="container">
        <div class="row g-5">
            <div class="col-md-8">
                <h3 class="pb-4 mb-4 fst-italic border-bottom">
                    Blogposts by {{ $author->first_name . ' ' . $author->last_name }}
                </h3>
                <div class="p-4 mb-3 bg-light rounded">
                    <h4 class="fst-italic">About {{ $author->first_name . ' ' . $author->last_name }}</h4>
                    <p class="mb-0">
                        {{ $author->first_name . ' ' . $author->last_name . ' lives at ' . $author->location . '.' }}
                        You can find more information about {{ $author->first_name }} on <a
                            href="{{ url($author->website) }}">{{ $author->website }}</a>.
                    </p>
                </div>
                @foreach ($blogposts as $Blogpost)
                    <article class="blog-post">
                        <h2 class="blog-post-title">{{ $Blogpost->title }}</h2>
                        <p class="blog-post-meta">{{ $Blogpost->created_at }} by <a
                                href="{{ url('author/' . $author->id) }}">{{ $author->first_name . ' ' . $author->last_name }}</a>
                        </p>
                        <p><img src="{{ asset('storage/' . $Blogpost->image) }}" class="rounded"
                                alt="{{ $Blogpost->title }}">
                        </p>
                        @foreach ($Blogpost->tags as $tag)
                            <span class="badge bg-success">{{ $tag->title }}</span>
                        @endforeach
                        @if ($blogposts[0]->author->id == Auth::id())
                        <form method="POST" action="{{ url('blogpost/' . $blogposts[0]->id . '/delete') }}">
                            @csrf
                            <button class="btn btn-danger">Verwijderen</button>
                        </form>
                    @endif
                        <p>{{ $Blogpost->content }}</p>
                        <a href="{{ url('blogpost/' . $Blogpost->id) }}">Read comments &hellip;</a>
                    </article>
                @endforeach
            </div>
            @include('sidebar')
        </div>
    </main>
@endsection
