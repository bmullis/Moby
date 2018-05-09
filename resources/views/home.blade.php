@extends('layouts.app')

@section('content')
    <div class="dashboard">
        <div class="container">
            <div class="row">
                <div class="col my-5">
                    <h3>Welcome back, {{ Auth::user()->name }}!</h3>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            You are logged in!
                        </div>
                    </div>
                    <div class="card">
                        <map-component></map-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
