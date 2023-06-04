@extends('cms.master')
@section('title', 'المشاريع')

@section('tittle_1', ' عرض المشاريع ')
@section('tittle_2', ' عرض المشاريع ')


@section('styles')
    <style>
        .color {
            color: #fff;
            padding: 15px;
            width: 35px;
        }
    </style>
@endsection


@section('content')

    <!-- Basic datatable -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">قائمة المشاريع</h5>
            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#ProjectsModal"> اضافة مشروع جديد </button>
        </div>
        <table class="table datatable-basic ProjectsTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>الانتهاء</th>
                    <th>البدء</th>
                    <th class="div-center">الاجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>{{ $project->title }}</td>
                        <td>{{ $project->start }}</td>
                        <td class="text-nowrap">{{ $project->end }}</td>
                        <td class="div-center">
                            <div class="d-inline-flex">
                                <div class="dropdown">
                                    <a href="#" class="div-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="{{ route('project.edit', $project->id) }}" class="dropdown-item">
                                            <i class="ph-file-doc me-2"></i>
                                            تعديل
                                        </a>
                                        <a href="#" onclick="performDestroy({{ $project->id }},this)"
                                            class="dropdown-item">
                                            <i class="ph-file-doc me-2"></i>
                                            حذف
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /basic datatable -->

    <div class="modal modal-xl fade" id="ProjectsModal" tabindex="-1" aria-labelledby="CreatProjectLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                data-bs-target="#create-project" type="button" role="tab"
                                aria-controls="create-project" aria-selected="true">انشاء مشروع جديد</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#index-activity"
                                type="button" role="tab" aria-controls="index-activity"
                                aria-selected="false">الانشطة</button>
                        </li>

                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="create-project" role="tabpanel"
                            aria-labelledby="home-tab" tabindex="0">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0"> اضافة مشروع </h6>
                                </div>
                                <div class="card-body">
                                    <form action="#" id="create_form" class="formProject">
                                        <div class="mb-3">
                                            <label class="form-label">عنوان مشروع</label>
                                            <input type="text" name="title" id="titleProject" class="form-control"
                                                placeholder="عنوان مشروع">
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-form-label col-lg-3">تاريخ البدء</label>
                                            <div class="col-lg-9">
                                                <input class="form-control" type="date" id="startProject" name="start">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-form-label col-lg-3">تاريخ الانتهاء</label>
                                            <div class="col-lg-9">
                                                <input class="form-control" type="date" id="endProject" name="end">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end align-items-center">
                                            <button type="button" onclick="performStoreProject()"
                                                class="btn btn-primary ms-3">
                                                اضافة المشروع فقط <i class="ph-paper-plane-tilt ms-2"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="index-activity" role="tabpanel" aria-labelledby="profile-tab"
                            tabindex="0">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">قائمة الانشطة</h5>
                                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createActivity">
                                        اضافة نشاط جديد </button>
                                </div>
                                <table class="table datatable-basic ActivityTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الاسم</th>
                                            <th>الانتهاء</th>
                                            <th>البدء</th>
                                            {{-- <th>الانشطة الفرعية</th> --}}
                                            <th class="div-center">الاجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($activities as $activity)
                                            <tr>
                                                <td>{{ $activity->id }}</td>
                                                <td>{{ $activity->title }}</td>
                                                <td>{{ $activity->start }}</td>
                                                <td>{{ $activity->end }}</td>
                                                <td>
                                                    <button onclick="getSubActivity({{ $activity->id }})"
                                                        data-bs-toggle="modal" data-bs-target="#getSubActivity"
                                                        class="btn btn-indigo"> الانشطة الفرعية </button>
                                                </td>
                                                <td class="div-center">
                                                    <div class="d-inline-flex">
                                                        <div class="dropdown">
                                                            <a href="#" class="div-body" data-bs-toggle="dropdown">
                                                                <i class="ph-list"></i>
                                                            </a>

                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a href="{{ route('activity.edit', $activity->id) }}"
                                                                    class="dropdown-item">
                                                                    <i class="ph-file-doc me-2"></i>
                                                                    تعديل
                                                                </a>
                                                                <a href="#"
                                                                    onclick="performDestroy({{ $activity->id }},this)"
                                                                    class="dropdown-item">
                                                                    <i class="ph-file-doc me-2"></i>
                                                                    حذف
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal modal-xl fade" id="createActivity" tabindex="-1" aria-labelledby="createActivityLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createActivityLabel"> انشاء نشاط </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"> انشاء نشاط </h6>
                        </div>
                        <div class="card-body">
                            <form action="#" id="create_form">
                                <div class="mb-3">
                                    <label class="form-label">عنوان النشاط</label>
                                    <input type="text" name="title" id="titleActivity" class="form-control"
                                        placeholder="عنوان النشاط">
                                </div>
                                <div class="row mb-3">
                                    <label class="col-form-label col-lg-3">تاريخ البدء</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="date" id="startActivity" name="start">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-form-label col-lg-3">تاريخ الانتهاء</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="date" id="endActivity" name="end">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-form-label col-lg-3">المشروع</label>
                                    <div class="col-lg-9">
                                        <select data-placeholder="المشروع" name="project_id" id="project_id"
                                            class="form-control select-icons">
                                            @foreach ($projects as $project)
                                                <option value="{{ $project->id }}">{{ $project->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end align-items-center">
                                    <button data-bs-dismiss="modal" class="btn btn-light">الغاء</button>

                                    <button type="button" onclick="performStoreActivity()" class="btn btn-primary ms-3">
                                        اضافة <i class="ph-paper-plane-tilt ms-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="getSubActivity" tabindex="-1" aria-labelledby="getSubActivity" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> عرض الانشطة الفرعية </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table datatable-basic subActivityTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>الانتهاء</th>
                                <th>البدء</th>
                                <th class="div-center">الاجراءات</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection






@section('scripts')
    <script>
        function performDestroy(id, referance) {
            let url = '/cms/admin/project/' + id;
            confirmDestroy(url, referance);
        }
        /* ------------------------------------------------------------------------------
         *
         *  # Basic datatables
         *
         *  Demo JS code for datatable_basic.html page
         *
         * ---------------------------------------------------------------------------- */


        // Setup module
        // ------------------------------

        const DatatableBasic = function() {


            //
            // Setup module components
            //

            // Basic Datatable examples
            const _componentDatatableBasic = function() {
                if (!$().DataTable) {
                    console.warn('Warning - datatables.min.js is not loaded.');
                    return;
                }

                // Setting datatable defaults
                $.extend($.fn.dataTable.defaults, {
                    autoWidth: false,
                    columnDefs: [{
                        orderable: false,
                        width: 100,
                        targets: [3]
                    }],
                    lengthMenu: [
                        [100, 200, 300, 400, 500],
                        [100, 200, 300, 400, 500]
                    ],
                    pageLength: 100,
                    dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
                    language: {
                        search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="opacity-50 ph-magnifying-glass"></i></div></div>',
                        searchPlaceholder: 'Type to filter...',
                        lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                        paginate: {
                            'first': 'First',
                            'last': 'Last',
                            'next': document.dir == "rtl" ? '&larr;' : '&rarr;',
                            'previous': document.dir == "rtl" ? '&rarr;' : '&larr;'
                        }
                    }
                });

                // Basic datatable
                $('.datatable-basic').DataTable();

                // Alternative pagination
                $('.datatable-pagination').DataTable({
                    pagingType: "simple",
                    language: {
                        paginate: {
                            'next': document.dir == "rtl" ? 'Next &larr;' : 'Next &rarr;',
                            'previous': document.dir == "rtl" ? '&rarr; Prev' : '&larr; Prev'
                        }
                    }
                });

                // Datatable with saving state
                $('.datatable-save-state').DataTable({
                    stateSave: true
                });

                // Scrollable datatable
                const table = $('.datatable-scroll-y').DataTable({
                    autoWidth: true,
                    scrollY: 300
                });

                // Resize scrollable table when sidebar width changes
                $('.sidebar-control').on('click', function() {
                    table.columns.adjust().draw();
                });
            };


            //
            // Return objects assigned to module
            //

            return {
                init: function() {
                    _componentDatatableBasic();
                }
            }
        }();


        // Initialize module
        // ------------------------------

        document.addEventListener('DOMContentLoaded', function() {
            DatatableBasic.init();
        });
    </script>
    <script src="{{ asset('cms/assets/js/vendor/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('cms/assets/demo/pages/form_select2.js') }}"></script>
    <script>
        function performStoreProject() {
            let formData = new FormData();
            formData.append('title', document.getElementById('titleProject').value);
            formData.append('end', document.getElementById('endProject').value);
            formData.append('start', document.getElementById('startProject').value);
            store('/project', formData);
            getProjects();
            getProjectsForSelect();
        }

        function performStoreActivity() {
            let formData = new FormData();

            function checkFormData() {
                var formProject = document.querySelector('.formProject');
                var inputs = formProject.querySelectorAll('input');

                for (var i = 0; i < inputs.length; i++) {
                    if (inputs[i].value !== "") {
                        return true;
                    }
                }

                return false;
            }

            var hasFormData = checkFormData();
            if (hasFormData) {
                formData.append('titleProject', document.getElementById('titleProject').value);
                formData.append('endProject', document.getElementById('endProject').value);
                formData.append('startProject', document.getElementById('startProject').value);
            }
            formData.append('titleActivity', document.getElementById('titleActivity').value);
            formData.append('endActivity', document.getElementById('endActivity').value);
            formData.append('startActivity', document.getElementById('startActivity').value);
            formData.append('project_id', document.getElementById('project_id').value);
            store('/activity', formData);
        }

        function getSubActivity(id) {
            $.get('/getSubActivity/' + id, function(data) {
                var tableBody = $('.subActivityTable tbody');
                tableBody.empty();

                data.forEach(function(item) {
                    var row = $('<tr>');
                    row.append($('<td>').text(item.id));
                    row.append($('<td>').text(item.title));
                    row.append($('<td>').text(item.start));
                    row.append($('<td>').text(item.end));

                    var dropdownContainer = $('<div>').addClass('d-inline-flex');
                    var dropdownDiv = $('<div>').addClass('dropdown');
                    var dropdownToggle = $('<a>').attr('href', '#').addClass('div-body');
                    dropdownToggle.attr('data-bs-toggle', 'dropdown');
                    dropdownToggle.append($('<i>').addClass('ph-list'));
                    dropdownDiv.append(dropdownToggle);

                    var dropdownMenu = $('<div>').addClass('dropdown-menu dropdown-menu-end');
                    var editLink = $('<a>').attr('href', '{{ route('project.edit', 'item.id') }}')
                        .addClass('dropdown-item');
                    editLink.append($('<i>').addClass('ph-file-doc me-2'));
                    editLink.append('تعديل');
                    dropdownMenu.append(editLink);

                    var deleteLink = $('<a>').attr('href', '#').addClass('dropdown-item');
                    deleteLink.attr('onclick', 'performDestroy(' + item.id + ', this)');
                    deleteLink.append($('<i>').addClass('ph-file-doc me-2'));
                    deleteLink.append('حذف');
                    dropdownMenu.append(deleteLink);

                    dropdownDiv.append(dropdownMenu);
                    dropdownContainer.append(dropdownDiv);
                    row.append($('<td>').append(dropdownContainer));
                    tableBody.append(row);
                });
            });
        }

        function getActivity() {
            $.get('/getActivity', function(data) {
                var tableBody = $('.ActivityTable tbody');
                console.log(data);
                tableBody.empty();

                data.forEach(function(item) {
                    var row = $('<tr>');
                    row.append($('<td>').text(item.id));
                    row.append($('<td>').text(item.title));
                    row.append($('<td>').text(item.start));
                    row.append($('<td>').text(item.end));

                    var dropdownContainer = $('<div>').addClass('d-inline-flex');
                    var dropdownDiv = $('<div>').addClass('dropdown');
                    var dropdownToggle = $('<a>').attr('href', '#').addClass('div-body');
                    dropdownToggle.attr('data-bs-toggle', 'dropdown');
                    dropdownToggle.append($('<i>').addClass('ph-list'));
                    dropdownDiv.append(dropdownToggle);

                    var dropdownMenu = $('<div>').addClass('dropdown-menu dropdown-menu-end');
                    var editLink = $('<a>').attr('href', `/project/edit/${item.id}`)
                        .addClass('dropdown-item');
                    editLink.append($('<i>').addClass('ph-file-doc me-2'));
                    editLink.append('تعديل');
                    dropdownMenu.append(editLink);

                    var deleteLink = $('<a>').attr('href', '#').addClass('dropdown-item');
                    deleteLink.attr('onclick', 'performDestroy(' + item.id + ', this)');
                    deleteLink.append($('<i>').addClass('ph-file-doc me-2'));
                    deleteLink.append('حذف');
                    dropdownMenu.append(deleteLink);

                    dropdownDiv.append(dropdownMenu);
                    dropdownContainer.append(dropdownDiv);
                    row.append($('<td>').append(dropdownContainer));
                    tableBody.append(row);
                });
            });
        }

        function getProjects() {
            $.get('/getProjects', function(data) {
                var tableBody = $('.ProjectsTable tbody');
                console.log(data);
                tableBody.empty();

                data.forEach(function(item) {
                    var row = $('<tr>');
                    row.append($('<td>').text(item.id));
                    row.append($('<td>').text(item.title));
                    row.append($('<td>').text(item.start));
                    row.append($('<td>').text(item.end));

                    var dropdownContainer = $('<div>').addClass('d-inline-flex');
                    var dropdownDiv = $('<div>').addClass('dropdown');
                    var dropdownToggle = $('<a>').attr('href', '#').addClass('div-body');
                    dropdownToggle.attr('data-bs-toggle', 'dropdown');
                    dropdownToggle.append($('<i>').addClass('ph-list'));
                    dropdownDiv.append(dropdownToggle);

                    var dropdownMenu = $('<div>').addClass('dropdown-menu dropdown-menu-end');
                    var editLink = $('<a>').attr('href', `/project/edit/${item.id}`)
                        .addClass('dropdown-item');
                    editLink.append($('<i>').addClass('ph-file-doc me-2'));
                    editLink.append('تعديل');
                    dropdownMenu.append(editLink);

                    var deleteLink = $('<a>').attr('href', '#').addClass('dropdown-item');
                    deleteLink.attr('onclick', 'performDestroy(' + item.id + ', this)');
                    deleteLink.append($('<i>').addClass('ph-file-doc me-2'));
                    deleteLink.append('حذف');
                    dropdownMenu.append(deleteLink);

                    dropdownDiv.append(dropdownMenu);
                    dropdownContainer.append(dropdownDiv);
                    row.append($('<td>').append(dropdownContainer));
                    tableBody.append(row);
                });
            });
        }

        function getProjectsForSelect() {
            $.get('/getProjects', function(data) {
                var selectElement = $('#project_id');
                selectElement.empty();

                data.forEach(function(item) {
                    var option = $('<option>').attr('value', item.id).text(item.title);
                    selectElement.append(option);
                });
            });
        }
    </script>
@endsection
