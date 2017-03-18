@extends('layouts.app')

@section('content')

    <section class="content">
        <section class="columns">
            <article class="col col2">
                <div class="center">
                    <h2><a href="{{ url('/client/register') }}">Client register</a></h2>
                </div>
            </article>
            <article class="col col2">
                <div class="center">
                    <h2><a href="{{ url('/mover/register') }}">Mover register</a></h2>
                </div>
            </article>
        </section>
    </section>

@endsection