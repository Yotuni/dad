@extends('layouts.app')

@section('title', 'List games')

@section('metatags')
<meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('content')

@if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
@endif

<div><a class="btn btn-primary" href="{{ route('games.create')}}">New Game</a></div>

    <table class="table table-striped" id="showGames">
    <thead>
        <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Status</th>
            <th>Number of Players</th>
            <th>Created By</th>
            <th>Winner</th>
            <th>Actions</th>
        </tr>
        
    </thead>
    <tbody>
        @foreach($games as $game)
            <tr>
                <td>{{$game->id}}</td>
                <td>{{$game->type}}</td>
                <td>{{$game->status}}</td>
                <td>{{$game->total_players}}</td>
                <td>{{$game->user->nickname}}</td>
                <td>{{$game->winner}}</td>
                <td>
                    <button class="btn">Edit</button>
                    <button class="btn">Delete</button>                    
                </td>
            </tr>
        @endforeach
    </tbody>
    </table>


@endsection
@section('pagescript')
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="/js/games.js"></script>
@endsection
