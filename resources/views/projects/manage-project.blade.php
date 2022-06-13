@extends('layouts.master')
@section('title')
     Clever App | Manage Project
@endsection
@section('content')
    <div class="page-content">
        @include('include/error')
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card add-row">
                    <div class="card-body">
                        <h6 class="card-title">Manage Project <a href="{{ route('project.create') }}"
                                class="add-element add-element btn btn-primary">Add Project</a></h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sr.no</th>
                                        <th>Project Name</th>
                                        <th>Expected Revenue</th>
                                        <th>Date & Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($projects as $project)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $project->name }}</td>
                                            <td>@money($project->expected_revenue, "INR")</td>
                                          
                                            <td>{{ date("Y-m-d", strtotime($project->created_at)) }}</td>
                                            <td>
                                                <a href="{{ route('project.edit', $project->id) }}"
                                                    class="edit btn btn-primary"><i class="fa fa-pencil"
                                                        aria-hidden="true"></i></a>
                                                {{-- <a href="{{ route('project.destroy', $project->id) }}"
                                                    onclick="return confirm('Are your sure to delete')"
                                                    class="delete btn btn-danger"><i class="fa fa-trash"
                                                        aria-hidden="true"></i></a> --}}

                                                        <form class="my-2" action="{{ route('project.destroy', $project->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method("DELETE")
                                                            <button type="submit" onclick="return confirm('Are you sure want to delete')" class="delete btn btn-danger"><i class="fa fa-trash"
                                                                    aria-hidden="true"></i></button>
                                                        </form>


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
