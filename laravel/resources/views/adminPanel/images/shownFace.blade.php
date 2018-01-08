@extends('layouts.app')

@section('title', 'Shown Face')

@section('metatags')
<meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('content')

@if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
@endif

    <table class="table table-striped" style="width: 15%;" id="showImages">
        <thead>
            <tr>
                <th width="5%">Image</th>
                <th width="5%"></th>
                <th width="5%"></th>
            </tr>
        </thead>

        <tbody>
            @foreach($images as $image)
                <tr>
                    <td>
                        <img src="{{Storage::disk('public')->url('img/'.$image->path)}}" width="50px" height="50px">
                        </img>
                    </td>
                    
                    <td>
                        <td>
                            <form method="POST" action="{{route('activeShownFace' ,$image)}}">
                                {{csrf_field()}}
                                <div class="form-group" hidden>
                                    <select name="active" id="active" class="form-control">
                                        @if ($image->active == 1)
                                            <option value="0">{{0}}</option>
                                        @else
                                            <option value="1">{{1}}</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    @if ($image->active == 1)
                                        <button type="submit" class="btn btn-success btn-sm">Set Inactive</button>
                                    @else
                                        <button type="submit" class="btn btn-danger btn-sm">Set Active</button>
                                    @endif
                                </div>
                            </form> 
                        </td>
                        <td>
                            <button class="btn">Delete</button>    
                        </td>                
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    {{ Form::open(array('route' => array('createImage'), 'files'=>true)) }}
        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
            <label for="image" class="col-md-4 control-label">Update Image</label>
            <div class="col-md-6">
                {{ Form::file('image') }}
                <br>
            </div>
        </div>
        {{ Form::submit('Create', ['class' => 'btn btn-primary']) }}

    {{ Form::close() }}


@endsection
@section('pagescript')
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
@endsection
