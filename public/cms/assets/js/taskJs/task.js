const { forEach } = require("lodash");

function getClender(id) {
    $.get('/getClender/' + id, function (data) {
        console.log(data.sub_activities);
        var table = document.createElement("table");
        var thead = document.createElement("thead");
        var tbody = document.createElement("tbody");
        thead.setAttribute("id", 'tableThead');
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
        trWeeks.append(thWeeks1);
        trWeeks.append(thWeeks2);
        trWeeks.append(thWeeks3);
        thead.append(trMonths);
        thead.append(trWeeks);
        tbody.setAttribute("id", "tableTbody");





        var tableContainer = document.querySelector("#table-container");
        tableContainer.innerHTML = "";
        table.append(thead);
        table.append(tbody);
        tableContainer.append(table);
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
                thWeek.setAttribute("id", 'thOfweek');
                thWeek.innerText = `W ${index}`;
                trWeeks.append(thWeek);
            }
        });

        var numberOfthWeek = document.querySelectorAll('#thOfweek');

        subActivityTrNumber.forEach(element => {
            for (let index = 0; index < numberOfthWeek.length; index++) {
                var tdWeek = document.createElement("td");
                var trSS = element.closest('tr');
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
