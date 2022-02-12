@extends('main')

@section('title', 'Overzicht')

@section('content')
    <!-- Header -->
    <header id="header">
        <h1><a href="{{ url('/') }}"><strong>Take me to safety</strong></a></h1>
    </header>

    <!-- Main -->
    <div id="main">
        <!-- Event table -->
        <section id="event_table">
            <header class="major">
                <h2>404</h2>
            </header>
            <div class="container mt-5 pt-5">
                <div class="alert alert-danger text-center">
                    <p class="display-5">Oops! Something is wrong.</p>
                </div>
            </div>
        </section>
    </div>
