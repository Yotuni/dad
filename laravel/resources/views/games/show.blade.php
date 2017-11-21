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

    <div class="panel-heading">
        <h3 class="panel-title">
            Game id:  {{$game->id}}
        </h3>
    </div>
    <div>
        Created by: {{$game->user->nickname}}
    </div>
    <div>
        Type: {{$game->type}}
    </div>
    <div>
        Status: {{$game->status}}
    </div>
    <div>
        Players: 
            <table>
                @foreach($users as $user)
                <tr>
                    <td>
                        {{$user->nickname}}
                    </td>
                </tr>
                @endforeach
            </table>
    </div>

    

@endsection
@section('pagescript')
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
@endsection
