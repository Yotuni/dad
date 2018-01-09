@extends('layouts.app')

@section('title', 'Add user')

@section('metatags')
<meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('content')

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<form method="POST" action="{{route('block' ,$user)}}">
    {{csrf_field()}}
    <div class="form-group" hidden>
        <input name="block" id="block" class="form-control" value="1" />
    </div>
    <div class="form-group">
    <label for="inputReasonBlocked">Motivo do bloqueio</label>
    <input
        type="text" class="form-control"
        name="reasonBlocked" id="inputReasonBlocked"
        placeholder="Reason to block" value="" />
    </div>
    <button type="submit" class="btn btn-sm btn-success">Save</button>
</form> 
@endsection
@section('pagescript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="/js/users_create.js"></script>    
@endsection