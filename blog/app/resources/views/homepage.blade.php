@extends('layout')
@section('title', 'Blogotopia')
@section('content')
    <main class="container">
        @if($blogposts)
        <div class="p-4 p-md-5 mb-4 text-white rounded bg-dark banner"
            style="background-image: linear-gradient(180deg, rgba(255,255,255,0) 0, rgba(0,0,0,0.35) 0), url('{{ url('storage/' . $blogposts[0]->image) }}');">
            <div class="col-md-6 px-0">
                <h1 class="display-4 fst-italic">{{$blogposts[0]->title}}</h1>
                <p class="lead my-3">{{$blogposts[0]->content}}</p>
                <p class="lead mb-0"><a href="{{ url('blogpost/'.$blogposts[0]->id) }}" class="text-white fw-bold">Continue reading...</a></p>
            </div>
        </div>

        <div class="row mb-2">
            @for($i = 1; $i < count($blogposts); $i++)
                <div class="col-md-6">
                    <div
                        class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col p-4 d-flex flex-column position-static">
                            <strong class="d-inline-block mb-2 category-2">{{$blogposts[$i]->category->title}}</strong>
                            <h3 class="mb-0">{{ $blogposts[$i]->title }}</h3>
                            <div class="mb-1 text-muted">{{ $blogposts[$i]->created_at }}</div>
                            <p class="card-text mb-auto">{{ $blogposts[$i]->content }}</p>
                            <a href="{{ url('blogpost/'.$blogposts[$i]->id) }}" class="stretched-link">Continue reading</a>
                        </div>
                        <div class="col-auto d-none d-lg-block img-container">
                            <img src="{{ url('storage/' . $blogposts[$i]->image) }}" alt="{{$blogposts[$i]->title}}" />
                        </div>
                    </div>
                </div>
            @endfor
        </div>
        @else
        <p>no featured blogposts available</p>
        @endif
        <div class="d-flex justify-content-center">
            {!! $blogposts->links() !!}
        </div>
    </main>
@endsection
@section('footer')
