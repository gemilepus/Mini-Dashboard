<!doctype html>
<html lang="en">
<head>
    <style>
        canvas{
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }
        .chart-container {
            width: 450px;
            margin-left: 40px;
            margin-right: 40px;
            margin-bottom: 40px;
        }
        .container {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon" href="https://pytorch.org/favicon.ico?">
    <title>Dashboard</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="dashboard.css" rel="stylesheet">

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/moment.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/bootstrap-datepicker.zh-TW.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap-datepicker3.css" />
    <script src="js/bootstrap-datetimepicker.js"></script>
    <link rel="stylesheet" href="css/bootstrap-datetimepicker-standalone.css" />
    <script src="js/chart.bundle.js"></script>
    <script src="utils.js"></script>
    <script src="js/hammer.min.js"></script>
    <script src="js/chartjs-plugin-zoom-0.6.3.js"></script>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script>
</head>
<body>
<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">ヽ(ﾟДﾟ)ﾉ</a>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="?id=out">Sign out</a>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">

        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">
                            <span data-feather="home"></span>
                            Dashboard
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sub_select.php">
                            <span data-feather="sliders"></span>
                            Select sensor
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logview.php">
                            <span data-feather="file"></span>
                            Logs
                        </a>
                    </li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Setting</span>
                    <a class="d-flex align-items-center text-muted" href="#">
                        <span data-feather="plus-circle"></span>
                    </a>
                </h6>
                <ul class="nav flex-column mb-2">

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            month
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            year
                        </a>
                    </li>

                </ul>
            </div>
        </nav>


        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <button class="btn btn-sm btn-outline-secondary">Save</button>
                        <button class="btn btn-sm btn-outline-secondary">Export</button>
                    </div>

                    <button id=dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                        <span data-feather="calendar"></span>
                        This week

                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>

                    </button>

                </div>
            </div>


            <div class="container grid" data-masonry='{ "itemSelector": ".grid-item", "columnWidth": 200 }'></div>
            <script>
                function createConfig(gridlines, title) {
                    return {
                        type: 'line',
                        data: {
                            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                            datasets: [{
                                label: 'My First dataset',
                                backgroundColor: window.chartColors.red,
                                borderColor: window.chartColors.red,
                                data: [10, 30, 39, 20, 25, 34, 0],
                                fill: false,
                            }, {
                                label: 'My Second dataset',
                                fill: false,
                                backgroundColor: window.chartColors.blue,
                                borderColor: window.chartColors.blue,
                                data: [18, 33, 22, 19, 11, 39, 30],
                            }]
                        },
                        options: {

                            pan: {
                                enabled: true,
                                mode: "x",
                                speed: 10,
                                threshold: 10
                            },
                            zoom: {
                                enabled: true,
                                drag: false,
                                mode: "xy",
                                limits: {
                                    max: 10,
                                    min: 0.5
                                }
                            },
                            responsive: true,
                            title: {
                                display: true,
                                text: title
                            },
                            scales: {
                                xAxes: [{
                                    gridLines: gridlines,
                                    scaleLabel: {
                                        display: true,
                                        labelString: "Month"
                                    },
                                    ticks: {
                                        maxRotation: 0
                                    }
                                }],
                                yAxes: [{
                                    gridLines: gridlines,
                                    ticks: {
                                        min: 0,
                                        max: 100,
                                        stepSize: 10
                                    }
                                }]
                            }
                        }
                    };
                }

                window.onload = function() {
                    var container = document.querySelector('.container');

                    [{
                        title: 'Display',
                        gridLines: {
                            display: true
                        }
                    }, {
                        title: 'Display',
                        gridLines: {
                            display: false
                        }
                    }, {
                        title: 'Display',
                        gridLines: {
                            display: false,
                            drawBorder: false
                        }
                    }, {
                        title: 'Display',
                        gridLines: {
                            display: true,
                            drawBorder: true,
                            drawOnChartArea: false,
                        }
                    }, {
                        title: 'Display',
                        gridLines: {
                            display: true,
                            drawBorder: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                        }
                    }].forEach(function(details) {
                        var div = document.createElement('div');
                        div.classList.add('chart-container');
                        // div.classList.add('grid-item');

                        var canvas = document.createElement('canvas');
                        div.appendChild(canvas);
                        container.appendChild(div);

                        var ctx = canvas.getContext('2d');
                        var config = createConfig(details.gridLines, details.title);
                        new Chart(ctx, config);
                    });
                };
            </script>
            <script src="js/feather.min.js"></script>
            <script>
                feather.replace()
            </script>
</body>
</html>

