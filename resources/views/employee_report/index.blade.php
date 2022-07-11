@extends('layouts.master')
@section('title')
    Clever App | Manage Employee
@endsection
@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card add-row">
                    <div class="card-body">
                        <h6 class="card-title">Employees Reports</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sr.no</th>
                                        <!-- <th>Name</th> -->
                                        <th>Projects</th>
                                        <th>Advance</th>
                                        <th>Expenses</th>
                                        <th>Unit Completed</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($projects as $project)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <!-- <td>{{ $project->getusername() }}</td> -->
                                            <td>{{ $project->project()->first()->name }}</td>
                                            <td>{{ $project->advance_total() }}</td>
                                            <td>{{ $project->expense_total() }}</td>
                                            <td>{{ $project->employee_transactions()->sum('units') }} /
                                                {{ $project->units }}</td>
                                            <td>
                                                <form class="my-2"
                                                    action="{{ route('employee-report.destroy', $project->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Are you sure want to delete')"
                                                        class="delete btn btn-danger"><i class="fa fa-trash"
                                                            aria-hidden="true"></i></button>
                                                </form>
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
                    </div>
                    <div class="card-footer">
                        {{ $projects->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
