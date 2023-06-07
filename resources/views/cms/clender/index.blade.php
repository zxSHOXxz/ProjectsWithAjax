@extends('cms.master')

@section('styles')
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 25px 8px;
            text-align: center;
        }

        thead {
            background-color: #f2f2f2;
        }

        .sidebar {
            display: none !important
        }
    </style>
@endsection


@php
    $project = $projects->where('id', 10)->first();
    $activitiesT = App\Models\Activity::where('project_id', $project->id)->get();
@endphp

@section('content')
    <div class="row">
        <form>
            <div class="col">
                <div class="mb-3">
                    <div class="container">
                        <select class="form-select" name="project_id" id="project_id">
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <div class="container">
                        <input class="form-control" type="date" name="start_date" id="start_date">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <div class="container">
                        <input class="form-control" type="date" name="end_date" id="end_date">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <div class="container">
                        <button type="button" class="btn btn-dark" onclick="filter()"> بحث </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div id="table-container">
        <table id="table">
            <thead id="tableThead">
                <tr id="monthsTr">
                    <th colspan="15"> </th>
                </tr>
                <tr id="weeksTr">
                    <th colspan="15"> weeks </th>
                </tr>
            </thead>
            <tbody id="tableTbody">
                @foreach ($activitiesT as $activity)
                    @php
                        $sub_activity_new = App\Models\SubActivity::where('activity_id', $activity->id)->get();
                    @endphp
                    @foreach ($sub_activity_new as $sub_activity)
                        <tr>
                            <td colspan="5" rowspan="2" class="tdActivity">{{ $activity->title }}</td>
                            <td colspan="5" rowspan="2">{{ $sub_activity->title }}</td>
                            <td colspan="5" class="planned"> planned </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="planned"> actual </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
@endsection


{{-- @php

@endphp --}}
{{-- @foreach ($activities as $activity) --}}


{{-- @endforeach --}}





@section('scripts')
    <script src="{{ asset('cms/assets/js/taskJs/task.js') }}"></script>
    <script>
        var startDate = new Date("2023-01-01");
        var endDate = new Date();
        var subActivityTrNumber = document.querySelectorAll('td.planned');
        var count = subActivityTrNumber.length

        function filter() {
            var project_id = document.querySelector("#project_id").value
            var tableStart_date = document.querySelector("#start_date").value
            var tableEnd_date = document.querySelector("#end_date").value
        }
        generateTable(startDate, endDate, count);
    </script>
@endsection
