@extends('layouts.base')

@section('title', $title)

@section('content')
    @users([
    'users' => $users,
{{--    'editable' => $editable--}}
    ])
    @endusers
@endsection