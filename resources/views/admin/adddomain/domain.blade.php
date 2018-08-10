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
    <label for="key_id">Key id</label>
    <input type="text" class="form-control" id="key_id" name="key_id" placeholder="key_id">
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
</div>
@endsection
