@extends('layouts.app')

@section('content')
    @include('cabinet.profile._nav')
    <table class="table table-bordered">
        <tbody>
        <tr>
            <th>Name</th><td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>Email</th><td>{{ $user->email }}</td>
        </tr>
        </tbody>
    </table>
@endsection