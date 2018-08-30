@extends('layouts.app')

@section('content')
  @include('cabinet.vacancies._nav')
  @can ('manage-own-vacancy', $vacancy)
  <div class="d-flex flex-row mb-3">
    <a href="{{ route('cabinet.vacancies.edit', $vacancy->id) }}" class="btn btn-primary">Edit</a>&nbsp;
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
      <th>Title</th><td>{{ $vacancy->title }}</td>
    </tr>
    <tr>
      <th>Content</th><td>{{ $vacancy->content }}</td>
    </tr>
    <tr>
      <th>Email</th><td>{{ $vacancy->user->email }}</td>
    </tr>
    <tr>
      <th>Status</th><td>{{ $vacancy->status }}</td>
    </tr>
    </tbody>
  </table>
@endsection