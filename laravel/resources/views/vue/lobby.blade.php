@extends('master')

@section('title', 'Lobby')

@section('content')
    <router-link to="/lobby">Lobby Memory Game</router-link> -
    <router-link to="/single">SinglePlayer Memory Game</router-link> -
    <router-link to="/multi">Multiplayer Memory Game</router-link>

    <router-view></router-view>
@endsection

@section('pagescript')
<script src="js/app.js"></script>

<!-- <script src="/js/manifest.js"></script>
<script src="/js/vendor.js"></script>
<script src="/js/vueapp.js"></script>
 -->
 @stop
