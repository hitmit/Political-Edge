@extends('layouts.master')
@section('title')
    Clever App | Manage Expenses
@endsection
@section('content')
    <div class="page-content">
        @include('include/error')
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card add-row">
                    <div class="card-body">
                        <h6 class="card-title">Manage Expenses <a href="{{ route('expenses.create') }}"
                                class="add-element btn btn-primary">Add Expenses</a> </h6>
                        {{-- <a style="margin-right: 10px" href="{{ route('expenses.download.excel') }}"
                                class="add-element btn btn-primary">Download Expenses</a> --}}
                        <form action="{{ route('expenses.index') }}" method="GET">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h6>
                                        <select name="category" id="category" class="form-control ">
                                            <option value="">--Select category--</option>
                                            @foreach ($categorys as $category)
                                                @if (request()->has('category') && request('category') == $category->id)
                                                    <option selected value="{{ $category->id }}">
                                                @else
                                                    <option value="{{ $category->id }}">
                                                @endif
                                                {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </h6>
                                </div>
                                <div class="col-sm-2">
                                    <h6><input type="date" value="{{request('start_date') ? request('start_date') : ''}}" name="start_date" class="form-control "></h6>
                                </div>
                                <div class="col-sm-2">
                                    <h6><input type="date" value="{{request('start_date') ? request('start_date') : ''}}" name="end_date" class="form-control "></h6>
                                </div>

                                <div class="col-sm-4">
                                    <button class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive my-2">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        {{-- <th>Sr.no</th> --}}
                                        <th>Username</th>
                                        <th>Category Name</th>
                                        <th>Expenses</th>
                                        <th>Remark</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expenses as $expense)
                                        <tr>
                                            <td>{{ $expense->user()->first()->name }}</td>
                                            <td>{{ $expense->category()->first()->name }}</td>
                                            <td>{{ str_replace(["INR", ".00"], "", money_format("%i", $expense->amount)) }}</td>
                                            <th>{{ $expense->remark }}</th>
                                            <td>{{ $expense->date }}</td>
                                            <td>
                                                <a href="{{ route('expenses.edit', $expense->id) }}"
                                                    class="edit btn btn-primary"><i class="fa fa-pencil"
                                                        aria-hidden="true"></i></a>

                                                <form class="my-2"
                                                    action="{{ route('expenses.destroy', $expense->id) }}" method="POST">
                                                    @csrf
                                                    @method("DELETE")
                                                    <button type="submit"
                                                        onclick="return confirm('Are you sure want to delete')"
                                                        class="delete btn btn-danger"><i class="fa fa-trash"
                                                            aria-hidden="true"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        {{ $expenses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
