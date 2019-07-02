@extends('layouts.base')

@section('title', $title)

@section('content')
    <ul>
        <li>
            Email of {{$users->name}}: {{$users->email}} and role {{$users->role_id}}
        </li>
    </ul>
@endsection