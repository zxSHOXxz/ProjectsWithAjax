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
                    <th>البدء</th>
                    <th>الانتهاء</th>
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
                                        <button data-id="{{ $project->id }}" data-title="{{ $project->title }}"
                                            data-start="{{ $project->start }}" data-end="{{ $project->end }}"
                                            data-bs-toggle="modal" onclick="modalUpdataProject(this)"
                                            data-bs-target="#EditProject" id="editProjectBtn" class="dropdown-item">
                                            <i class="ph-file-doc me-2"></i>
                                            تعديل
                                        </button>
                                        <a href="#" onclick="performDestroyProject({{ $project->id }},this)"
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

    {{-- create Project Modal --}}
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
                                            <button type="button" onclick="performStoreActivity()"
                                                class="btn btn-primary ms-3">
                                                حفظ <i class="ph-paper-plane-tilt ms-2"></i></button>
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
                                            <th>الانشطة الفرعية</th>
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
            </div>
        </div>
    </div>
    {{-- create Activity Modal --}}
    <div class="modal modal-xl fade" id="createActivity" tabindex="-1" aria-labelledby="createActivityLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header gap-5">
                    <h5 class="modal-title" id="createActivityLabel"> انشاء نشاط </h5>
                    <button type="button" id="addButtonActivity" class="btn btn-dark my-3">
                        <i class="fas fa-plus"></i> إضافة
                    </button>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="cardActivityContainer">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"> انشاء نشاط </h6>
                        </div>
                        <div class="card-body">
                            <form action="#" id="create_form">
                                <div class="mb-3">
                                    <label class="form-label">عنوان النشاط</label>
                                    <input type="text" name="titleActivity" id="titleActivity" class="form-control"
                                        placeholder="عنوان النشاط">
                                </div>
                                <div class="row mb-3">
                                    <label class="col-form-label col-lg-3">تاريخ البدء</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="date" id="startActivity"
                                            name="endActivity">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-form-label col-lg-3">تاريخ الانتهاء</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="date" id="endActivity"
                                            name="startActivity">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Get Sub Activity Modal --}}
    <div class="modal fade" id="getSubActivity" tabindex="-1" aria-labelledby="getSubActivity" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header gap-5">
                    <h5 class="modal-title" id="exampleModalLabel"> عرض الانشطة الفرعية
                    </h5>
                    <button class="btn btn-dark" id="addSubActivity" data-bs-toggle="modal"
                        data-bs-target="#createSubActivity"> اضافة
                        نشاط فرعي جديد
                    </button>
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
    {{-- create Sub Activity Modal --}}
    <div class="modal modal-xl fade" id="createSubActivity" tabindex="-1" aria-labelledby="createSubActivityLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSubActivityLabel"> انشاء نشاط فرعي </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"> انشاء نشاط فرعي </h6>
                        </div>
                        <div class="card-body">
                            <form action="#" id="create_form">
                                <div class="mb-3">
                                    <label class="form-label">عنوان النشاط الفرعي</label>
                                    <input type="text" name="titleSubActivity" id="titleSubActivity"
                                        class="form-control" placeholder="عنوان النشاط الفرعي">
                                </div>
                                <div class="row mb-3">
                                    <label class="col-form-label col-lg-3">تاريخ البدء</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="date" id="startSubActivity"
                                            name="startSubActivity">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-form-label col-lg-3">تاريخ الانتهاء</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="date" id="endSubActivity"
                                            name="endSubActivity">
                                    </div>
                                </div>
                                <input class="form-control" type="text" id="activity_id" name="activity_id" hidden>

                                <div class="d-flex justify-content-end align-items-center">
                                    <button type="button" onclick="performStoreSubActivity()"
                                        class="btn btn-primary ms-3">
                                        حفظ <i class="ph-paper-plane-tilt ms-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Edit Project Modal --}}
    <div class="modal modal-xl fade" id="EditProject" tabindex="-1" aria-labelledby="EditProjectLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSubActivityLabel"> تعديل المشروع </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"> تعديل المشروع </h6>
                        </div>
                        <div class="card-body">
                            <form action="#" id="create_form">
                                <div class="mb-3">
                                    <label class="form-label"> عنوان المشروع </label>
                                    <input type="text" name="titleProjectUpdate" id="titleProjectUpdate"
                                        class="form-control" placeholder="عنوان المشروع">
                                </div>
                                <div class="row mb-3">
                                    <label class="col-form-label col-lg-3">تاريخ البدء</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="date" id="startProjectUpdate"
                                            name="startProjectUpdate">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-form-label col-lg-3">تاريخ الانتهاء</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="date" id="endProjectUpdate"
                                            name="endProjectUpdate">
                                    </div>
                                </div>
                                <input class="form-control" type="text" id="Edit_project_id" name="Edit_project_id"
                                    hidden>

                                <div class="d-flex justify-content-end align-items-center">
                                    <button type="button" onclick="preformUpdateProject()" class="btn btn-primary ms-3">
                                        حفظ <i class="ph-paper-plane-tilt ms-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Edit Activity Modal --}}
    <div class="modal modal-xl fade" id="EditActivity" tabindex="-1" aria-labelledby="EditActivityLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSubActivityLabel"> تعديل النشاط </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"> تعديل النشاط </h6>
                        </div>
                        <div class="card-body">
                            <form action="#" id="create_form">
                                <div class="mb-3">
                                    <label class="form-label"> عنوان النشاط </label>
                                    <input type="text" name="titleActivityUpdate" id="titleActivitytUpdate"
                                        class="form-control" placeholder="عنوان النشاط">
                                </div>
                                <div class="row mb-3">
                                    <label class="col-form-label col-lg-3">تاريخ البدء</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="date" id="startActivitytUpdate"
                                            name="startActivityUpdate">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-form-label col-lg-3">تاريخ الانتهاء</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="date" id="endActivitytUpdate"
                                            name="endActivityUpdate">
                                    </div>
                                </div>
                                <input class="form-control" type="text" id="Edit_activity_id" name="Edit_activity_id"
                                    hidden>

                                <div class="d-flex justify-content-end align-items-center">
                                    <button type="button" onclick="preformUpdateActivity()"
                                        class="btn btn-primary ms-3">
                                        حفظ <i class="ph-paper-plane-tilt ms-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Edit Sub Activity Modal --}}
    <div class="modal modal-xl fade" id="EditSubActivity" tabindex="-1" aria-labelledby="EditSubActivityLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditSubActivityLabel"> تعديل النشاط الفرعي</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"> تعديل النشاط الفرعي </h6>
                        </div>
                        <div class="card-body">
                            <form action="#" id="create_form">
                                <div class="mb-3">
                                    <label class="form-label"> عنوان النشاط الفرعي </label>
                                    <input type="text" name="titleSub_ActivitytUpdate" id="titleSub_ActivitytUpdate"
                                        class="form-control" placeholder="عنوان المشروع">
                                </div>
                                <div class="row mb-3">
                                    <label class="col-form-label col-lg-3">تاريخ البدء</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="date" id="startSub_ActivitytUpdate"
                                            name="startSub_ActivitytUpdate">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-form-label col-lg-3">تاريخ الانتهاء</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="date" id="endSub_ActivitytUpdate"
                                            name="endSub_ActivitytUpdate">
                                    </div>
                                </div>
                                <input class="form-control" type="text" id="Edit_sub_activity_id"
                                    name="Edit_sub_activity_id" hidden>

                                <div class="d-flex justify-content-end align-items-center">
                                    <button type="button" onclick="preformUpdateSubActivity()"
                                        class="btn btn-primary ms-3">
                                        حفظ <i class="ph-paper-plane-tilt ms-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection





