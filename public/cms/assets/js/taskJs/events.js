let prof = document.getElementById('profile-tab')
prof.addEventListener('click', _ => {
    getActivity();
})
let activityForProject = document.getElementById('update-activity-tab')
activityForProject.addEventListener('click', _ => {
    var updateActivityTab = document.querySelector('#update-activity-tab-pane');
    var modalCreateActivityInProject = document.querySelector('#createActivityInProject');
    var activity_project_id = modalCreateActivityInProject.querySelector('input#activity_project_id')
    var btn = updateActivityTab.querySelector('.btn.btn-outline-dark');
    var id = document.getElementById('Edit_project_id').value
    activity_project_id.value = id;
    btn.setAttribute('data-id', id);
    console.log(activity_project_id.value );
    getActivityForProject(id);
})
var addSubActivityBtn = document.getElementById('addSubActivity');
addSubActivityBtn.addEventListener('click', _ => {
    var dataId = addSubActivityBtn.dataset.id;
    var activity_id_input = document.getElementById('activity_id');
    activity_id_input.value = dataId;
});
var addButtonActivity = document.getElementById("addButtonActivity");
addButtonActivity.addEventListener('click', function () {
    createCardActivity();
});
