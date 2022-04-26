@extends('layout')

@section('title', 'Blogotopia | Sign up' )


@section('content')
    <div class="p-4 mb-3 bg-light rounded">
            <h4 class="mb-3">Sign up</h4>
            <form class="needs-validation" novalidate="" method="post" action="{{ url('register') }}">
                @csrf
                <div class="row g-3">

                    <div class="col-6">
                        <label for="first_name" class="form-label">First name</label>
                        <input type="text" class="form-control @error('first_name') is-invalid @elseif(old() !== []) is-valid @enderror" id="first_name" placeholder="" name="first_name" value="{{ old('first_name', '') }}">
                        @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @elseif(old() !== [])
                            <div class="valid-feedback">Looks good!</div>
                            @enderror
                    </div>

                    <div class="col-6">
                        <label for="last_name" class="form-label">Last name</label>
                        <input type="text" class="form-control @error('last_name') is-invalid @elseif(old() !== []) is-valid @enderror" id="last_name" placeholder="" name="last_name" value="{{ old('last_name', '') }}">
                        @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @elseif(old() !== [])
                            <div class="valid-feedback">Looks good!</div>
                            @enderror
                    </div>

                    <div class="col-12">
                        <label for="website" class="form-label">Website</label>
                        <input type="text" class="form-control @error('website') is-invalid @elseif(old() !== []) is-valid @enderror" id="website" placeholder="" name="website" value="{{ old('website', '') }}">
                        @error('website')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @elseif(old() !== [])
                            <div class="valid-feedback">Looks good!</div>
                            @enderror
                    </div>

                    <div class="col-12">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control @error('location') is-invalid @elseif(old() !== []) is-valid @enderror" id="location" placeholder="" name="location" value="{{ old('location', '') }}">
                        @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @elseif(old() !== [])
                            <div class="valid-feedback">Looks good!</div>
                            @enderror
                    </div>


                </div>

                <hr class="my-4">

                <div class="row g-3">

                    <div class="col-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @elseif(old() !== []) is-valid @enderror" id="email" placeholder="" name="email" value="{{ old('email', '') }}">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @elseif(old() !== [])
                            <div class="valid-feedback">Looks good!</div>
                        @enderror
                    </div>


                    <div class="col-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="" name="password" value="">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="password_confirmation" class="form-label">Password confirmation</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="" name="password_confirmation" value="">
                        @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                </div>

                <hr class="my-4">


                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember"@if(old('remember')) checked="checked" @endif>
                    <label class="form-check-label" for="featured">Remember me</label>
                </div>


                <hr class="my-4">

                <button class="btn btn-primary btn-lg" type="submit">Sign up</button>
            </form>

    </div>

@endsection
