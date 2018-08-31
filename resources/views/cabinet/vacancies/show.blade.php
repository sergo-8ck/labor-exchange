@extends('layouts.app')

@section('content')
  @can ('manage-vacancies')
    @include('admin.vacancies._nav')
  @else
    @include('cabinet.vacancies._nav')
  @endcan



  @can ('manage-vacancies')
    <div class="d-flex flex-row mb-3">
      @can('manage-vacancies')
        <a href="{{ route('admin.vacancies.edit', $vacancy->id) }}" class="btn btn-primary">Edit</a>
        <form method="POST" action="{{ route('admin.vacancies.destroy', $vacancy) }}" class="mr-1">
          @csrf
          @method('DELETE')
          <button class="btn btn-danger">Delete</button>
        </form>
      @else
        <a href="{{ route('cabinet.vacancies.edit', $vacancy->id) }}" class="btn btn-primary">Edit</a>&nbsp;
        <form method="POST" action="{{ route('cabinet.vacancies.destroy', $vacancy) }}" class="mr-1">
          @csrf
          @method('DELETE')
          <button class="btn btn-danger">Delete</button>
        </form>
      @endcan
      @if ($vacancy->isOnModeration())
        <form method="POST" action="{{ route('admin.vacancies.moderate', $vacancy) }}" class="mr-1">
          @csrf
          <button class="btn btn-success">Moderate</button>
        </form>
      @endif
    </div>
  @endcan


  @can ('manage-own-vacancy', $vacancy)
    <div class="d-flex flex-row mb-3">
      @can('manage-vacancies')
        <a href="{{ route('admin.vacancies.edit', $vacancy->id) }}" class="btn btn-primary">Edit</a>
      @else
        <a href="{{ route('cabinet.vacancies.edit', $vacancy->id) }}" class="btn btn-primary">Edit</a>&nbsp;
      @endcan

      <form method="POST" action="{{ route('cabinet.vacancies.destroy', $vacancy) }}" class="mr-1">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger">Delete</button>
      </form>
    </div>
  @endcan
  <table class="table table-bordered">
    <tbody>
    <tr>
      <th>Title</th>
      <td>{{ $vacancy->title }}</td>
    </tr>
    <tr>
      <th>Content</th>
      <td>{{ $vacancy->content }}</td>
    </tr>
    <tr>
      <th>Email</th>
      <td>{{ $vacancy->user->email }}</td>
    </tr>
    <tr>
      <th>Status</th>
      <td>{{ $vacancy->status }}</td>
    </tr>
    </tbody>
  </table>
@endsection