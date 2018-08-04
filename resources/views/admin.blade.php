@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">ADMIN Dashboard</div>

                <div class="panel-body">
               <a href="{{ route('adduser.create') }}" class="btn btn-default">Add user</a>
               <a href="{{ route('domain.create') }}" class="btn btn-default">Add domain</a>

               @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
        </div>
        @endif
      
                </div>
                
             
            </div>
              
        </div>
    </div>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">name</th>
      <th scope="col">email</th>
      <th scope="col">Created at</th>
      <th scope="col">Password</th>
    </tr>
  </thead>
  <tbody>
       @foreach($adduser as $key => $addusers)
                 <tr>
                  <td>{{ $key + 1 }}</td>
                  <td>{{ $addusers->name }}</td>
                  <td>{{ $addusers->email  }}</td>
                  <td>{{ $addusers->created_at  }}</td>
                  <td>{{ $addusers->password  }}</td>
                  <td><a href="{{ route('adduser.edit',$addusers->id) }}" class="btn btn-warning">adddomain</a></td>
                  <td>
                    <a class="btn btn-danger" href="#" onclick="
                    if(confirm('Are you sure, You Want to delete this?'))
                    {
                      event.preventDefault(); 
                      document.getElementById('delete-form-{{ $addusers->id }}').submit();
                    }else{
                      event.preventDefault();
                    }">
                    Delete
                  </a>
                      <form action="{{ route('adduser.destroy',$addusers->id) }}" method="POST" id="delete-form-{{ $addusers->id }}" style="display: none;">
                      {{ csrf_field() }}
                          {{ method_field('DELETE') }}
                       </form>
                  </td>
                </tr>
                @endforeach
  </tbody>
</table>
</div>
@endsection
