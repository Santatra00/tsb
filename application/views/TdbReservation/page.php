<?php if($this->session->userdata("isAdmin")!="TRUE"){return 0;}?>
<style>

.dashboard-chart-legend {
	list-style-type: none;
	padding-left: 0;
}
.dashboard-chart-legend li {
  display: inline;
  width: 70px;
}
.dashboard-chart-legend li span {
	width: 11px;
	height: 11px;
	border-radius: 50%;
	display: inline-block;
	margin-right: 7px;
}
.dashboard-chart-legend li:not(:first-child) span {
	margin-left: 25px;
}
</style>
<div class="row">
  <div class="card col-sm-12 grid-margin stretch-card" style="min-height: 540px;">
    <div id="cash-deposits-chart-legend" class="d-flex justify-content-center pt-3"></div>
    <canvas id="cash-deposits-chart"  style="max-height: 460px;"></canvas>
  </div>
</div>

<!-- Modal -->
<div id="modal-assignation" class="modal fade modal-part" role="dialog">
    <div class="modal-dialog modal-lg" style="width:60% !important;">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Assignation de voiture le <span id="dateSelected"></span> sur l'itineraire (Anjoma)</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="card modal-body">
                <div class="card-body formulaire-container" style="max-height: 65vh; overflow:auto;">
                    <?php $this->load->view('Reservation/formulaire') ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" title="Annulee les restes de la reservation">
                    <i class="fa fa-save"></i>
                        Annuler le reste
                </button>
                <button type="button" class="btn btn-primary send-data" id="send-data">
                <i class="fa fa-save"></i>
                    Enregister
                </button>
                <button type="button" class="btn btn-success" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                    Fermer
                </button>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div id="modal-formulaire-image" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="width:30% !important; ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Liste de reservation</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <div class="card modal-body">
            <div>
                tab1-> liste des reservations annulees
            </div>
            <div>
                tab2-> liste des reservations en attente
            </div>
            <div>
                tab3-> liste des reservations acceptee 
            </div>
                <div class="row">
                    <div class="col-sm-6 text-right pull-right">
                        <img src="" id="image-detail" alt="" style="width: 100%; height: 100%;">

                    </div>
                    <div class="col-sm-6 text-left pull-left">
                        <p id="username-detail">IDENTITY</p>
                        <p id="name-detail">
                            RASOA
                        </p>
                        <p id="last-name-detail">
                            jean
                        </p>
                        <p id="email-detail">
                            jean
                        </p>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn-fermer-image" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                    Fermer
                </button>
            </div>
        </div>
    </div>
    <script>
      $(function(){
      var data = {
        labels: ["0", "1", "2", "3", "4", "5", "6", "7", "8"],
        datasets: [
          {
            label: 'Returns',
            data: [27, 35, 30, 40, 52, 48, 54, 46, 70],
            borderColor: [
              '#ff4747'
            ],
            borderWidth: 2,
            fill: false,
            pointBackgroundColor: "#fff"
          },
          {
            label: 'Sales',
            data: [29, 40, 37, 48, 64, 58, 70, 57, 80],
            borderColor: [
              '#4d83ff'
            ],
            borderWidth: 2,
            fill: false,
            pointBackgroundColor: "#fff"
          },
          {
            label: 'Loss',
            data: [90, 62, 80, 63, 72, 62, 40, 50, 38],
            borderColor: [
              '#ffc100'
            ],
            borderWidth: 2,
            fill: false,
            pointBackgroundColor: "#fff"
          }
        ]
      };
      var options = {
        scales: {
          yAxes: [{
            display: true,
            gridLines: {
              drawBorder: false,
              lineWidth: 1,
              color: "#e9e9e9",
              zeroLineColor: "#e9e9e9",
            },
            ticks: {
              min: 0,
              stepSize: 20,
              fontColor: "#6c7383",
              fontSize: 16,
              fontStyle: 300,
              padding: 15
            }
          }],
          xAxes: [{
            display: true,
            gridLines: {
              drawBorder: false,
              lineWidth: 1,
              color: "#e9e9e9",
            },
            ticks : {
              fontColor: "#6c7383",
              fontSize: 16,
              fontStyle: 300,
              padding: 15
            }
          }]
        },
        legend: {
          display: false
        },
        legendCallback: function(chart) {
          var text = [];
          text.push('<ul class="dashboard-chart-legend">');
          for(var i=0; i < chart.data.datasets.length; i++) {
            text.push('<li><span style="background-color: ' + chart.data.datasets[i].borderColor[0] + ' "></span>');
            if (chart.data.datasets[i].label) {
              text.push(chart.data.datasets[i].label);
            }
          }
          text.push('</ul>');
          return text.join("");
        },
        elements: {
          point: {
            radius: 3
          },
          line :{
            tension: 0
          }
        },
        stepsize: 1,
        layout : {
          padding : {
            top: 0,
            bottom : -10,
            left : -10,
            right: 0
          }
        }
      };
      function changePeriod(){
          if($('#selectTypePeriode').val()=="Journalier"){
              $("#spanSelectMois").show();
              $("#spanSelectAnnee").hide();
              updateChartBySelectedMois();
          }else if($('#selectTypePeriode').val()=="Mensuel"){
              $("#spanSelectMois").hide();
              $("#spanSelectAnnee").show();
              updateChartBySelectedAnnee();
          }else if($('#selectTypePeriode').val()=="Annuelle"){
              $("#spanSelectMois").hide();
              $("#spanSelectAnnee").hide();
              updateChartOnAllAnnee();
          }
      }
      
      function chartShower(data, options, placeId = "cash-deposits-chart"){
        var cashDepositsCanvas = $("#"+placeId).get(0).getContext("2d");
        var cashDeposits = chartBuilder(cashDepositsCanvas, data, options);
        document.getElementById(placeId+'-legend').innerHTML = cashDeposits.generateLegend();
      }

      function updateChartBySelectedAnnee(){
        $.ajax({
            url: baseUrl + "TdbReservation/getStatByAnnee",
            data: {me: 'ws', annee: $("#selectAnnee").val()},
            method: 'GET', 
            success: function(response){
              let myOwnData = designData("mois", response.msg, listItineraire, listColor )
              chartShower(myOwnData, options);
            },
            error: function(error){
                // Notifier erreur
                dataDetails = {};
            }
        });
      }
      function updateChartBySelectedMois(){
        $.ajax({
            url: baseUrl + "TdbReservation/getStatByMois",
            data: {me: 'ws', mois: $("#selectMois").val()},
            method: 'GET', 
            success: function(response){
              let myOwnData = designData("jour", response.msg, listItineraire, listColor)
              chartShower(myOwnData, options);
            },
            error: function(error){
                // Notifier erreur
                dataDetails = {};
            }
        });
      }
      function updateChartOnAllAnnee(){
        $.ajax({
            url:baseUrl + "TdbReservation/getStatOnAnnee",
            data: {me: 'ws'},
            method: 'GET', 
            success: function(response){
                let myOwnData = designData("annee", response.msg, listItineraire, listColor);
                chartShower(myOwnData, options);
            },
            error: function(error){
                // Notifier erreur
                dataDetails = {};
            }
        });
      }

      changePeriod();
    $('#selectTypePeriode').on('change', function(){
        // initialize the filter
        $("#selectAnnee").val(lastAnnee);
        $("#selectMois").val(lastMois);
        changePeriod();
    })

    $("#selectAnnee").on('change', function(){
      updateChartBySelectedAnnee();
    })
    $("#selectMois").on('change', function(){
      updateChartBySelectedMois();
    })
    })
        nomPage = "<?=$name_controller?>";
    </script>
    <?php $this->load->view('_com/modal.script.php')?>
</div>