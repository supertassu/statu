@extends('layouts.app')

@section('title', 'Current Status')

@section('content')

    <p class="subtitle">
        {!! config('statu.title') !!}
    </p>

    <div id="whoopsie">
        <div class="notification is-danger">
            Looks like something went wrong. Please try again.
        </div>
    </div>

    <system-status></system-status>
@endsection
