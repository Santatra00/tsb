<?php if($this->session->userdata("isAdmin")!="TRUE"){return 0;}?>

<div class="row">
    <div class="card col-sm-12">
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th>
                                Num
                            </th>
                            <th>
                                Itineraire(A)
                            </th>
                            <th>
                                Heure d'arrivee
                            </th>
                            <th>
                                Voiture
                            </th>
                            <th>
                                Reservation restant
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody id="body-liste">
                        <?php
                            if (isset($listReservation)){
                            for ($i=0; $i < count($listReservation); $i++) { 
                                $row = $listReservation[$i];
                        ?>
                            <tr>
                                <td><?= $i + 1?></td>
                                <td><?= $row->reserv_itine_nom?></td>
                                <td><?= $row->reserv_heure?></td>
                                <td><?= $row->reserv_etu_total?></td>
                                <td><?= $row->reserv_etu_total?></td>

                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-secondary btn-assignation" 
                                            id="<?= $row->itine_id;?>" 
                                            title="Assignation de voiture"
                                            isallee="true"
                                            heure="<?= $row->reserv_heure?>">
                                            <i class="mdi mdi-bus" style="font-size: 18px;"></i>
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-liste" 
                                            itine_id="<?= $row->itine_id;?>" 
                                            title="Liste des reservations detaillees"
                                            reserv_allee="true"
                                            reserv_heure="<?= $row->reserv_heure?>">
                                            <i class="fa fa fa-address-card-o"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-supprimer" id="<?= $row->itine_id;?>"
                                            title="Annuler toute les reservations"
                                            >
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php
                            }
                        }else{
                        ?>
                            <tr >
                                <td colspan="6" style="text-align:center;">
                                    Il n'y a pas encore de donnees
                                </td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
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
<div id="modal-liste" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="width:60% !important; ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Liste des reservations pour un voyage le (date)</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="card modal-body">
            <table class="table table-striped" id="datatable-liste-reservation">
                    <thead>
                        <tr>
                            <th>
                                Num
                            </th>
                            <th>
                                Nom&Prenom de l'etudiant
                            </th>
                            <th>
                                Fait le 
                            </th>
                            <th>
                                Etat
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody id="body-liste-reservation">

                    </tbody>
                </table>
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
        var listeVoitureStore = [
                <?php
                    if (isset($listVoiture)){                   
                        for ($i=0; $i < count($listVoiture); $i++) { 
                            $row = $listVoiture[$i];
                    ?>  
                            {
                                voitu_id: <?=$row->voitu_id?>,
                                voitu_matricule: "<?= $row->voitu_matricule?>",
                                voitu_nbr_place:  <?= $row->voitu_nbr_place?>
                            },
                    <?php        
                        }
                    }?>
        ];

        var listeReservationStore = [
            <?php
                if (isset($listReservation)){                   
                    for ($i=0; $i < count($listReservation); $i++) { 
                        $row = $listReservation[$i];
            ?>  
                        {
                            reserv_heure: "<?=$row->reserv_heure?>",
                            reserv_etu_total: "<?= $row->reserv_etu_total?>"
                        },
            <?php        
                    }
                }
            ?>
        ];
        function createTableauListe(listeReservation){
            let htmlTemplate = "";
            for (let index = 0; index < listeReservation.length; index++) {
                const reservation = listeReservation[index];
                htmlTemplate += "<tr>";
                htmlTemplate += "<td>"+index+"</td>";
                htmlTemplate += "<td>"+reservation.etu_nom+' '+reservation.etu_prenom+"</td>";
                htmlTemplate += "<td>"+reservation.reserv_date_creation+"</td>";
                htmlTemplate += "<td>"+reservation.reserv_etat+"</td>";
                htmlTemplate += '<td><button type="button" title="Annuler cette reservation" class="btn btn-danger btn-supprimer-reservation" reserv_id="'+reservation.reserv_id+'" ><i class="fa fa-trash-o"></i></button></td>';

                htmlTemplate += "</tr>";
            }
            $("#body-liste-reservation").html(htmlTemplate);
            $("#datatable-liste-reservation").DataTable();
        }
        $(function(){
            document.querySelector("#datePicker").valueAsDate = new Date('<?=$date?>');
            $("[name='voya_date']").val($("#datePicker").val());

            $(".btn-detail").on('click', function(){
                $("#dateSelected").html(utils.formatDate($("#datePicker").val()));
                // heure d'arrivee et de depart
                // liste des voitures (onChange(HeureArrive){change listeVoiture})
                // allee @ itineraire
                // nombre de reservation pour chaque heure (onChange(this){change nombre de passager restant et donnees select})
            })
            $("#datePicker").on('change', function(){
                pageState['date'] = $(this).val();
                getPage(baseUrl + 'Reservation')
            })
            $(".btn-assignation").on('click', function() {
                $("[name='voya_allee']").val($(this).attr('isallee'));
                $("[name='voya_heure_arrivee']").val($(this).attr('heure'))
                $("[name='poss_itine_id']").val($(this).attr('id'));
                console.log($(this).attr('isallee'), $(this).attr('heure'), $(this).attr('id'))
                // get nombre de reservation par date
                $.ajax({
                    url: "<?=base_url('Reservation/getNombreByDateAndItineraire')?>",
                    data: {
                        me: 'ws', 
                        reserv_date: $("#datePicker").val(), 
                        point_itine_id: $("[name='poss_itine_id']").val(),
                        reserv_allee: $("[name='voya_allee']").val()
                    },
                    method: 'GET', 
                    success: function(response){
                        let template = '';
                        for (let index = 0; index < response.msg.length; index++) {
                            const reservation = response.msg[index];
                            template += '<option value="'+reservation.reserv_heure+'">'+reservation.reserv_heure+'('+reservation.reserv_nombre+')</option>';
                        }
                        // mettre dans #passager_nombre
                        // callback: show voiture
                        $("#passager_nombre").html(template);
                        $("#modal-assignation").modal('show');
                    },
                    error: function(error){
                        // Notifier erreur
                    }
                });
            })
            $(".btn-liste").on('click', function() {
                // $("[name='reserv_allee']").val($(this).attr('isallee'));
                // $("[name='heure_arrivee']").val($(this).attr('heure'))
                $.ajax({
                    url: baseUrl + "Reservation/getReservationByDateHeureAllee",
                    data: {
                        'me': 'ws', 
                        'reserv_date': $("#datePicker").val(), 
                        'reserv_heure': $(this).attr('reserv_heure'), 
                        'reserv_allee': $(this).attr('reserv_allee'), 
                        'itine_id': $(this).attr('itine_id')
                    },
                    method: 'GET', 
                    success: function(response){
                        createTableauListe(response.msg);
                        $("#modal-liste").modal('show');
                    },
                    error: function(error){
                        // Notifier erreur
                    }
                });
            })
        });
        nomPage = "<?=$name_controller?>";
    </script>
    <?php $this->load->view('_com/modal.script.php')?>
</div>