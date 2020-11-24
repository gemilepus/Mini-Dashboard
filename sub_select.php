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
    <link href="dashboard.min.css" rel="stylesheet">

	<script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

      <script src="chart.bundle.min.js"></script>
      <script src="utils.min.js"></script>
      <style>
          #cy {
              left: 0;
              top: 0;
              bottom: 0;
              right: 0;
              z-index: 999;
              padding-bottom: 10px; /* Increase/decrease this value for cross-browser compatibility */
          }

          h1 {
              opacity: 0.5;
              font-size: 1em;
              font-weight: bold;
          }
      </style>

      <script>
          document.addEventListener('DOMContentLoaded', function(){
              var cy = window.cy = cytoscape({
                  container: document.getElementById('cy'),
                  layout: {
                      name: 'grid',
                      rows: 2,
                      cols: 3
                  },

                  style: [
                      {
                          selector: 'node',
                          style: {
                              'content': 'data(name)'
                          }
                      },

                      {
                          selector: 'edge',
                          style: {
                              'curve-style': 'unbundled-bezier',
                              'target-arrow-shape': 'triangle',
                              'line-color': '#64eac8',


                              'haystack-radius': 0,
                              'width': 5
                              //'opacity': 0.5
                          }
                      },

                      // some style for the extension
                      {
                          selector: '.eh-handle',
                          style: {
                              'background-color': 'red',
                              'width': 12,
                              'height': 12,

                              //'shape': 'diamond',
                              'overlay-opacity': 0,
                              'border-width': 12, // makes the handle easier to hit
                              'border-opacity': 0
                          }
                      },

                      {
                          selector: '.eh-hover',
                          style: {
                              'background-color': 'red'
                          }
                      },

                      {
                          selector: '.eh-source',
                          style: {
                              'border-width': 2,
                              'border-color': 'red'
                          }
                      },

                      {
                          selector: '.eh-target',
                          style: {
                              'border-width': 2,
                              'border-color': 'red'
                          }
                      },

                      {
                          selector: '.eh-preview, .eh-ghost-edge',
                          style: {
                              'background-color': 'red',
                              'line-color': 'red',
                              'target-arrow-color': 'red',
                              'source-arrow-color': 'red'
                          }
                      },

                      {
                          selector: '.eh-ghost-edge.eh-preview-active',
                          style: {
                              'opacity': 0
                          }
                      }
                  ],

                  elements: {
                      nodes: [
                          { data: { id: 'Server', name: 'Server' } },
                          { data: { id: 'Sensor 2', name: 'Sensor 2' } },
                          { data: { id: 'Sensor 3', name: 'Sensor 3' } },
                          { data: { id: 'Sensor 1', name: 'Sensor 1' } },
                          // { data: { id: 'Sensor 4', name: 'Sensor 4' } },
                          // { data: { id: 'Sensor 5', name: 'Sensor 5' } },
                          { data: { id: 'Sensor 6', name: 'Sensor 6' } }
                      ],
                      edges: [
                          { data: { source: 'Server', target: 'Sensor 2' } },
                          { data: { source: 'Server', target: 'Sensor 1' } }
                      ]
                  }
              });
              cy.panningEnabled( false ); // disable move & zoom

              var eh = cy.edgehandles();

              document.querySelector('#draw-on').addEventListener('click', function() {
                  eh.enableDrawMode();
              });

              document.querySelector('#draw-off').addEventListener('click', function() {
                  eh.disableDrawMode();
              });

              document.querySelector('#start').addEventListener('click', function() {
                  eh.start( cy.$('node:selected') );
              });

              cy.on('cxttap', 'edge', function( evt ){
                  var tgt = evt.target || evt.cyTarget; // 3.x || 2.x

                  tgt.remove();
              });
          });
      </script>
      <script src="nodesCheck.min.js"></script>


  </head>

  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">ヽ(ﾟДﾟ)ﾉ</a>
      <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="#">Sign out</a>
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

            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <button class="btn btn-sm btn-outline-secondary">Save</button>
                <button class="btn btn-sm btn-outline-secondary">Export</button>
              </div>
              <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar"></span>
                This week
              </button>
             </div>
           </div>

            <div  class="rounded border border-success" id="cy" style="width:80%;height:600px;" ></div>

            <button class="btn btn-sm btn-outline-secondary" id="start">Start on selected</button>
            <button class="btn btn-sm btn-outline-secondary"  id="draw-on">Draw mode on</button>
            <button class="btn btn-sm btn-outline-secondary"  id="draw-off">Draw mode off</button>

            <p id="demo"></p>
            <p id="textview"></p>

            <br>
            <br>

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Min</th>
                        <th>Max</th>

                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <td>1</td>
                        <td>Sensor 1</td>
                        <td>c</td>
                        <td>0</td>
                        <td>100</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Sensor 2</td>
                        <td></td>
                        <td>0</td>
                        <td>100</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Sensor 3</td>
                        <td></td>
                        <td>0</td>
                        <td>100</td>
                    </tr>

                    </tbody>
                </table>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Max</th>
                        <th>Min</th>

                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    echo "</tr>";
                    
                    ?>
                    </tbody>

                </table>
            </div>

            <?php
            $i = 0;
            while( $i < 10) {
                echo "<br>";
                $i++;
            }
            ?>

        </main>
      </div>
    </div>

    <script src="js/feather.min.js"></script>
    <script>
        feather.replace()
    </script>

  </body>
  <script src="https://unpkg.com/cytoscape/dist/cytoscape.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.10/lodash.js"></script>
  <script src="js/cytoscape-edgehandles.js"></script>
</html>
