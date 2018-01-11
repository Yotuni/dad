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


@if (Session::has('message'))
        <div class="alert alert-success">
            {!!Session::get('message')!!}
        </div>
@endif

<!-- <div><a class="btn btn-primary" href="{{ route('users.create')}}">New User</a></div> -->

    <table class="table table-striped" id="showUsers">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Nickname</th>
            <th></th>
            <th></th>
        </tr>
        
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->nickname}}</td>
                <td>
                <div class="form-group">
                    @if ($user->blocked == 1)
                        <form method="POST" action="{{route('blockUser' ,$user)}}">
                        {{csrf_field()}}
                        <div class="form-group" hidden>
                            <input name="block" id="block" class="form-control" value="0" />
                        </div>
                        <button type="submit" class="btn btn-success btn-sm">UnBlock</button>
                        </form> 
                    @else
                    <a class="btn btn-danger btn-sm" href="{{route('blockUser' ,$user)}}">Block</a>
                    @endif
                </div>
                   
                </td>
                <td>
                    {{ Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id]]) }}
                        {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                    {{ Form::close() }}
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
    <script src="/js/users.js"></script>
@endsection
