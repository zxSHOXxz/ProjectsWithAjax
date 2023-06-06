@extends('cms.master')

@section('styles')
@endsection


@section('content')
@endsection






@section('scripts')
    <script>
        const year = 2023;

        const calendarTable = document.createElement("table");
        calendarTable.classList.add("calendar");

        const monthRow = document.createElement("tr");
        calendarTable.appendChild(monthRow);

        for (let month = 0; month < 12; month++) {
            const monthCell = document.createElement("th");
            monthCell.textContent = getMonthName(month);
            monthRow.appendChild(monthCell);
        }

        const weeksRow = document.createElement("tr");
        calendarTable.appendChild(weeksRow);

        for (let month = 0; month < 12; month++) {
            const weeksCell = document.createElement("td");
            weeksCell.textContent = getWeeksInMonth(year, month);
            weeksRow.appendChild(weeksCell);
        }

        var content = document.querySelector('.content')
        // إضافة الجدول إلى الصفحة
        content.appendChild(calendarTable);

        function getMonthName(month) {
            const monthNames = [
                "يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر",
                "ديسمبر"
            ];
            return monthNames[month];
        }

        function getWeeksInMonth(year, month) {
            const firstDayOfMonth = new Date(year, month, 1).getDay();
            const lastDayOfMonth = new Date(year, month + 1, 0).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            const numWeeks = Math.ceil((firstDayOfMonth + daysInMonth + (6 - lastDayOfMonth)) / 7);
            return numWeeks;
        }
    </script>
@endsection
