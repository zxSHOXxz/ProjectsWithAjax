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

    </div>
@endsection








@section('scripts')
    <script src="{{ asset('cms/assets/js/taskJs/task.js') }}"></script>
    <script>
        function filter() {
            var project_id = document.querySelector("#project_id").value
            var startDateInput = document.querySelector("#start_date").value
            var endDateInput = document.querySelector("#end_date").value
            getClender(project_id, startDateInput, endDateInput);
        }
    </script>
@endsection
