<?php
require 'vendor/autoload.php';
use SebastianBergmann\Timer\Timer;
Timer::start();

session_start(); // start Session

if(isset($_GET["logout"]) && ($_GET["logout"]=="true")){
    unset($_SESSION['user_id'] );
    header("Location: login.php");
}

if ( isset( $_SESSION['user_id'] ) ) {
//          header("Location: index.php");
} else {
    header("Location: login.php");
}
?>
<!doctype html>
<html lang="en">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="icon" type="image/x-icon" href="https://pytorch.org/favicon.ico?">
      <title>Dashboard</title>

      <script src="js/jquery-3.3.1.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/popper.min.js"></script>
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="dashboard.min.css" rel="stylesheet">
      <link href="css/glyphicons.min.css" rel="stylesheet">

      <script src="js/moment.min.js"></script>
      <script src="js/moment-range.js"></script>
      <script src="js/bootstrap-datepicker.min.js"></script>
      <script src="js/bootstrap-datepicker.zh-TW.min.js"></script>
      <link rel="stylesheet" href="css/bootstrap-datepicker3.min.css" />
      <script src="js/bootstrap-datetimepicker.min.js"></script>
      <link rel="stylesheet" href="css/bootstrap-datetimepicker-standalone.min.css" />
      <link rel="stylesheet" href="css/notifications.min.css">
      <script src="js/notifications.js"></script>
      <script src="js/chart.bundle.min.js"></script>
      <script src="js/hammer.min.js"></script>
      <script src="utils.min.js"></script>
      <script src="js/chartjs-plugin-zoom.min.js"></script>
      <script src="js/chartjs-plugin-annotation.min.js"></script>
      <script src="https://d3js.org/d3.v3.min.js"></script>
      <script src="liquidFillGauge.min.js" language="JavaScript"></script>
      <style>
          .liquidFillGaugeText { font-family: Helvetica; font-weight: bold; }
      </style>
  </head>
  <body>
  <?php
  use Monolog\Logger;
  use Monolog\Handler\StreamHandler;

  // create a log channel
  $log = new Logger('name');
  // path & log level
  $log->pushHandler(new StreamHandler('m.log', Logger::INFO));

  function getUserIP()
  {
      $client  = @$_SERVER['HTTP_CLIENT_IP'];
      $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
      $remote  = $_SERVER['REMOTE_ADDR'];

      if(filter_var($client, FILTER_VALIDATE_IP)) {
          $ip = $client;
      }
      elseif(filter_var($forward, FILTER_VALIDATE_IP)) {
          $ip = $forward;
      }
      else {
          $ip = $remote;
      }
      return $ip;
  }

  $user_ip = getUserIP();

  // add records to the log
  $log->addInfo($user_ip);
  ?>
  <script>
      window.createNotification({
          // close on click
          closeOnClick: true,
          // displays close button
          displayCloseButton: true,
          positionClass: 'nfc-bottom-right',
          // callback
          onclick: false,
          // timeout in milliseconds
          showDuration:<?php
          if(isset($_SESSION['search'])){
              echo 3000;
          }else{
              echo 1;
          }
          ?>
          ,
          // success, info, warning, error, and none
          theme: 'success'
      })({
          title: "Session",
          message: "<?php
              if(isset($_SESSION['search'])){
                  echo $_SESSION['search'];
              }else{
                  echo("null");
              }
              unset($_SESSION['search']);
//              session_destroy(); // remove session
              ?>"
      });
  </script>

    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">ヽ(ﾟДﾟ)ﾉ</a>
      <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="?logout=true">Sign out</a>
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

                <p id="textview_log"></p>

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

            <!--alert-->
            <div id="bs4-alert" class="alert alert-danger alert-dismissible fade show" role="alert"  style="display:none;position:fixed; top: 60px; left: 300px;z-index:9999; border-radius:0px; padding: 20px;width:70%;">
                <strong id="bs4-alert-msg">Aww yeah, you successfully read this important alert message</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <script>
            </script>

            <div class="input-group mb-3">

                <div id="datepicker" class="input-group date" data-provide="datepicker" style="width:12%;">
                    <input id="datestart" type="text" class="form-control" >
                    <div class="input-group-addon">
                    </div>
                </div>
                <script>
                    $('#datepicker').datepicker({
                        language: "zh-TW",
                        format: 'yyyy/mm/dd',
                        autoclose: true,
                        todayHighlight: true
                    });
                    document.getElementById("datestart").value = moment().add(-7, 'days').format('YYYY/MM/DD') ;
                </script>

                <div class='input-group date' id='datetimepicker3' style="width:12%;">
                    <input id="hour-start" type='text' class="input-group-append form-control" />
                    <div class="input-group-append">
                        <span class="input-group-text"> <span data-feather="clock"></span></span>
                    </div>
                </div>
                <script type="text/javascript">
                    $('#datetimepicker3').datetimepicker({
                        format: 'HH:mm'
                    });
                    document.getElementById("hour-start").value = "00:00";
                </script>

                <!--   Icon      -->
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm"><span data-feather="arrow-right"></span></span>
                </div>

                <div id="datepicker2" class="input-group date" data-provide="datepicker" style="width:12%;">
                    <input id="dateend" type="text" class="form-control">
                    <span class="input-group-addon"></span>
                </div>
                <script>
                    $('#datepicker2').datepicker({
                        language: "zh-TW",
                        format: 'yyyy/mm/dd',
                        autoclose: true,
                        todayHighlight: true
                    });
                    document.getElementById("dateend").value = moment().add(1, 'days').format('YYYY/MM/DD') ;
                </script>

                <div class='input-group date' id='datetimepicker4' style="width:12%;">
                    <input id="hour-end" type='text' class="input-group-append form-control" />
                    <div class="input-group-append">
                        <span class="input-group-text"> <span data-feather="clock"></span></span>
                    </div>
                </div>
                <script type="text/javascript">
                    $('#datetimepicker4').datetimepicker({
                        format: 'HH:mm'
                    });
                    document.getElementById("hour-end").value = "00:00";
                </script>

                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="Button-Search">Search <span data-feather="search"></span></button>
                </div>

                <script>
                    var check_no;
                $('#Button-Search').on('click', function (e) {
                    check_no = Math.random();
                    window['moment-range'].extendMoment(moment);
                    var starte =  document.getElementById("datestart").value;
                    var ende   =  document.getElementById("dateend").value;
                    var range = moment.range(starte, ende);
                    if( range.diff() < 0) {
                        document.getElementById("model-msg").innerHTML = '時間範圍設定錯誤';
                        $('#msgModal').modal('show');
                        return;
                    }

                    clearInterval(m_Running_Handle);
                    window.myLine.resetZoom();
                    config.data.labels = [];
                    config.data.datasets = [];
                    window.myLine.update();

                    if(sensor_id_list.length === 0){
                        document.getElementById("model-msg").innerHTML = '沒有選擇任何 Tag';
                        $('#msgModal').modal('show');
                        return;
                    }

                    var k = 0;
                    while (k <= sensor_id_list.length -1) {
                        var url_str = "MSSQL_get_Temp2.php";
                        url_str += "?start=" + document.getElementById("datestart").value ;
                        url_str += "&end=" + document.getElementById("dateend").value ;
                        url_str += "&sensor=" + sensor_id_list[k] ;
                        let sensor_str = sensor_name_list[k]; // note
                        let check_key = check_no;
                        $.ajax({
                            type: "POST",
                            url:  url_str ,
                            dataType: "json",
                            success: function(JSONObject) {
                                if(check_key!==check_no){
                                    return;
                                }

                                var colorName = colorNames[config.data.datasets.length % colorNames.length];
                                var newColor = window.chartColors[colorName];
                                var newDataset = {
                                    label:  sensor_str,
                                    pointRadius: 2.5, // point
                                    borderWidth: 0.5 ,// and not lineWidth
                                    backgroundColor: newColor,
                                    borderColor: newColor,
                                    data: [],
                                    fill: false,
                                    lineTension: 0.01, // don't smooth line
                                };
                                // Loop through Object and create peopleHTML
                                for (var key in JSONObject) {
                                    if (JSONObject.hasOwnProperty(key)) {
                                        newDataset.data.push({
                                            t: JSONObject[key]["time"],
                                            y: JSONObject[key]["value"]
                                        });
                                    }
                                }
                                config.data.datasets.push(newDataset);
                                window.myLine.update();
                            }
                        });
                        k++;
                    }

                    window.createNotification({
                        // close on click
                        closeOnClick: true,
                        // displays close button
                        displayCloseButton: true,
                        positionClass: 'nfc-bottom-right',
                        // callback
                        onclick: false,
                        // timeout in milliseconds
                        showDuration: 3000,
                        // success, info, warning, error, and none
                        theme: 'none'
                    })({
                        title: "Searching",
                        message: ""
                    });
                });
                </script>

                <script>
                    document.getElementById('Button-Search2').addEventListener('click', function() {
                        clearInterval(m_Running_Handle);
                        window.myLine.resetZoom();

                        var url_str = "ajax_data_get.php";
                        url_str += "?start=" + document.getElementById("datestart").value ;
                        url_str += "&end=" + document.getElementById("dateend").value ;

                        config.data.labels = [];
                        config.data.datasets[0].data = [];

                        $.ajax({
                            type: "POST",
                            // data: {
                            //     "gender": $("#gender").val()
                            // },
                            //url: "ajax_data_get.php",
                            url:  url_str ,
                            dataType: "json",
                            success: function(JSONObject) {
                                document.getElementById("textview_start").innerHTML = JSONObject[0]["time"].toString();
                                document.getElementById("textview_end").innerHTML = JSONObject[JSONObject.length - 1]["time"].toString();

                                var peopleHTML = "";
                                // Loop through Object and create peopleHTML
                                for (var key in JSONObject) {
                                    if (JSONObject.hasOwnProperty(key)) {
                                        config.data.datasets[0].data.push({
                                            t: JSONObject[key]["time"],
                                            y: JSONObject[key]["value"]
                                        });
                                    }
                                }
                                window.myLine.update();
                            }
                        });
                    });
                </script>

                <div style="width:5%;"></div>

                <div class="input-group-append">
                    <button class="btn btn-outline-secondary rounded-circle" type="button" id="Button-Pause"><span data-feather="pause" style="padding-bottom: 3px"></span></button>
                </div>
                <script>
                    var run_timer_flag = true;
                    document.getElementById('Button-Pause').addEventListener('click', function() {
                        if(run_timer_flag){
                            clearInterval(m_Running_Handle);
                            this.innerHTML = "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" " +
                                "stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"feather feather-play\" style=\"padding-bottom: 3px\"><polygon points=\"5 3 19 12 5 21 5 3\"></polygon></svg>"
                            run_timer_flag  = false;
                        }else{
                            m_Running_Handle = setInterval(m_Running, 1000);
                            this.innerHTML = "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" " +
                                "stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"feather feather-pause\" style=\"padding-bottom: 3px\"><rect x=\"6\" y=\"4\" width=\"4\" height=\"16\">" +
                                "</rect><rect x=\"14\" y=\"4\" width=\"4\" height=\"16\"></rect></svg>";
                            run_timer_flag  = true;
                        }
                    });
                </script>

                <div class="input-group-append">
                    <button class="btn btn-outline-secondary " type="button" id="Button-width">width : 0.5</button>
                </div>
                <script>
                    var width_flag = 0.5;
                    document.getElementById('Button-width').addEventListener('click', function() {
                        width_flag += 0.5;
                        if( width_flag > 3 ){
                            width_flag = 0.5;
                        }
                        this.innerHTML = "width : " + width_flag.toString();
                        config.data.datasets.forEach(function(dataset) {
                            dataset.borderWidth = width_flag;
                            //borderWidth: 1 ,// and not lineWidth
                        });
                        window.myLine.update();
                    });
                </script>

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
                        config.type = type_flag;
                        window.myLine.update();
                    });
                </script>

                <div class="input-group-append">
                    <button class="btn btn-outline-secondary " type="button" id="Button-time">second</button>
                </div>
                <script>
                    var time_flag = "second";
                    document.getElementById('Button-time').addEventListener('click', function() {
                        config.options.scales.xAxes.time.unit = 'hour';
                        window.myLine.update();
                    });
                </script>


                <div class="input-group-append">
                    <button class="btn btn-outline-secondary " type="button" id="Button-Reset">Reset Zoom</button>
                </div>
                <script>
                    var time_flag = "second";
                    document.getElementById('Button-Reset').addEventListener('click', function() {
                        window.myLine.resetZoom();

                    });
                </script>

                <div class="input-group-append">
                    <button class="btn btn-outline-secondary " type="button" id="Button-test"></button>
                </div>

            </div>

            <script>
                document.getElementById('Button-test2').addEventListener('click', function() {
                    clearInterval(m_Running_Handle);
                    window.myLine.resetZoom();

                    var url_str = "ajax_data_get.php";
                    url_str += "?start=" + localStorage.getItem("js_value_zoom_time_label_min") ;
                    url_str += "&end=" + localStorage.getItem("js_value_zoom_time_label_max") ;

                    config.data.labels = [];
                    config.data.datasets[0].data = [];

                    var time_label_min = localStorage.getItem("js_value_zoom_time_label_min");
                    var date_min = new Date(time_label_min);

                    var time_label_max = localStorage.getItem("js_value_zoom_time_label_max");
                    var date_max = new Date(time_label_max);

                    config.data.labels.push(date_min);

                    $.ajax({
                        type: "POST",
                        // data: {
                        //     "gender": $("#gender").val()
                        // },
                        //url: "ajax_data_get.php",
                        url:  url_str ,
                        dataType: "json",
                        success: function(JSONObject) {
                            document.getElementById("textview_start").innerHTML = JSONObject[0]["time"].toString();
                            document.getElementById("textview_end").innerHTML = JSONObject[JSONObject.length - 1]["time"].toString();

                            var peopleHTML = "";

                            // Loop through Object and create peopleHTML
                            for (var key in JSONObject) {
                                if (JSONObject.hasOwnProperty(key)) {
                                   config.data.labels.push( JSONObject[key]["time"] );

                                    config.data.datasets[0].data.push({
                                        t: JSONObject[key]["time"],
                                        y: JSONObject[key]["value"]
                                    });
                                }
                            }

                            config.data.labels.push(date_max); // ++
                            window.myLine.update();
                        }
                    });
                    window.myLine.resetZoom();
                });

            </script>

            <script>
                var run_flag = 0;
                // var m_Running_Handle2 = setInterval(m_Running3, 500);

                var now_date_min = new Date(localStorage.getItem("js_value_zoom_time_label_min"));
                var now_date_max = new Date(localStorage.getItem("js_value_zoom_time_label_max"));
                var old_date_min = new Date(localStorage.getItem("js_value_zoom_time_label_min"));
                var old_date_max = new Date(localStorage.getItem("js_value_zoom_time_label_max"));

                function m_Running3() {

                    now_date_min = new Date(localStorage.getItem("js_value_zoom_time_label_min"));
                    now_date_max = new Date(localStorage.getItem("js_value_zoom_time_label_max"));
                    if( old_date_min != null && run_flag != 1){
                        if( old_date_min.toString() !== now_date_min.toString()){
                            runtime_search();
                        }
                        old_date_min = now_date_min;
                        old_date_max = now_date_max;
                    }else{

                    }

                    var x = localStorage.getItem("js_value_zoom_time_label");
                    document.getElementById("Button-test2").innerHTML = x.toString();
                    var time_label_min = localStorage.getItem("js_value_zoom_time_label_min");
                    var date_min = new Date(time_label_min);
                }
                function runtime_search() {
                    // document.getElementById("textview_do").innerHTML = "Loading...";// hide
                    run_flag = 1;
                    gauge1.update(0);
                    clearInterval(m_Running_Handle);

                    var url_str = "ajax_data_get.php";
                    url_str += "?start=" + localStorage.getItem("js_value_zoom_time_label_min") ;
                    url_str += "&end=" + localStorage.getItem("js_value_zoom_time_label_max") ;

                    var time_label_min = localStorage.getItem("js_value_zoom_time_label_min");
                    var date_min = new Date(time_label_min);

                    var time_label_max = localStorage.getItem("js_value_zoom_time_label_max");
                    var date_max = new Date(time_label_max);


                    $.ajax({
                        type: "POST",
                        url:  url_str ,
                        dataType: "json",
                        success: function(JSONObject) {
                            config.data.labels = [];
                            config.data.datasets[0].data = [];
                            config.data.labels.push(date_min);
                            try{
                                JSONObject[0]["time"].toString();
                            }catch (e) {
                                document.getElementById("bs4-alert-msg").innerHTML = 'Warning; response length = 0';
                                document.getElementById("bs4-alert").className  = "alert alert-warning";
                                $('#bs4-alert').show();
                                var auto_close_Running_Handle = setInterval(auto_close_Running, 3000);
                                //TODO: remove timer when close-button onclick
                                function auto_close_Running() {
                                    $('#bs4-alert').hide();
                                    clearInterval(auto_close_Running_Handle);

                                }

                                window.createNotification({
                                    // close on click
                                    closeOnClick: true,
                                    // displays close button
                                    displayCloseButton: true,
                                    positionClass: 'nfc-bottom-right',
                                    // callback
                                    onclick: false,
                                    // timeout in milliseconds
                                    showDuration: 3000,
                                    // success, info, warning, error, and none
                                    theme: 'none'
                                })({
                                    title: "Warning",
                                    message: "response length = 0"
                                });

                                gauge1.update(100);
                                run_flag = 0;

                                return;
                            }
                            document.getElementById("textview_start").innerHTML = JSONObject[0]["time"].toString();
                            document.getElementById("textview_end").innerHTML = JSONObject[JSONObject.length - 1]["time"].toString();

                            // Loop through Object
                            for (var key in JSONObject) {
                                if (JSONObject.hasOwnProperty(key)) {
                                    config.data.labels.push( JSONObject[key]["time"] );
                                    config.data.datasets[0].data.push({
                                        t: JSONObject[key]["time"],
                                        y: JSONObject[key]["value"]
                                    });
                                }
                            }

                            config.data.labels.push(date_max); // ++
                            window.myLine.update();

                            gauge1.update(100);
                            run_flag = 0;
                        },
                        error: function (jqXHR, exception) {
                            var msg = '';
                            if (jqXHR.status === 0) {
                                msg = 'Not connect.\n Verify Network.';
                            } else if (jqXHR.status == 404) {
                                msg = 'Requested page not found. [404]';
                            } else if (jqXHR.status == 500) {
                                msg = 'Internal Server Error [500].';
                            } else if (exception === 'parsererror') {
                                msg = 'Requested JSON parse failed.';
                            } else if (exception === 'timeout') {
                                msg = 'Time out error.';
                            } else if (exception === 'abort') {
                                msg = 'Ajax request aborted.';
                            } else {
                                msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            }

                            document.getElementById("model-msg").innerHTML = 'Error; '+ msg.toString();
                            $('#msgModal').modal('show');
                        }
                    });
                }
            </script>

            <!-- Error Msg Modal -->
            <div class="modal fade" id="msgModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">msg</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div id="model-msg" class="modal-body">

                        </div>
                        <div class="modal-footer">
                            <button id="model-close-btn" type="button" class="btn btn-primary">close</button>
                            <script>
                                document.getElementById('model-close-btn').addEventListener('click', function() {
                                    $('#msgModal').modal('hide');
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                var m_Running_Handle4 = setInterval(m_Running4, 100);
                function m_Running4() {
                    var str = localStorage.getItem("test_value");
                    document.getElementById("Button-test3").innerHTML = str.toString();
                }
            </script>

            <p id="textview_do"></p>

            <div style="width:90%;">
                <canvas id="ctx" class="card"></canvas>
                <script>
                    window.myLine = new Chart(ctx);
                </script>
            </div>
            <style>
                .card {
                    box-shadow: 0 0 6px rgba(0, 0, 0, 0.2);
                    border-radius: 10px;
                    padding-bottom: 3%;
                    padding-left: 2%;
                    padding-right: 0.5%;
                }
            </style>

            <svg id="fillgauge1" width="5%" height="15%" onclick="gauge1.update(NewValue());"></svg>
            <script language="JavaScript">

                var gauge1 = loadLiquidFillGauge("fillgauge1", 55);
                var config1 = liquidFillGaugeDefaultSettings();
                config1.circleColor = "#FF7777";
                config1.textColor = "#FF4444";
                config1.waveTextColor = "#FFAAAA";
                config1.waveColor = "#FFDDDD";
                config2.circleThickness = 0.1;
                config2.circleFillGap = 0.2;
                config2.textVertPosition = 0.8;
                config2.waveAnimateTime = 100;
                config2.waveHeight = 0.5;
                config2.waveCount = 1;

                var gauge6 = loadLiquidFillGauge("fillgauge6", 120, config5);
                function NewValue(){
                    if(Math.random() > .5){
                        return Math.round(Math.random()*100);
                    } else {
                        return (Math.random()*100).toFixed(1);
                    }
                }
            </script>

            <div class="input-group mb-3">
                <p id="textview_start" style="width:12.5%;"></p>
                <div style="width:75%;"></div>
                <p id="textview_end" style="width:12.5%;"></p>
            </div>

            <button  class="btn btn-sm btn-outline-secondary" id="randomizeData">Randomize Data</button>
            <button  class="btn btn-sm btn-outline-secondary" id="addDataset">Add Dataset</button>
            <button  class="btn btn-sm btn-outline-secondary" id="removeDataset">Remove Dataset</button>
            <button  class="btn btn-sm btn-outline-secondary" id="addData">Add Data</button>
            <button  class="btn btn-sm btn-outline-secondary" id="removeData">Remove Data</button>

            <?php
            include("connMysqlObj.php");
            $seldb = @mysqli_select_db($db_link, "pydata");
            $sql_query = "SELECT COUNT(*) FROM data2 ";
            $result = mysqli_query($db_link, $sql_query);
            while($row_result=mysqli_fetch_assoc($result)){
                $total_records = $row_result['COUNT(*)'];
            }
            $sql_query = "SELECT * FROM data2 ";
            $sql_query_limit = $sql_query." LIMIT ".($total_records - 200).", ".$total_records;
            print_r( $sql_query_limit);
            $result = mysqli_query($db_link, $sql_query_limit);
            print_r( $result);
            ?>

            <script>
                var config = {
                    type: 'LineWithLine', // original 'Line' , use 'LineWithLine' to draw multi line (onTouch draw x bar)
                    data: {
                        labels: [
                            <?php
                            $num = 0;
                            while($row_result = mysqli_fetch_assoc($result)){
                                echo "'";
                                echo $row_result['time'] ;
                                echo "'";
                                echo ",";
                                $num ++;
                            }
                            ?>
                        ],
                        datasets: [{
                            label: 'Sensor one',
                            pointRadius: 2.5, // point
                            borderWidth: 0.5 ,// and not lineWidth
                            backgroundColor: window.chartColors.red,
                            borderColor: window.chartColors.red,
                            fill: false,
                            lineTension: 0.01, // don't smooth line
                            data: [
                                // {t: "2018-12-20 12:15:13" ,y: 50},
                                // {t: "2018-12-20 12:12:17" ,y: 50}

                                <?php
                                $sql_query = "SELECT * FROM data2 ";
                                $result = mysqli_query($db_link, $sql_query);

                                $total_records = mysqli_num_rows($result);

                                $sql_query_limit = $sql_query." LIMIT ".($total_records - 200).", ".$total_records;

                                $result = mysqli_query($db_link, $sql_query_limit);

                                while($row_result = mysqli_fetch_assoc($result)){
                                    echo "{x:\"";
                                    echo $row_result['time'] ;
                                    echo "\",";
                                    echo "y:";
                                    echo $row_result['value'] ;
                                    echo "},";
                                }
                                $db_link->close();
                                ?>
                            ]
                        }
                        ]
                    },
                    options: {
                        responsive: true,
                        annotation: {
                            events: ["click"],
                            annotations: [
                                {
                                {
                                    drawTime: "afterDatasetsDraw",
                                    id: "hline",
                                    type: "line",
                                    mode: "horizontal",
                                    scaleID: "y-axis-0",
                                    value: 80,
                                    borderColor: "black",
                                    borderWidth: 1,
                                    label: {
                                        // Anchor position of label on line, can be one of: top, bottom, left, right, center. Default below.
                                        position: "left",
                                        // Adjustment along x-axis (left-right) of label relative to above number (can be negative)
                                        // For horizontal lines positioned left or right, negative values move
                                        // the label toward the edge, and positive values toward the center.
                                        xAdjust: 10,
                                        // Adjustment along y-axis (top-bottom) of label relative to above number (can be negative)
                                        // For vertical lines positioned top or bottom, negative values move
                                        // the label toward the edge, and positive values toward the center.
                                        yAdjust: 0,

                                        backgroundColor: "red",
                                        content: "80",
                                        enabled: true
                                    }

                                }
                            ]
                        },
                        animation: {
                            duration: 0
                        },
                        // Container for pan options
                        pan: {
                            enabled: true,
                            mode: "x",
                            speed: 10,
                            threshold: 10
                        },
                        // // Container for zoom options
                        zoom: {
                            enabled: true,
                            drag: false,
                            mode: "x",
                            limits: {
                                max: 10,
                                min: 0.5
                            }
                        },
                        title: {
                            display: true,
                            text: 'Chart'
                        },
                        tooltips: {
                            // mode: 'nearest',
                            mode: 'mx',
                            intersect: false,
                            callbacks: {
                                label: function(tooltipItems, data) {
                                    return tooltipItems.yLabel + '°C';
                                }
                            }
                        },
                        hover: {
                            mode: 'x',
                            // mode: 'nearest',
                            intersect: false
                        },

                        scales: {
                            xAxes: [{
                                type: 'time',
                                time: {
                                    // min : new Date(),
                                    unit: 'second',
                                    displayFormats: {
                                        second: 'YYYY/MM/DD HH:mm:ss'
                                    }
                                },
                                ticks: {

                                    autoSkip: true,
                                    maxTicksLimit: 9,
                                    maxRotation: 0,
                                    minRotation: 0
                                }
                            }],
                            yAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Value'
                                },
                                ticks: {
                                    min: 0,
                                    max: 100,
                                    stepSize: 5
                                },
                                gridLines: {
                                    drawBorder: false
                                }
                            }]
                        }
                    }
                };
                window.onload = function() {
                    window.myLine = new Chart(ctx, config);
                };

                Chart.defaults.LineWithLine = Chart.defaults.line;
                Chart.controllers.LineWithLine = Chart.controllers.line.extend({
                    draw: function(ease) {
                        Chart.controllers.line.prototype.draw.call(this, ease);
                        if (this.chart.tooltip._active && this.chart.tooltip._active.length) {
                            var activePoint = this.chart.tooltip._active[0],
                                ctx = this.chart.ctx,
                                x = activePoint.tooltipPosition().x,
                                topY = this.chart.scales['y-axis-0'].top,
                                bottomY = this.chart.scales['y-axis-0'].bottom;

                            // draw line
                            // ctx.save();
                            try{
                                ctx.beginPath();
                                ctx.moveTo(x, topY);
                                ctx.lineTo(x, bottomY);
                                ctx.lineWidth = 1;
                                ctx.strokeStyle = '#ff8085';
                                ctx.stroke();

                                ctx.restore();
                            }catch (e) {

                            }
                        }
                    }
                });

                document.getElementById('randomizeData').addEventListener('click', function() {
                    config.data.datasets.forEach(function(dataset) {
                        dataset.data = dataset.data.map(function() {
                            return randomScalingFactor();
                        });
                    });
                    window.myLine.update();
                });

                var colorNames = Object.keys(window.chartColors);
                document.getElementById('addDataset').addEventListener('click', function() {
                    var colorName = colorNames[config.data.datasets.length % colorNames.length];
                    var newColor = window.chartColors[colorName];
                    var newDataset = {
                        borderWidth: 0.5 ,// and not lineWidth
                        pointRadius: 0, // point
                        label: 'Dataset ' + config.data.datasets.length,
                        backgroundColor: newColor,
                        borderColor: newColor,
                        data: [],
                        fill: false,
                        lineTension: 0.03, // don't smooth line
                    };

                    for (var index = 0; index < config.data.labels.length; ++index) {
                        newDataset.data.push(randomScalingFactor());
                    }

                    config.data.datasets.push(newDataset);
                    window.myLine.update();
                });

                document.getElementById('addData').addEventListener('click', function() {
                    if (config.data.datasets.length > 0) {
                        var month = MONTHS[config.data.labels.length % MONTHS.length];
                        config.data.labels.push(month);
                        var i = 0;
                        config.data.datasets.forEach(function(dataset) {
                            if(i==0){
                                $.getJSON('ajax_getdata.php', function(data) {
                                    // set the html content of the id myThing to the value contained in data
                                    dataset.data.push( data.value );
                                });
                              //  dataset.data.push(99);
                            }else{
                               // dataset.data.push(randomScalingFactor());
                            }
                            i++
                        });

                        window.myLine.update();
                    }
                });

                document.getElementById('removeDataset').addEventListener('click', function() {
                    config.data.datasets.splice(0, 1);
                    window.myLine.update();
                });

                document.getElementById('removeData').addEventListener('click', function() {
                    config.data.labels.splice(-1, 1); // remove the label first

                    config.data.datasets.forEach(function(dataset) {
                        dataset.data.pop();
                    });
                    window.myLine.update();
                });

                var step_num = 0;
                var m_Running_Handle = setInterval(m_Running, 1000);
                function m_Running() {
                    step_num ++;
                    $.getJSON('ajax_data.php', function(data) {
                        // set the html content of the id myThing to the value contained in data
                       config.data.labels.push(data.time);
                        //config.data.datasets[0].data.push( data.value );
                        config.data.datasets[0].data.push({
                            t: data.time,
                            y: data.value,
                        });
                    });

                    var i = 0;
                    config.data.datasets.forEach(function(dataset) {
                        if(i===0){
                            //  dataset.data.push(99);
                        }else{
                             dataset.data.push(randomScalingFactor());
                        }
                        i++
                    });

                    if( config.data.labels.length > 200){
                        config.data.datasets.forEach(function(dataset) {
                           dataset.data.shift();
                        });
                        config.data.labels.shift();
                    }

                    document.getElementById("textview_start").innerHTML = config.data.labels[0].toString();
                    document.getElementById("textview_end").innerHTML = config.data.labels[config.data.labels.length - 1].toString();
                    window.myLine.update();

                    var d = new Date();
                    // document.getElementById("textview_time").innerHTML = d.getFullYear() + "-" + d.getMonth() + "-" + d.getDate();
                    document.getElementById("textview_time").innerHTML = d.toLocaleTimeString() + " step " + step_num;
                }

                $(window).on('mChanged', function (e) { // Listen to event
                    if(run_flag===1){
                        //return;
                    }

                    run_flag = 1;
                    gauge1.update(0);
                    clearInterval(m_Running_Handle);
                    //window.myLine.resetZoom();

                    var url_str = "ajax_data_get.php";
                    url_str += "?start=" + e.mStart.toString();
                    url_str += "&end=" + e.mEnd.toString();

                    var time_label_min = e.mStart;
                    var date_min = new Date(time_label_min);
                    var time_label_max =  e.mEnd ;
                    var date_max = new Date(time_label_max);

                    $.ajax({
                        type: "POST",
                        // data: {
                        //     "gender": $("#gender").val()
                        // },
                        url:  url_str ,
                        dataType: "json",
                        success: function(JSONObject) {
                            // TODO : clean range of array
                            config.data.labels = [];
                            config.data.datasets[0].data = [];
                            config.data.labels.push(date_min);
                            try{
                                JSONObject[0]["time"].toString();
                            }catch (e) {
                                // document.getElementById("model-msg").innerHTML = 'Error; response length = 0';
                                // $('#msgModal').modal('show');
                                document.getElementById("bs4-alert-msg").innerHTML = 'Warning; response length = 0';
                                document.getElementById("bs4-alert").className  = "alert alert-warning";
                                $('#bs4-alert').show();
                                var auto_close_Running_Handle = setInterval(auto_close_Running, 3000);
                                //TODO: remove timer when close-button onclick
                                function auto_close_Running() {
                                    $('#bs4-alert').hide();
                                    clearInterval(auto_close_Running_Handle);

                                }

                                window.createNotification({
                                    // close on click
                                    closeOnClick: true,
                                    // displays close button
                                    displayCloseButton: true,
                                    positionClass: 'nfc-bottom-right',
                                    // callback
                                    onclick: false,
                                    // timeout in milliseconds
                                    showDuration: 3000,
                                    // success, info, warning, error, and none
                                    theme: 'none'
                                })({
                                    title: "Warning",
                                    message: "response length = 0"
                                });

                                gauge1.update(100);
                                run_flag = 0;

                                return;
                            }
                            document.getElementById("textview_start").innerHTML = JSONObject[0]["time"].toString();
                            document.getElementById("textview_end").innerHTML = JSONObject[JSONObject.length - 1]["time"].toString();

                            // Loop through Object
                            for (var key in JSONObject) {
                                if (JSONObject.hasOwnProperty(key)) {
                                    config.data.labels.push( JSONObject[key]["time"] );
                                    config.data.datasets[0].data.push({
                                        t: JSONObject[key]["time"],
                                        y: JSONObject[key]["value"]
                                    });
                                }
                            }

                            config.data.labels.push(date_max); // ++
                            window.myLine.update();

                            gauge1.update(100);
                            run_flag = 0;
                        },
                        error: function (jqXHR, exception) {
                            var msg = '';
                            if (jqXHR.status === 0) {
                                msg = 'Not connect.\n Verify Network.';
                            } else if (jqXHR.status == 404) {
                                msg = 'Requested page not found. [404]';
                            } else if (jqXHR.status == 500) {
                                msg = 'Internal Server Error [500].';
                            } else if (exception === 'parsererror') {
                                msg = 'Requested JSON parse failed.';
                            } else if (exception === 'timeout') {
                                msg = 'Time out error.';
                            } else if (exception === 'abort') {
                                msg = 'Ajax request aborted.';
                            } else {
                                msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            }

                            document.getElementById("model-msg").innerHTML = 'Error; '+ msg.toString();
                            $('#msgModal').modal('show');
                        }
                    });

                });
            </script>

            <p id="textview_time"></p>

  <script>
      var focus = true;
      window.addEventListener("focus", myFocusFunction, true);
      function myFocusFunction() {
          document.getElementById('Button-test').innerHTML = focus;
      }
      window.onblur = function() {
          focus = false;
          myFocusFunction();
      };
      window.onfocus = function() {
          focus = true;
          myFocusFunction();
      };

      $(window).on("resize", function() {
          // $('#bs4-alert').show();
      });

      $(window).on("scroll", function() {
		  
      });

  </script>
            <div class="input-group-append" style="height:3%;">
                <button class="btn btn-outline-secondary " type="button" id="testbtn">Hello</button>
            </div>
  </body>

  <script src="js/feather.min.js"></script>
  <script>
      feather.replace();
  </script>
  <?php
  $time = Timer::stop();
  ?>
<script>
    window.createNotification({
        // close on click
        closeOnClick: true,
        // displays close button
        displayCloseButton: true,
        positionClass: 'nfc-bottom-right',
        // callback
        onclick: false,
        // timeout in milliseconds
        showDuration: 3000,
        // success, info, warning, error, and none
        theme: 'success'
    })({
        title: "Time",
        message: "<?php echo Timer::secondsToTimeString($time) ?>"
    });
</script>


</html>