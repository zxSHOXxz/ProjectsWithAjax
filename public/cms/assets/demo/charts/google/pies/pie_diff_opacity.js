/* ------------------------------------------------------------------------------
 *
 *  # Google Visualization - diff pie
 *
 *  Google Visualization diff pie chart with transparency demonstration
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var GooglePieDiffOpacity = function() {


    //
    // Setup module components
    //

    // Pie with opacity
    var _googlePieDiffOpacity = function() {
        if (typeof google == 'undefined') {
            console.warn('Warning - Google Charts library is not loaded.');
            return;
        }

        // Switch colors in dark and light themes
        function color_theme(darkColor, lightColor) {
            return document.documentElement.getAttribute('data-color-theme') == 'dark' ? darkColor : lightColor
        }

        // Initialize chart
        google.charts.load('current', {
            callback: function () {

                // Draw chart
                drawPieDiffOpacity();

                // Resize on sidebar width change
                var sidebarToggle = document.querySelectorAll('.sidebar-control');
                if (sidebarToggle) {
                    sidebarToggle.forEach(function(togglers) {
                        togglers.addEventListener('click', drawPieDiffOpacity);
                    });
                }

                // Resize on window resize
                var resizePieDiffOpacity;
                window.addEventListener('resize', function() {
                    clearTimeout(resizePieDiffOpacity);
                    resizePieDiffOpacity = setTimeout(function () {
                        drawPieDiffOpacity();
                    }, 200);
                });

                // Redraw chart when color theme is changed
                document.querySelectorAll('[name="main-theme"]').forEach(function(radio) {
                    radio.addEventListener('change', drawPieDiffOpacity);
                });
            },
            packages: ['corechart']
        });

        // Chart settings
        function drawPieDiffOpacity() {

            // Define charts element
            var pie_diff_opacity_element = document.getElementById('google-pie-diff-opacity');

            // Old data
            var oldData = google.visualization.arrayToDataTable([
                ['Major', 'Degrees'],
                ['Business', 256070], ['Education', 108034],
                ['Social Sciences & History', 127101], ['Health', 81863],
                ['Psychology', 74194]
            ]);

            // New data
            var newData = google.visualization.arrayToDataTable([
                ['Major', 'Degrees'],
                ['Business', 358293], ['Education', 101265],
                ['Social Sciences & History', 172780], ['Health', 129634],
                ['Psychology', 97216]
            ]);

            // Options
            var options = {
                fontName: 'var(--body-font-family)',
                height: 300,
                width: 500,
                backgroundColor: 'transparent',
                pieSliceBorderColor: color_theme('#2c2d32', '#fff'),
                colors: [
                    '#2ec7c9','#b6a2de','#5ab1ef','#ffb980',
                    '#d87a80','#8d98b3','#e5cf0d','#97b552'
                ],
                legend: {
                    textStyle: {
                        color: color_theme('#fff', '#333')
                    }
                },
                chartArea: {
                    left: 50,
                    width: '90%',
                    height: '90%'
                },
                diff: {
                    oldData: {
                        opacity: 0.8
                    }
                }
            };

            // Attach chart to the DOM element
            var chartRadius = new google.visualization.PieChart(pie_diff_opacity_element);

            // Set data
            var diffData = chartRadius.computeDiff(oldData, newData);

            // Draw our chart, passing in some options
            chartRadius.draw(diffData, options);
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _googlePieDiffOpacity();
        }
    }
}();


// Initialize module
// ------------------------------

GooglePieDiffOpacity.init();