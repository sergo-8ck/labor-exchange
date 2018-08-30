@extends('layouts.app')

@section('content')
  @include('cabinet.vacancies._nav')

  <div class="mb-3">
    <a href="" class="btn btn-primary">Edit</a>
  </div>

  <table class="table table-bordered">
    <tbody>
    <tr>
      <th>Title</th><td>{{ $vacancy->title }}</td>
    </tr>
    <tr>
      <th>Content</th><td>{{ $vacancy->content }}</td>
    </tr>
    <tr>
      <th>Status</th><td>{{ $vacancy->status }}</td>
    </tr>
    </tbody>
  </table>
@endsection