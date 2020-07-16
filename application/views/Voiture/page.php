<?php if($this->session->userdata("isAdmin")!="TRUE"){return 0;}?>

<div class="row">
    <div class="card col-sm-12">
        <div class="card-body">
            <div class="card-title" style="text-transform:initial;">
                <div class="col-sm-6">
                        <ul style="list-style:none;">
                            <li style="display:inline-block">
                                <h4>Voiture</h4>
                            </li>
                            <li style="display:inline-block; padding-left: 10px;">
                                <button type="button" class="btn btn-outline-primary btn-fw modal-btn">
                                    <i class="mdi mdi-plus"></i>
                                    Ajouter une voiture
                                </button>
                            </li>
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
                                Matricule
                            </th>
                            <th>
                                Marque
                            </th>
                            <th>
                                Edition
                            </th>
                            <th>
                                Place
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody id="body-liste">
                        <?php
                            if (isset($listVoiture)){

                            
                            for ($i=0; $i < count($listVoiture); $i++) { 
                                $row = $listVoiture[$i];
                        ?>
                            <tr>
                                <td><?= $row->voitu_id?></td>
                                <td><?= $row->voitu_matricule?></td>
                                <td><?= $row->voitu_marque?></td>
                                <td><?= $row->voitu_edition?></td>
                                <td><?= $row->voitu_nbr_place?></td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-secondary btn-detail" id="<?= $row->voitu_id;?>">
                                            <i class="fa fa fa-address-card-o"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-supprimer" id="<?= $row->voitu_id;?>">
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
<div id="modal-formulaire-compte" class="modal fade modal-part" role="dialog">
    <div class="modal-dialog modal-lg" style="width:60% !important;">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Formulaire voiture</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="card modal-body">
                <div class="card-body formulaire-container" style="max-height: 65vh; overflow:auto;">
                    <?php $this->load->view('voiture/formulaire') ?>
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
</div>

<!-- Modal -->
<div id="modal-formulaire-image" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="width:30% !important; ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Details sur l'image</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="card modal-body">
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
        nomPage = "<?=$name_controller?>";
    </script>
    <?php $this->load->view('_com/modal.script.php')?>
</div>