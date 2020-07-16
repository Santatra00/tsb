<?php if($this->session->userdata("isAdmin")!="TRUE"){return 0;}?>

<div class="row">
    <div class="card col-sm-12">
        <div class="card-body">
            <div class="card-title" style="text-transform:initial;">
                <div class="col-sm-6">
                        <ul style="list-style:none;">
                            <li style="display:inline-block">
                                <h4>Abonnement et Reservation des etudiants</h4>
                            </li>
                            <!-- <li style="display:inline-block; padding-left: 10px;">
                                <button type="button" class="btn btn-outline-primary btn-fw modal-btn">
                                    <i class="mdi mdi-plus"></i>
                                    Ajouter une abonnement
                                </button>
                            </li> -->
                        </ul>
                </div>
                <div class="col-sm-6 text-right pull-right">
                    <div class="form-group" style="display:none;">
                        <label></label>
                        <div class="input-group" id='loupe-icon'>
                            <div class="input-group-prepend bg-primary border-primary">
                                <span class="input-group-text bg-transparent">
                                    <i class="fa fa-search text-white"></i>
                                </span>
                            </div>
                            <input type="search" class="form-control" placeholder="Rechercher" aria-label="Username"
                                aria-describedby="colored-addon2" id="input-rechercher-compte" aria-controls="datatable">
                        </div>
                    </div>                            
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th>
                                ID
                            </th>
                            <th>
                                Nom & Prenom etudiant
                            </th>
                            <th>
                                Ticket valide
                            </th>
                            <th>
                                Date de peremption(min)
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody id="body-liste">
                        <?php
                            if (isset($listAbonnement)){

                            
                            for ($i=0; $i < count($listAbonnement); $i++) { 
                                $row = $listAbonnement[$i];
                        ?>
                            <tr>
                                <td><?= $row->etu_id?></td>
                                <td><?= $row->abon_etu_nom.' '.$row->abon_etu_prenom?></td>
                                <td><?= $row->somme_ticket?></td>
                                <td><?= $row->abon_min_date?></td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-outline-primary btn-detail" id="<?= $row->etu_id;?>" action="Ajouter">
                                            <i class="fa fa fa-address-card-o"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-dark btn-reserver" id="<?= $row->etu_id;?>">
                                            <i class="fa fa-calendar"></i>
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
<div id="modal-formulaire-compte" class="modal fade modal-part" role="dialog">
    <div class="modal-dialog modal-lg" style="width:60% !important;">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Formulaire Abonnement</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="card modal-body">
                <div class="card-body formulaire-container" style="max-height: 65vh; overflow:auto;">
                    <?php $this->load->view('Abonnement/formulaire') ?>
                </div>
            </div>
            <div class="modal-footer">
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

    <script>
        nomPage = "<?=$name_controller?>";
        var btn_detail_callback = function (data){
            utils.createTable(data.tickets, [
                'abon_id', 
                'nombre_ticket', 
                'abon_date', 
                'date_validite',
                'abon_uti_nom'
            ], 'body-liste-ticket')
            // $('#liste-ticket').DataTable()
        }
    </script>
    <?php $this->load->view('_com/modal.script.php')?>
    <script>
        
    </script>
</div>

<!-- Modal -->
<div id="modal-reservation" class="modal" role="dialog">
    <div class="modal-dialog modal-lg" style="width:60% !important;">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Formulaire de reservation</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="card modal-body">
                <div class="card-body formulaire-container" style="max-height: 65vh; overflow:auto;">
                    <?php $this->load->view('Abonnement/formulaire.reservation.php') ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" >
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
    <script>
        $('.btn-reserver').click(function () {
            $("#modal-reservation").modal('show');
        })
    </script>
</div>