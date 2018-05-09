@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <img src="/images/logo.png" alt="Logo for moby.">
                </div>
                <div class="col-5">
                    <h1 class="display-1">Moby</h1>
                    <h2>Crowd-Sourced Whale Spotting</h2>
                    <p>Use MOBY to track whale sightings, and contribute your own sightings to the whale watching community.</p>
                    <a class="btn btn-md btn-primary" href="{{ route('login') }}">Learn More</a>
                    <a class="btn btn-md btn-info" href="{{ route('register') }}">Register</a>
                </div>
            </div>
        </div>
    </div>
@endsection
