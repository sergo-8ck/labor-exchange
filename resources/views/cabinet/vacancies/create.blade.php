@extends('layouts.app')

@section('content')
    @include('cabinet.vacancies._nav')

    <form method="POST" action="{{ route('cabinet.vacancies.store') }}">
        @csrf

        <div class="card mb-3">
            <div class="card-header">
                Creating vacancy
            </div>
            <div class="card-body pb-2">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title" class="col-form-label">Title</label>
                            <input id="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" required>
                            @if ($errors->has('title'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('title') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email: {{auth()->user()->email}}</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="content" class="col-form-label">Content</label>
                    <textarea id="content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" name="content" rows="5" required>{{ old('content') }}</textarea>
                    @if ($errors->has('content'))
                        <span class="invalid-feedback"><strong>{{ $errors->first('content') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>

@endsection