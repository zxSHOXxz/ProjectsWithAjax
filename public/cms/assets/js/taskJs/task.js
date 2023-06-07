function getClender(id, start, end) {
    $.get("/getClender/" + id, function (data) {
        var table = document.createElement("table");
        var thead = document.createElement("thead");
        var tbody = document.createElement("tbody");
        thead.setAttribute("id", "tableThead");
        table.setAttribute("id", "table");
        var trMonths = document.createElement("tr");
        var trWeeks = document.createElement("tr");
        var thWeeks1 = document.createElement("th");
        var thWeeks2 = document.createElement("th");
        var thWeeks3 = document.createElement("th");
        var thMonths = document.createElement("th");
        thMonths.colSpan = 15;
        thWeeks1.colSpan = 5;
        thWeeks2.colSpan = 5;
        thWeeks3.colSpan = 5;
        thWeeks1.innerText = "weeks";
        trMonths.append(thMonths);
        trMonths.setAttribute("id", "monthsTr");
        trWeeks.setAttribute("id", "weeksTr");
        trWeeks.append(thWeeks1);
        trWeeks.append(thWeeks2);
        trWeeks.append(thWeeks3);
        thead.append(trMonths);
        thead.append(trWeeks);
        tbody.setAttribute("id", "tableTbody");
        var sub_activities = data.sub_activities;
        var count = 0;
        sub_activities.forEach((element) => {
            var trPlanned = document.createElement("tr");
            var trActual = document.createElement("tr");
            var tdActual = document.createElement("td");
            var tdPlanned = document.createElement("td");
            if (count == 0) {
                var tdActivities = document.createElement("td");
                var activities = data.activities;
                tdActivities.rowSpan = sub_activities.length * 2;
                activities.forEach((element) => {
                    var p = document.createElement("p");
                    p.innerText = element.title;
                    tdActivities.appendChild(p);
                    tdActivities.colSpan = 5;
                });
                trPlanned.append(tdActivities);
                count++;
            }
            tdPlanned.setAttribute("class", "planned");
            tdActual.setAttribute("class", "planned");
            tdActual.colSpan = 5;
            tdPlanned.colSpan = 5;
            tdActual.innerText = " Actual ";
            tdPlanned.innerText = " Planned ";
            var tdSubActivity = document.createElement("td");
            tdSubActivity.append(element.title);
            tdSubActivity.colSpan = 5;
            tdSubActivity.rowSpan = 2;
            trPlanned.append(tdSubActivity);
            trPlanned.append(tdPlanned);
            trActual.append(tdActual);
            tbody.append(trPlanned);
            tbody.append(trActual);
        });

        var tableContainer = document.querySelector("#table-container");
        tableContainer.innerHTML = "";
        table.append(thead);
        table.append(tbody);
        tableContainer.append(table);
        var startDate = new Date(start);
        var endDate = new Date(end);
        generateTable(startDate, endDate, sub_activities.length);
    });
}

function generateTable(startDate, endDate, SubActivity) {
    var table = document.querySelector("#table");
    var thead = document.querySelector("#tableThead");
    var tbody = document.querySelector("#tableTbody");
    var weeksPerMonth = getWeeksPerMonth(
        startDate.getFullYear(),
        endDate.getFullYear()
    );

    var trMonths = document.querySelector("#monthsTr");
    var trWeeks = document.querySelector("#weeksTr");

    addMonthsToTable();
    function addMonthsToTable() {
        weeksPerMonth.forEach((element) => {
            var th = document.createElement("th");
            var weeks = element.weeks;

            th.colSpan = weeks;
            th.innerText = `${element.month} ${startDate.getFullYear()}`;
            trMonths.append(th);

            for (let index = 1; index <= weeks; index++) {
                var thWeek = document.createElement("th");
                thWeek.setAttribute("id", "thOfweek");
                thWeek.innerText = `W ${index}`;
                trWeeks.append(thWeek);
            }
        });
        var subActivityTrNumber = document.querySelectorAll("td.planned");
        var numberOfthWeek = document.querySelectorAll("#thOfweek");
        subActivityTrNumber.forEach((element) => {
            for (let index = 0; index < numberOfthWeek.length; index++) {
                var tdWeek = document.createElement("td");
                var trSS = element.closest("tr");
                trSS.append(tdWeek);
            }
        });
    }

    thead.append(trMonths);
    thead.append(trWeeks);
    table.append(thead);
    table.append(tbody);
    var tableContainer = document.querySelector("#table-container");
    tableContainer.append(table);
}

function getWeeksPerMonth(startYear, endYear) {
    const weeksPerMonth = [];
    const months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
    ];
    var startDate = new Date(document.querySelector("#start_date").value);
    var endDate = new Date(document.querySelector("#end_date").value);
    for (let year = startYear; year <= endYear; year++) {
        const startMonth = year === startYear ? startDate.getMonth() : 0;
        const endMonth = year === endYear ? endDate.getMonth() : 11;

        for (let i = startMonth; i <= endMonth; i++) {
            const month = months[i];
            const firstDay = new Date(year, i, 1);
            const lastDay = new Date(year, i + 1, 0);
            const daysInMonth = lastDay.getDate() - firstDay.getDate() + 1;
            const firstDayOfWeek = (firstDay.getDay() + 6) % 7;
            const offset = firstDayOfWeek === 0 ? 6 : firstDayOfWeek - 1;
            const weeksInMonth = Math.ceil((daysInMonth + offset) / 7);
            weeksPerMonth.push({
                month,
                weeks: weeksInMonth,
            });
        }
    }
    return weeksPerMonth;
}
