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
                        <h6 class="card-title">Manage Income <a href="{{ route('income.create') }}"
                                class="add-element btn btn-primary">Add Income</a></h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Income</th>
                                        <th>Remark</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($incomes as $income)
                                        <tr>
                                            <td>{{ $income->project_id }}</td>
                                            <td>&#x20B9;{{ $income->amount }}</td>
                                            <th>{{ $income->remark }}</th>
                                            <td>{{ $income->date }}</td>
                                            <td>{{ $income->time }}</td>
                                            <td>
                                                <a href="{{ route('income.edit', $income->id) }}"
                                                    class="edit btn btn-primary"><i class="fa fa-pencil"
                                                        aria-hidden="true"></i></a>

                                                <form class="my-2"
                                                    action="{{ route('income.destroy', $income->id) }}" method="POST">
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
                        {{ $incomes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
