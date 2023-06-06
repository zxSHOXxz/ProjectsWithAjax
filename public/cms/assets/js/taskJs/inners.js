var cardTemplateActivity =
    `
    <div class="card cardAcivity">
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
                <div class="row mb-3">
                        <button type="button" id="addButtonSubActivity" onclick="createCardSubActivity(this)" class="btn btn-dark my-3">
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
    `
var cardTemplateSubActivity =
    `
<div class="col-6">
    <div class="card cardSubAcivity">
        <div class="card-header">
            <h6 class="mb-0"> انشاء نشاط فرعي </h6>
        </div>
        <div class="card-body">
            <form action="#" id="create_form">
                <div class="mb-3">
                    <label class="form-label">عنوان النشاط</label>
                    <input type="text" name="titleSubActivity" id="titleSubActivity" class="form-control" placeholder="عنوان النشاط">
                </div>
                <div class="row mb-3">
                    <label class="col-form-label col-lg-3">تاريخ البدء</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="date" id="startSubActivity" name="startSubActivity">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-form-label col-lg-3">تاريخ الانتهاء</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="date" id="endSubActivity" name="endSubActivity">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
    `

function createCardActivity() {
    var cardContainerActivity = document.getElementById("cardActivityContainer");
    cardContainerActivity.innerHTML += cardTemplateActivity;
}

function createCardSubActivity(referance) {
    var container = referance.nextElementSibling.querySelector('#cardSubActivityContainer');
    container.innerHTML += cardTemplateSubActivity;
}
