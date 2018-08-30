@extends('layouts.app')

@section('content')
  @include('cabinet.vacancies._nav')
  <div class="mb-3">
    <a href="{{ route('cabinet.vacancies.create') }}" class="btn btn-primary">Create</a>
  </div>

  <table class="table table-striped">
    <thead>
    <tr>
      <th>ID</th>
      <th>Updated</th>
      <th>Title</th>
      <th>Status</th>
    </tr>
    </thead>
    <tbody>

    @foreach ($vacancies as $vacancy)
      <tr>
        <td>{{ $vacancy->id }}</td>
        <td><a href="{{route('cabinet.vacancies.show', $vacancy->id)}}">{{ $vacancy->title }}</a></td>
        <td>{{ $vacancy->updated_at }}</td>
        <td>
          @if ($vacancy->isOnModeration())
            <span class="badge badge-primary">Moderation</span>
          @elseif ($vacancy->isActive())
            <span class="badge badge-primary">Active</span>
          @endif
        </td>
      </tr>
    @endforeach

    </tbody>
  </table>

  {{ $vacancies->links() }}
@endsection