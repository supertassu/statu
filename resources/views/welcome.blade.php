@extends('layouts.app')

@section('title', 'Current Status')

@section('content')

    <p class="subtitle">
        {!! config('statu.title') !!}
    </p>

    <system-status></system-status>

@endsection
