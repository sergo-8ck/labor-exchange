@extends('layouts.app')

@section('content')
    @include('admin.vacancies._nav')


    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>User</th>
            <th>Status</th>
            <th>Updated</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($vacancies as $vacancy)
            <tr>
                <td>{{ $vacancy->id }}</td>
                <td><a href="{{route('admin.vacancies.show', $vacancy->id)}}">{{ $vacancy->title }}</a></td>
                <td>{{ $vacancy->user->id }} - {{ $vacancy->user->name }}</td>



                <td>
                    @if ($vacancy->isOnModeration())
                        <span class="badge badge-primary">Moderation</span>
                    @elseif ($vacancy->isActive())
                        <span class="badge badge-primary">Active</span>

                    @endif
                </td>
                <td>{{ $vacancy->updated_at }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>

    {{ $vacancies->links() }}
@endsection