@extends('layouts.app')

@section('content')
<div class="container">
<form method="POST" action="{{ route('domain.store') }}">
{{ csrf_field() }}
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="name">
  </div>
  <div class="form-group">
    <label for="number">Number</label>
    <input type="text" class="form-control" id="number" name="number" placeholder="number">
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
</div>
@endsection
