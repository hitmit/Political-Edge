@extends('layouts.master')
@section('title')
    Clever App | Edit Category
@endsection
@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card add-row">
                    <div class="card-body">
                        <h6 class="card-title">Update Category</h6>
                        <form class="forms-sample" action="{{ route('category.update',$category->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="name">Category Name</label>

                                <input id="id" class="form-control @error('id') is-invalid @enderror"
                                    value="{{ $category->id }}" name="id" value="{{ old('id') }}" type="hidden">

                                <input id="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ $category->name }}" name="name" value="{{ old('name') }}" type="text">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>


        </div>


    </div>
@endsection
