@extends('layout')
@section('title', 'Blogotopia | Add a blogpost')
@section('main')
    <main class="container">
        <div class="row g-5">
            <div class="col-md-8">
                <div class="p-4 mb-3 bg-light rounded">
                    <h4 class="mb-3">Add a blogpost</h4>
                    @include('common.errors')
                    @foreach ($errors->getMessages() as $key => $message)
                        {{ $errorArray[] = $key }}
                    @endforeach

                    {{-- @if ($errors->any())
                        {{ dump($errors->default) }}
                        @foreach ($errors->getMessages() as $key => $message)
                            {{$errorArray[] = $key}}
                        @endforeach
                        {{ dump(in_array('title', $errorArray)) }}
                        {{ dump(session()->get('_old_input.title')) }}
                        {{ dd(session() -> all()) }}
                    @endif --}}
                    <form class="needs-validation" novalidate="" method="post" action="{{ url('add') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <!--<input type="hidden" name="_token" value="xbleOu1XHjw4MyI2FeAg5VzncRFBmSWuSE9dJk9D">-->
                        <div class="row g-3">
                            <!--div class="col-sm-6">
                                    <label for="firstName" class="form-label">First name</label>
                                    <input type="text" class="form-control is-invalid" id="firstName" placeholder="" value="" required="">
                                    <div class="invalid-feedback">
                                        Valid first name is required.
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="lastName" class="form-label">Last name</label>
                                    <input type="text" class="form-control is-valid" id="lastName" placeholder="" value="" required="">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div-->

                            <div class="col-12">
                                <label for="title" class="form-label">Title</label>
                                <input type="text"
                                    class="form-control {{ session()->exists('_old_input.title') ? (in_array('title', $errorArray) ? 'is-invalid' : 'is-valid') : '' }}"
                                    id="title" placeholder="" name="title" value="{{ old('title', '') }}">

                            </div>

                            <div class="col-12">
                                <label for="content" class="form-label">Content</label>
                                <textarea
                                    class="form-control {{ session()->exists('_old_input.content')? (in_array('content', $errorArray)? 'is-invalid': 'is-valid'): '' }}"
                                    id="content" rows="4" name="content">{{ old('content', '') }}</textarea>
                            </div>

                            <div class="col-12">
                                <label for="image" class="form-label">Image</label>
                                <input
                                    class="form-control {{ isset($errorArray) ? (in_array('image', $errorArray) ? 'is-invalid' : '') : '' }}"
                                    type="file" id="image" name="image">
                            </div>
                        </div>

                        <hr class="my-4">


                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="featured" name="featured"
                                @if (old('featured')) checked @endif>
                            <label class="form-check-label" for="featured">Include this blogpost on the home
                                page</label>
                        </div>

                        <hr class="my-4">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="category" class="form-label">Category</label>
                                <select
                                    class="form-select {{ session()->exists('_old_input.category_id')? (in_array('category_id', $errorArray)? 'is-invalid': 'is-valid'): '' }}"
                                    id="category" required="" name="category_id">
                                    <option value="">Choose...</option>
                                    @foreach ($categories as $choseCategory)
                                        @if (old('category_id') == $choseCategory->id)
                                            <option value="{{ $choseCategory->id }}" selected>
                                                {{ $choseCategory->title }}</option>
                                        @else
                                            <option value="{{ $choseCategory->id }}">{{ $choseCategory->title }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="author" class="form-label">Author</label>
                                <select
                                    class="form-select {{ session()->exists('_old_input.author_id')? (in_array('author_id', $errorArray)? 'is-invalid': 'is-valid'): '' }}"
                                    id="author" required="" name="author_id">
                                    <option value="">Choose...</option>
                                    @foreach ($authors as $choseAuthor)
                                        @if (old('author_id') == $choseAuthor->id)
                                            <option value="{{ $choseAuthor->id }}" selected>
                                                {{ $choseAuthor->first_name . ' ' . $choseAuthor->last_name }}</option>
                                        @else
                                            <option value="{{ $choseAuthor->id }}">
                                                {{ $choseAuthor->first_name . ' ' . $choseAuthor->last_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <hr class="my-4">

                        <button class="btn btn-primary btn-lg" type="submit">Add blogpost</button>
                    </form>

                </div>

            </div>
            @include('sidebar')
        </div>
    </main>
@endsection
