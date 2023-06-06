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
    </style>
@endsection


@section('content')
    <div id="table-container">

    </div>
@endsection






@section('scripts')
    <script src="{{ asset('cms/assets/js/taskJs/task.js') }}"></script>
@endsection
