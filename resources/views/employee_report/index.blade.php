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
                        <h6 class="card-title">Reports</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sr.no</th>
                                        <th>Name</th>
                                        <th>Unit Completed</th>
                                        <th>Projects</th>
                                        <th>Advance</th>
                                        <th>Expenses</th>
                                        <th>Balance</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($projects as $user_id => $user_projects)
                                        @foreach ($user_projects as $project)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $project->getUser($user_id) }}</td>
                                                <td>{{ $project->employee_transactions($user_id) }} /
                                                    {{ $project->units }}</td>
                                                <td>{{ $project->name }}</td>
                                                <td>{{ $project->advance_total($user_id) }}</td>
                                                <td>{{ $project->expense_total($user_id) }}</td>
                                                <td>{{ $project->expense_total($user_id) - $project->advance_total($user_id) }}
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                    <a href="{{ route('employee.report.show', [$user_id, $project->id]) }}"
                                                                class="delete m-2 btn btn-primary"><i
                                                                    class="fa fa-eye"></i></a>
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
                                                    </div>
                                                </td>
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
