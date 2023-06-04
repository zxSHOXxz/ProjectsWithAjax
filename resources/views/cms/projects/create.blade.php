@extends('cms.master')
@section('title', 'المشاريع')

@section('tittle_1', ' اضافة مشروع ')
@section('tittle_2', ' اضافة مشروع ')


@section('styles')
    <style>
        .color {
            color: #fff;
            margin-inline: 15px;
            width: 35px;
        }
    </style>
@endsection


@section('content')

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0"> اضافة تصنيف </h6>
        </div>
        <div class="card-body">
            <form action="#" id="create_form">
                <div class="mb-3">
                    <label class="form-label">اسم مشروع</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="اسم مشروع">
                </div>
                <div class="row mb-3">
                    <label class="col-lg-3 col-form-label"> الصورة</label>
                    <div class="col-lg-9">
                        <input type="file" class="form-control" name="image" id="image">
                        <div class="form-text text-muted">Accepted formats: gif, png, jpg. Max file size 2Mb</div>
                    </div>
                </div>
                <div class="d-flex justify-content-end align-items-center">
                    <a href="{{ route('project.index') }}" class="btn btn-light">الغاء</a>
                    <button type="button" onclick="performStore()" class="btn btn-primary ms-3"> اضافة <i
                            class="ph-paper-plane-tilt ms-2"></i></button>
                </div>
            </form>
        </div>
    </div>

@endsection






@section('scripts')
    <script src="{{ asset('cms/assets/js/vendor/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('cms/assets/demo/pages/form_select2.js') }}"></script>
    <script>
        function performStore() {
            let formData = new FormData();
            formData.append('name', document.getElementById('name').value);
            formData.append('image', document.getElementById('image').files[0]);
            store('/cms/admin/project', formData);
        }
    </script>
@endsection
