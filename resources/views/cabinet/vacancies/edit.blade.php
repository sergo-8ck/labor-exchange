@extends('layouts.app')

@section('content')

  @if (count($errors) > 0)
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('cabinet.vacancies.update', $vacancy) }}">
    @csrf
    @method('PUT')

    <div class="card mb-3">
      <div class="card-header">
        Edit
      </div>
      <div class="card-body pb-2">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="title" class="col-form-label">Title</label>
              <input id="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title"
                     value="{{ old('title', $vacancy->title) }}" required>
              @if ($errors->has('title'))
                <span class="invalid-feedback"><strong>{{ $errors->first('title') }}</strong></span>
              @endif
            </div>

            <div class="form-group">
              <label for="content" class="col-form-label">Content</label>
              <textarea id="content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}"
                        name="content"
                        rows="10" required>{{ old('content', $vacancy->content) }}</textarea>
              @if ($errors->has('content'))
                <span class="invalid-feedback"><strong>{{ $errors->first('content') }}</strong></span>
              @endif
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary">Save</button>
            </div>

          </div>
        </div>
      </div>
    </div>
  </form>

@endsection