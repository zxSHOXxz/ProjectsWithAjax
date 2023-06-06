function performStoreSubActivity() {
    let formData = new FormData();

    formData.append('titleSubActivity', document.getElementById('titleSubActivity').value);
    formData.append('startSubActivity', document.getElementById('startSubActivity').value);
    formData.append('endSubActivity', document.getElementById('endSubActivity').value);
    formData.append('activity_id', document.getElementById('activity_id').value);
    store('/sub_activity', formData);
}
function performStoreActivity() {
    var formData = new FormData();

    var mainActivities = document.querySelectorAll('#cardActivityContainer .cardAcivity');

    mainActivities.forEach(function (activity) {
        var title = activity.querySelector('#titleActivity').value;
        var startDate = activity.querySelector('#startActivity').value;
        var endDate = activity.querySelector('#endActivity').value;

        formData.append('mainActivity[]', JSON.stringify({
            title: title,
            startDate: startDate,
            endDate: endDate
        }));

        var subActivities = activity.querySelectorAll('#cardSubActivityContainer .cardSubAcivity');

        subActivities.forEach(function (subActivity) {
            var subActivityTitle = subActivity.querySelector('#titleSubActivity').value;
            var subActivityStartDate = subActivity.querySelector('#startSubActivity').value;
            var subActivityEndDate = subActivity.querySelector('#endSubActivity').value;

            formData.append('subActivity[]', JSON.stringify({
                parentTitle: title,
                subActivityTitle: subActivityTitle,
                subActivityStartDate: subActivityStartDate,
                subActivityEndDate: subActivityEndDate
            }));
        });
    });
    formData.append('titleMainProject', document.querySelector('[name="titleMainProject"]').value);
    formData.append('startMainProject', document.querySelector('[name="startMainProject"]').value);
    formData.append('endMainProject', document.querySelector('[name="endMainProject"]').value);
    store('/project', formData);
    getProjects();
    getActivity();
}
function performStoreActivityInProject(element) {
    var form = document.getElementById("create_formForActivity");
    var formData = new FormData();

    var mainActivity = [
        form.querySelector("#titleActivity").value,
        form.querySelector("#startActivity").value,
        form.querySelector("#activity_project_id").value,
        form.querySelector("#endActivity").value
    ];

    formData.append("mainActivity[]", mainActivity);

    var subActivityCards = form.getElementsByClassName("cardSubAcivity");
    var subActivities = [];

    for (var i = 0; i < subActivityCards.length; i++) {
        var subActivityCard = subActivityCards[i];
        var subActivities = [];
        var subActivity = [
            subActivityCard.querySelector("input[name=titleSubActivity]").value,
            subActivityCard.querySelector("input[name=startSubActivity]").value,
            subActivityCard.querySelector("input[name=endSubActivity]").value,
        ];
        subActivities.push(subActivity);
        formData.append("subActivities[]", subActivities);
    }
    store('/projectActivityStore', formData);
}




