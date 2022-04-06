@extends('layouts.master')
@section('title')
    Clever App | Manage User
@endsection
@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card add-row">
                    <div class="card-body">
                        <h6 class="card-title">Manage Users <a href="{{ route('users.create') }}"
                                class="add-element add-element btn btn-primary">Add User</a></h6>


                    
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Sr.no</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Mobile</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>
                                            <a href="{{ route('users.edit', $user->id) }}" class="edit btn btn-primary"><i
                                                    class="fa fa-pencil" aria-hidden="true"></i></a>
                                            <!--<form class="my-2"
                                                action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure want to delete')"
                                                    class="delete btn btn-danger"><i class="fa fa-trash"
                                                        aria-hidden="true"></i></button>
                                            </form>-->
                                        </td>
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{ $users->links() }}
                    </div>
</div>
                </div>
            </div>
        </div>
    </div>
@endsection
