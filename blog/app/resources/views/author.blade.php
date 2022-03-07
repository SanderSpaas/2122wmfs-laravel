@extends('layout')
@section('title', 'Blogotopia | ' . $author[0]->first_name . ' ' . $author[0]->last_name)
@section('content')
    <main class="container">
        <div class="row g-5">
            <div class="col-md-8">
                <h3 class="pb-4 mb-4 fst-italic border-bottom">
                    Blogposts by {{ $author[0]->first_name . ' ' . $author[0]->last_name }}
                </h3>
                <div class="p-4 mb-3 bg-light rounded">
                    <h4 class="fst-italic">About {{ $author[0]->first_name . ' ' . $author[0]->last_name }}</h4>
                    <p class="mb-0">
                        {{ $author[0]->first_name . ' ' . $author[0]->last_name . ' lives at ' . $author[0]->location . '.' }}
                        You can find more information about {{ $author[0]->first_name }} on <a
                            href="{{ url($author[0]->website) }}">{{ $author[0]->website }}</a>.
                    </p>
                </div>
                @foreach ($blogposts as $Blogpost)
                    <article class="blog-post">
                        <h2 class="blog-post-title">{{ $Blogpost->title }}</h2>
                        <p class="blog-post-meta">{{ $Blogpost->created_at }} by <a
                                href="{{ url('author/' . $author[0]->id) }}">{{ $author[0]->first_name . ' ' . $author[0]->last_name }}</a>
                        </p>
                        <p><img src="{{ asset('storage/' . $Blogpost->image) }}" class="rounded"
                                alt="{{ $Blogpost->title }}">
                        </p>
                        <p>{{ $Blogpost->content }}</p>
                        <a href="{{ url('blogpost/' . $Blogpost->id) }}">Read comments &hellip;</a>
                    </article>
                @endforeach
            </div>
            @include('sidebar')
        </div>
    </main>
@endsection
