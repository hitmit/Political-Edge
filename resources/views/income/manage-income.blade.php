@extends('layouts.master')
@section('title')
    Clever App | Add Receivables
@endsection
@section('content')
    <div class="page-content">
        @include('include/error')
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card add-row">
                    <div class="card-body">
                        <h6 class="card-title">Manage Receivables <a href="{{ route('income.create') }}"
                                class="add-element btn btn-primary">Add Receivables</a></h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Receivables</th>
                                        @if (auth()->getUser()->role == 'admin')
                                            <th>User</th>
                                        @endif
                                        <th>Remark</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($incomes as $income)
                                        <tr>
                                            <td>{{ $income->project()->first()->name }}</td>
                                            <td>@money($income->amount, 'INR')</td>
                                            @if (auth()->getUser()->role == 'admin')
                                                <td>{{ $income->user()->first()->name }}</td>
                                            @endif
                                            <td>{{ substr($income->remark, 0, 40) }}</td>
                                            <td>{{ $income->date }}</td>
                                            <td>
                                                <a href="{{ route('income.edit', $income->id) }}"
                                                    class="edit btn btn-primary"><i class="fa fa-pencil"
                                                        aria-hidden="true"></i></a>

                                                <form class="my-2" action="{{ route('income.destroy', $income->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
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
