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
							<h2>{{$concert->title}}</h2>
						</header>
						<div class="table-wrapper">
							<div class="box alt">

								<div class="row 50% uniform">
									<div class="12u$"><span class="image fit"><img src="/images/{{$concert->path}}" alt="" /></span></div>
								</div>
							</div>
							<p><a href="{{ url('/concerts/' . $concert->concert_id) }}">Terug naar concert</a></p>
						</div>
					</section>
			</div>
