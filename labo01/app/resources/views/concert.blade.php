@extends('main')

@section('title', 'Overzicht')

@section('content')

    <!-- Header -->
    <header id="header">
        <h1><a href="{{ url('/') }}"><strong>Concertagenda</strong></a></h1>
    </header>

    <!-- Main -->
    <div id="main">
        <!-- Event table -->
        <section id="concert">
            <header class="major">
                <h2>{{ $concert[0]->title }}</h2>
            </header>
            <div class="table-wrapper">
                <table>
                    <tbody>
                        <tr>
                            <th>Datum</th>
                            <td>{{ $concert[0]->start_date }}</td>
                        </tr>
                        <tr>
                            <th>Locatie</th>
                            <td>{{ $concert[0]->location }}</td>
                        </tr>
                        <tr>
                            <th>Prijs</th>
                            <td>
                                {{ $concert[0]->price }} &euro;
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="box alt">
                    <div class="row 50% uniform">
                        @foreach ($concert as $consertImg)
                            <div class="4u"><a
                                    href={{ url('/concerts/' . $consertImg->concert_id . '/' . $consertImg->id) }}
                                    class="image fit thumb"><img src="../images/{{ $consertImg->path }}" alt="" /></a></div>
                        @endforeach
                    </div>
                </div>
                <p><a href="{{ url('/') }}">Terug naar overzicht</a></p>
            </div>
        </section>
    </div>
