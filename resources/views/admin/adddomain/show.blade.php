@extends('layouts.app')

@section('content')
<div class="container">
@if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
        </div>
        @endif

        <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Number</th>
    </tr>
  </thead>
  <tbody>
  @foreach($domain as $key => $domains)
                 <tr>
                  <td>{{ $key + 1 }}</td>
                  <td>{{ $domains->name }}</td>
                  <td>{{ $domains->number  }}</td>
                </tr>
                @endforeach
  </tbody>
</table>
</div>
@endsection
