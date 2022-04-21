@extends('layouts.master')
@section('title')
    Clever App | Add Project
@endsection
@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card add-row">
                    <div class="card-body">
                        <h6 class="card-title">Add Project</h6>
                        <form class="forms-sample" action="{{ route('project.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Project Name</label>
                                <input id="name" class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" type="text">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Expected Revenue</label>
                                <input id="exp-rev" class="form-control @error('expected_revenue') is-invalid @enderror" value="{{ old('expected_revenue') }}" name="expected_revenue" type="text">
                                @error('expected_revenue')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="users">Users</label><br>
                                <table >
                                    @foreach ($users as $user)
                                        <tr>
                                            <td style="width: 32%;  padding-bottom: 5px;">
                                                <input type="checkbox" name="users[]" class="form-check"
                                                    value="{{ $user->id }}">
                                            </td>
                                            <td>{{ $user->name }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            

                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>


        </div>


    </div>
@endsection
