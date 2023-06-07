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
                                            data-bs-target="#UpdataProjectModal" id="editProjectBtn" class="dropdown-item">
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
                                            <input type="text" name="titleMainProject" id="titleMainProject"
                                                class="form-control" placeholder="عنوان مشروع">
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-form-label col-lg-3">تاريخ البدء</label>
                                            <div class="col-lg-9">
                                                <input class="form-control" type="date" id="startMainProject"
                                                    name="startMainProject">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-form-label col-lg-3">تاريخ الانتهاء</label>
                                            <div class="col-lg-9">
                                                <input class="form-control" type="date" id="endMainProject"
                                                    name="endMainProject">
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
                    <button type="button" id="addButtonActivity" class="btn btn-dark my-3 gap-2">
                        <i class="fas fa-plus"></i> اضافة نشاط جديد
                    </button>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="cardActivityContainer">
                    <div class="card cardAcivity">
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
                                <div class="row mb-3">
                                    <button type="button" id="addButtonSubActivity"
                                        onclick="createCardSubActivity(this)" class="btn btn-dark my-3">
                                        <i class="fas fa-plus"></i> ﺇضافة نشاط فرعي
                                    </button>
                                    <div class="container">
                                        <div class="row" id="cardSubActivityContainer">

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal"
                        data-bs-target="#ProjectsModal">إغلاق</button>
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

    <!-- Modal -->
    <div class="modal modal-xl fade" id="UpdataProjectModal" tabindex="-1" aria-labelledby="UpdataProjectModal"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="UpdataProjectModal">تعديل مشروع</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="update-project-tab" data-bs-toggle="tab"
                                data-bs-target="#update-project-tab-pane" type="button" role="tab"
                                aria-controls="update-project-tab-pane" aria-selected="true">تعديل المشروع</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="update-activity-tab" data-bs-toggle="tab"
                                data-bs-target="#update-activity-tab-pane" type="button" role="tab"
                                aria-controls="update-activity-tab-pane" aria-selected="false">تعديل انشطة
                                المشروع</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="update-project-tab-pane" role="tabpanel"
                            aria-labelledby="update-project-tab" tabindex="0">
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
                                        <input class="form-control" type="text" id="Edit_project_id"
                                            name="Edit_project_id" hidden>

                                        <div class="d-flex justify-content-end align-items-center">
                                            <button type="button" onclick="preformUpdateProject()"
                                                class="btn btn-primary ms-3">
                                                حفظ <i class="ph-paper-plane-tilt ms-2"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="update-activity-tab-pane" role="tabpanel"
                            aria-labelledby="update-activity-tab" tabindex="0">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">قائمة الانشطة الخاصة بالمشروع</h5>
                                    <button class="btn btn-outline-dark" data-bs-target="#createActivityInProject"
                                        data-bs-toggle="modal"> اضافة نشاط جديد </button>

                                </div>
                                <table class="table datatable-basic ActivityTableForProject">
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



    <div class="modal modal-xl fade" id="createActivityInProject" tabindex="-1"
        aria-labelledby="createActivityInProjectLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header gap-5">
                    <h5 class="modal-title" id="createActivityInProjectLabel"> انشاء نشاط </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="cardActivityContainer">
                    <div class="card cardAcivity">
                        <div class="card-header">
                            <h6 class="mb-0"> انشاء نشاط </h6>
                        </div>
                        <div class="card-body">
                            <form action="#" id="create_formForActivity" class="MainActivityInProject">
                                <div class="mb-3">
                                    <label class="form-label">عنوان النشاط</label>
                                    <input type="text" name="titleActivity" id="titleActivity" class="form-control"
                                        placeholder="عنوان النشاط">
                                    <input type="text" name="activity_project_id" id="activity_project_id"
                                        class="form-control" hidden>
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
                                <div class="row mb-3">
                                    <button type="button" id="addButtonSubActivity"
                                        onclick="createCardSubActivity(this)" class="btn btn-dark my-3">
                                        <i class="fas fa-plus"></i> ﺇضافة نشاط فرعي
                                    </button>
                                    <div class="container">
                                        <div class="row" id="cardSubActivityContainer">

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="performStoreActivityInProject(this)"> حفظ
                    </button>
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
    <script src="{{ asset('cms/assets/js/taskJs/getData.js') }}"></script>
    <script src="{{ asset('cms/assets/js/taskJs/storeData.js') }}"></script>
    <script src="{{ asset('cms/assets/js/taskJs/update.js') }}"></script>
    <script src="{{ asset('cms/assets/js/taskJs/inners.js') }}"></script>
    <script src="{{ asset('cms/assets/js/taskJs/events.js') }}"></script>
@endsection
