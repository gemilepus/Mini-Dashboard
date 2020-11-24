<!doctype html>
<html lang="en">
<head>
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
    <script src="js/chart.bundle.js"></script>
    <script src="utils.js"></script>
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
            <script>
                $('#datepicker').datepicker({
                    language: "zh-TW",
                    format: 'yyyy/mm/dd',
                    defaultDate:new Date(),
                    autoclose: true,
                    todayHighlight: true
                });
            </script>
            <script>
                $('#datepicker2').datepicker({
                    language: "zh-TW",
                    format: 'yyyy/mm/dd',
                    defaultDate:new Date(),
                    autoclose: true,
                    todayHighlight: true
                });
            </script>


            <div class="alert alert-danger alert-dismissible fade show " role="alert" id="bs4-alert" style="display:none;position:fixed; top: 60px; left: 300px;z-index:9999; border-radius:0px; padding: 20px;width:70%;">
                <strong>!</strong> test
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="input-group mb-3">
                <div id="datepicker" class="input-group date" data-provide="datepicker" style="width:12%;">
                    <input type="text" class="form-control">
                    <div class="input-group-addon">
                        <!--                         <span data-feather="arrow-right"></span>-->
                    </div>
                </div>

                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm"><span data-feather="arrow-right"></span></span>
                </div>

                <div id="datepicker2" class="input-group date" data-provide="datepicker" style="width:12%;">
                    <input type="text" class="form-control">
                    <span class="input-group-addon">
<!--                            <span data-feather="arrow-right"></span>-->
                        </span>
                </div>

                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="Button-Search">Search <span data-feather="search"></span></button>
                </div>

                <script>
                    document.getElementById('Button-Search').addEventListener('click', function() {

                    });
                </script>

                <div style="width:50%;"></div>




                <div class="input-group-append">
                    <button class="btn btn-outline-secondary " type="button" id="Button-type">Line</button>
                </div>
                <script>
                    var type_flag = "line";
                    document.getElementById('Button-type').addEventListener('click', function() {
                        if( type_flag == "line" ){
                            type_flag = "bar";
                            this.innerHTML = "Bar";
                        }else{
                            type_flag = "line";
                            this.innerHTML = "Line";
                        }
                        config.data.datasets.forEach(function(dataset) {
                            dataset.type = type_flag;

                        });

                        window.myLine.update();
                    });
                </script>


            </div>
            <div class="input-group mb-3">
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
                </tbody>
            </table>

            <script src="js/feather.min.js"></script>
</body>
</html>
