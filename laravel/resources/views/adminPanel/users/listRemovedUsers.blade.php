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
                    <form method="POST" action="{{route('recoverUser' ,$user->id)}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger btn-sm">Recover</button>
                        </div>
                    </form> 
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
