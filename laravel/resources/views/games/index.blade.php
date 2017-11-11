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
        </tr>
    </thead>
    <tbody>
    
    </tbody>
    </table>

    <nav aria-label="Page navigation example">
        <ul class="pagination">

        </ul>
    </nav>

@endsection
@section('pagescript')
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="/js/games.js"></script>
@endsection
