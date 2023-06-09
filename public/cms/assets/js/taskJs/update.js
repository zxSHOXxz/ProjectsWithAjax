function preformUpdateProject() {
    let formData = new FormData();
    formData.append(
        "titleProjectUpdate",
        document.getElementById("titleProjectUpdate").value
    );
    formData.append(
        "startProjectUpdate",
        document.getElementById("startProjectUpdate").value
    );
    formData.append(
        "endProjectUpdate",
        document.getElementById("endProjectUpdate").value
    );
    id = document.getElementById("Edit_project_id").value;
    storeRoute("/project_update/" + id, formData);
    getProjects();
}

function preformUpdateActivity() {
    let formData = new FormData();

    formData.append(
        "titleActivitytUpdate",
        document.getElementById("titleActivitytUpdate").value
    );
    formData.append(
        "startActivitytUpdate",
        document.getElementById("startActivitytUpdate").value
    );
    formData.append(
        "endActivitytUpdate",
        document.getElementById("endActivitytUpdate").value
    );
    id = document.getElementById("Edit_activity_id").value;
    storeRoute("/activity_update/" + id, formData);
    getActivity();
}

function preformUpdateSubActivity() {
    let formData = new FormData();
    formData.append(
        "titleSub_ActivitytUpdate",
        document.getElementById("titleSub_ActivitytUpdate").value
    );
    formData.append(
        "startSub_ActivitytUpdate",
        document.getElementById("startSub_ActivitytUpdate").value
    );
    formData.append(
        "endSub_ActivitytUpdate",
        document.getElementById("endSub_ActivitytUpdate").value
    );
    id = document.getElementById("Edit_sub_activity_id").value;
    storeRoute("/sub_activity_update/" + id, formData);
}

function modalUpdataProject(referance) {
    var dataId = referance.dataset.id;
    var Edit_project_id = document.getElementById("Edit_project_id");
    Edit_project_id.value = dataId;
    document.getElementById("titleProjectUpdate").value =
        referance.dataset.title;
    document.getElementById("startProjectUpdate").value =
        referance.dataset.start;
    document.getElementById("endProjectUpdate").value = referance.dataset.end;
}

function modalUpdataActivity(referance) {
    var dataId = referance.dataset.id;
    var Edit_activity_id = document.getElementById("Edit_activity_id");
    Edit_activity_id.value = dataId;
    document.getElementById("titleActivitytUpdate").value =
        referance.dataset.title;
    document.getElementById("startActivitytUpdate").value =
        referance.dataset.start;
    document.getElementById("endActivitytUpdate").value = referance.dataset.end;
}

function modalUpdataSubActivity(referance) {
    var dataId = referance.dataset.id;
    var Edit_sub_activity_id = document.getElementById("Edit_sub_activity_id");
    Edit_sub_activity_id.value = dataId;
    document.getElementById("titleSub_ActivitytUpdate").value =
        referance.dataset.title;
    document.getElementById("startSub_ActivitytUpdate").value =
        referance.dataset.start;
    document.getElementById("endSub_ActivitytUpdate").value =
        referance.dataset.end;
}
