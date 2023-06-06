function getSubActivity(id) {
    $.get('/getSubActivity/' + id, function (data) {
        var tableBody = $('.subActivityTable tbody');
        var addSubActivity = $('#addSubActivity');
        addSubActivity.attr('data-id', id);

        tableBody.empty();

        data.forEach(function (item) {
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
    $.get('/getActivity', function (data) {
        var tableBody = $('.ActivityTable tbody');
        console.log(data);
        tableBody.empty();

        data.forEach(function (item) {
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
    $.get('/getProjects', function (data) {
        var tableBody = $('.ProjectsTable tbody');
        tableBody.empty();

        data.forEach(function (item) {
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
            var editLink = $('<button>').attr('onclick', 'modalUpdataActivity(this)')
                .attr('data-id', item.id)
                .attr('data-title', item.title)
                .attr('data-start', item.start)
                .attr('data-end', item.end)
                .attr('data-bs-toggle', "modal")
                .attr('data-bs-target', "#UpdataProjectModal")
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

function getActivityForProject(id) {
    $.get('/getActivityForProject/' + id, function (data) {
        var tableBody = $('.ActivityTableForProject tbody');
        console.log(data);
        tableBody.empty();

        data.forEach(function (item) {
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
