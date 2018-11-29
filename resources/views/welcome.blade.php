@extends('layouts.welcome')

@section('content')
    <div class="title m-b-md">
        {{ config('app.name') }}
    </div>

    <a href="{{ route('admin.dashboard') }}">
        <i class="fa fa-home" aria-hidden="true"></i>
        {{ __('views.backend.section.navigation.menu_0_1') }}
    </a>
@endsection