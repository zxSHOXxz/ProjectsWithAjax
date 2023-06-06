activity = ["act1", "act2", "act3"];

function generateTable(startDate, endDate, SubActivity) {
    var table = document.createElement("table");
    var thead = document.createElement("thead");
    var tbody = document.createElement("tbody");
    var weeksPerMonth = getWeeksPerMonth(
        startDate.getFullYear(),
        endDate.getFullYear()
    );
    var trMonths = document.createElement("tr");
    var trWeeks = document.createElement("tr");

    addMonthsToTable();
    function addMonthsToTable() {
        var thEmpty = document.createElement("th");
        var thWeeksWorld = document.createElement("th");
        thEmpty.colSpan = 12;
        thWeeksWorld.colSpan = 12;
        thWeeksWorld.innerText = "weeks";
        thWeeksWorld.width = "500px";
        trMonths.append(thEmpty);
        trWeeks.append(thWeeksWorld);

        weeksPerMonth.forEach((element) => {
            var th = document.createElement("th");
            var weeks = element.weeks;

            th.colSpan = weeks;
            th.innerText = `${element.month}`;
            trMonths.append(th);

            for (let index = 1; index <= weeks; index++) {
                var thWeek = document.createElement("th");
                thWeek.innerText = `W ${index}`;
                trWeeks.append(thWeek);
            }
        });
    }

    for (let i = 1; i <= SubActivity * 2; i++) {
        var trSubActivity = document.createElement("tr");
        var activityTh = document.createElement("th");
        activityTh.colSpan = 12;

        trSubActivity.append(activityTh);
        weeksPerMonth.forEach((element) => {
            var weeks = element.weeks;
            for (let index = 1; index <= weeks; index++) {
                var tdWeek = document.createElement("td");
                trSubActivity.append(tdWeek);
            }
        });
        tbody.append(trSubActivity);
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
            const firstDayOfWeek = (firstDay.getDay() + 6) % 7; // تحويل الأحد إلى القيمة 6 بدلاً من 0
            const offset = firstDayOfWeek === 0 ? 6 : firstDayOfWeek - 1; // التعويض عن تأخير بداية الأسبوع في حال بداية الأسبوع من السبت
            const weeksInMonth = Math.ceil((daysInMonth + offset) / 7);
            weeksPerMonth.push({
                month,
                weeks: weeksInMonth,
            });
        }
    }
    return weeksPerMonth;
}

// استدعاء الدالة وتمرير تواريخ البداية والنهاية المرغوبة
var startDate = new Date("2023-01-01");
var endDate = new Date(); // التاريخ الحالي
generateTable(startDate, endDate, 1);
