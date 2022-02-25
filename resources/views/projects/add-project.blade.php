@extends('layouts.master')
@section('title')
    Political edge | Add Income
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
                                <label for="name">Add Project Name</label>
                                <input id="name" class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" type="text">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Status</label>
                                <select class="form-control" name="status">
                                    <option>--Select Status--</option>
                                    <option value="1">Acive</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>


        </div>


    </div>
@endsection