@section('scripts')
    <script>
        function performDestroyProject(id, referance) {
            let url = '/project/' + id;
            confirmDestroy(url, referance);
        }

        function performDestroyActivity(id, referance) {
            let url = '/activity/' + id;
            confirmDestroy(url, referance);
        }

        function performDestroysub_Activity(id, referance) {
            let url = '/sub_activity/' + id;
            confirmDestroy(url, referance);
        }
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
        document.addEventListener('DOMContentLoaded', function() {
            DatatableBasic.init();
        });
    </script>
    <script src="{{ asset('cms/assets/js/vendor/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('cms/assets/demo/pages/form_select2.js') }}"></script>
    <script>
        function performStoreActivity() {
            let formData = new FormData();

            let titleActivities = document.querySelectorAll('[name="titleActivity"]');
            let endActivities = document.querySelectorAll('[name="endActivity"]');
            let startActivities = document.querySelectorAll('[name="startActivity"]');

            titleActivities.forEach(function(input) {
                formData.append('titleActivity', input.value);
            });
            endActivities.forEach(function(input) {
                formData.append('endActivity', input.value);
            });
            startActivities.forEach(function(input) {
                formData.append('startActivity', input.value);
            });

            let formDataMap = new Map();

            formData.forEach(function(value, key) {
                if (!formDataMap.has(key)) {
                    formDataMap.set(key, []);
                }
                formDataMap.get(key).push(value);
            });
        }


        function preformUpdateProject() {
            let formData = new FormData();
            formData.append('titleProjectUpdate', document.getElementById('titleProjectUpdate').value);
            formData.append('startProjectUpdate', document.getElementById('startProjectUpdate').value);
            formData.append('endProjectUpdate', document.getElementById('endProjectUpdate').value);
            id = document.getElementById('Edit_project_id').value;
            // console.log(document.getElementById('Edit_project_id').value);
            storeRoute('/project_update/' + id, formData);
            getProjects();
        }

        function preformUpdateActivity() {
            let formData = new FormData();

            formData.append('titleActivitytUpdate', document.getElementById('titleActivitytUpdate').value);
            formData.append('startActivitytUpdate', document.getElementById('startActivitytUpdate').value);
            formData.append('endActivitytUpdate', document.getElementById('endActivitytUpdate').value);
            id = document.getElementById('Edit_activity_id').value;
            storeRoute('/activity_update/' + id, formData);
            getActivity();
        }

        function preformUpdateSubActivity() {
            let formData = new FormData();
            formData.append('titleSub_ActivitytUpdate', document.getElementById('titleSub_ActivitytUpdate').value);
            formData.append('startSub_ActivitytUpdate', document.getElementById('startSub_ActivitytUpdate').value);
            formData.append('endSub_ActivitytUpdate', document.getElementById('endSub_ActivitytUpdate').value);
            id = document.getElementById('Edit_sub_activity_id').value;
            storeRoute('/sub_activity_update/' + id, formData);
        }

        function getSubActivity(id) {
            $.get('/getSubActivity/' + id, function(data) {
                var tableBody = $('.subActivityTable tbody');
                var addSubActivity = $('#addSubActivity');
                addSubActivity.attr('data-id', id);

                tableBody.empty();

                data.forEach(function(item) {
                    var row = $('<tr>');
                    row.append($('<td>').text(item.id));
                    row.append($('<td>').text(item.title));
                    row.append($('<td>').addClass('text-nowrap').text(item.start));
                    row.append($('<td>').addClass('text-nowrap').text(item.end));

                    var dropdownContainer = $('<div>').addClass('d-inline-flex');
                    var dropdownDiv = $('<div>').addClass('dropdown');
                    var dropdownToggle = $('<a>').attr('href', '#').addClass('div-body');
                    dropdownToggle.attr('data-bs-toggle', 'dropdown');
                    dropdownToggle.append($('<i>').addClass('ph-list'));
                    dropdownDiv.append(dropdownToggle);

                    var dropdownMenu = $('<div>').addClass('dropdown-menu dropdown-menu-end');
                    var editLink = $('<button>').attr('onclick', 'modalUpdataSubActivity(this)')
                        .attr('data-id', item.id)
                        .attr('data-title', item.title)
                        .attr('data-start', item.start)
                        .attr('data-end', item.end)
                        .attr('data-bs-toggle', "modal")
                        .attr('data-bs-target', "#EditSubActivity")
                        .addClass('dropdown-item');
                    editLink.append($('<i>').addClass('ph-file-doc me-2'));
                    editLink.append('تعديل');
                    dropdownMenu.append(editLink);

                    var deleteLink = $('<a>').attr('href', '#').addClass('dropdown-item');
                    deleteLink.attr('onclick', 'performDestroysub_Activity(' + item.id + ', this)');
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
                    row.append($('<td>').addClass('text-nowrap').text(item.start));
                    row.append($('<td>').addClass('text-nowrap').text(item.end));
                    row.append($('<td>').append(
                        $('<button>')
                        .text('الانشطة الفرعية')
                        .addClass('btn btn-indigo')
                        .attr('onclick', `getSubActivity(${item.id})`)
                        .attr('data-bs-toggle', 'modal')
                        .attr('data-bs-target', '#getSubActivity')
                    ));

                    var dropdownContainer = $('<div>').addClass('d-inline-flex');
                    var dropdownDiv = $('<div>').addClass('dropdown');
                    var dropdownToggle = $('<a>').attr('href', '#').addClass('div-body');
                    dropdownToggle.attr('data-bs-toggle', 'dropdown');
                    dropdownToggle.append($('<i>').addClass('ph-list'));
                    dropdownDiv.append(dropdownToggle);

                    var dropdownMenu = $('<div>').addClass('dropdown-menu dropdown-menu-end');
                    var editLink = $('<button>').attr('onclick', 'modalUpdataActivity(this)')
                        .attr('data-id', item.id)
                        .attr('data-title', item.title)
                        .attr('data-start', item.start)
                        .attr('data-end', item.end)
                        .attr('data-bs-toggle', "modal")
                        .attr('data-bs-target', "#EditActivity")
                        .addClass('dropdown-item');
                    editLink.append($('<i>').addClass('ph-file-doc me-2'));
                    editLink.append('تعديل');
                    dropdownMenu.append(editLink);

                    var deleteLink = $('<a>').attr('href', '#').addClass('dropdown-item');
                    deleteLink.attr('onclick', 'performDestroyActivity(' + item.id + ', this)');
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
                    row.append($('<td>').addClass('text-nowrap').text(item.start));
                    row.append($('<td>').addClass('text-nowrap').text(item.end));

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

        let prof = document.getElementById('profile-tab')
        prof.addEventListener('click', _ => {
            getActivity();
        })

        var addSubActivityBtn = document.getElementById('addSubActivity');
        addSubActivityBtn.addEventListener('click', _ => {
            var dataId = addSubActivityBtn.dataset.id;
            var activity_id_input = document.getElementById('activity_id');
            activity_id_input.value = dataId;
        });

        function modalUpdataProject(referance) {
            var dataId = referance.dataset.id;
            var Edit_project_id = document.getElementById('Edit_project_id');
            Edit_project_id.value = dataId;
            document.getElementById('titleProjectUpdate').value = referance.dataset.title;
            document.getElementById('startProjectUpdate').value = referance.dataset.start;
            document.getElementById('endProjectUpdate').value = referance.dataset.end;
        }

        function modalUpdataActivity(referance) {
            var dataId = referance.dataset.id;
            var Edit_activity_id = document.getElementById('Edit_activity_id');
            Edit_activity_id.value = dataId;
            document.getElementById('titleActivitytUpdate').value = referance.dataset.title;
            document.getElementById('startActivitytUpdate').value = referance.dataset.start;
            document.getElementById('endActivitytUpdate').value = referance.dataset.end;
        }

        function modalUpdataSubActivity(referance) {
            var dataId = referance.dataset.id;
            var Edit_sub_activity_id = document.getElementById('Edit_sub_activity_id');
            Edit_sub_activity_id.value = dataId;
            document.getElementById('titleSub_ActivitytUpdate').value = referance.dataset.title;
            document.getElementById('startSub_ActivitytUpdate').value = referance.dataset.start;
            document.getElementById('endSub_ActivitytUpdate').value = referance.dataset.end;
        }

        function performStoreSubActivity() {
            let formData = new FormData();

            formData.append('titleSubActivity', document.getElementById('titleSub_ActivitytUpdate').value);
            formData.append('startSubActivity', document.getElementById('startSub_ActivitytUpdate').value);
            formData.append('endSubActivity', document.getElementById('endSub_ActivitytUpdate').value);
            formData.append('activity_id', document.getElementById('activity_id').value);
            store('/sub_activity', formData);
        }

        var cardContainerActivity = document.getElementById("cardActivityContainer");
        var addButtonActivity = document.getElementById("addButtonActivity");

        var cardContainerSubActivity = document.getElementById("cardSubActivityContainer");
        var addButtonActivity = document.getElementById("addButtonActivity");

        addButtonActivity.addEventListener('click', function() {
            createCardActivity();
        });

        var cardTemplateActivity =
            `
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"> انشاء نشاط </h6>
                    </div>
                    <div class="card-body">
                        <form action="#" id="create_form">
                            <div class="mb-3">
                                <label class="form-label">عنوان النشاط</label>
                                <input type="text" name="titleActivity" id="titleActivity" class="form-control" placeholder="عنوان النشاط">
                            </div>
                            <div class="row mb-3">
                                <label class="col-form-label col-lg-3">تاريخ البدء</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="date" id="startActivity" name="startActivity">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-form-label col-lg-3">تاريخ الانتهاء</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="date" id="endActivity" name="endActivity">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                `
        var cardTemplateSubActivity =
            `
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"> انشاء نشاط </h6>
                    </div>
                    <div class="card-body">
                        <form action="#" id="create_form">
                            <div class="mb-3">
                                <label class="form-label">عنوان النشاط</label>
                                <input type="text" name="titleActivity" id="titleActivity" class="form-control" placeholder="عنوان النشاط">
                            </div>
                            <div class="row mb-3">
                                <label class="col-form-label col-lg-3">تاريخ البدء</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="date" id="startActivity" name="startActivity">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-form-label col-lg-3">تاريخ الانتهاء</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="date" id="endActivity" name="endActivity">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                `

        function createCardActivity() {
            cardContainerActivity.innerHTML += cardTemplateActivity;
        }

        function createCardSubActivity() {
            cardContainerSubActivity.innerHTML += cardTemplateSubActivity;
        }
    </script>
@endsection
