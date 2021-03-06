@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <a class="btn btn-default navbar-btn" href="{{ route('games.create')}}">Create a new Game</a>
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
