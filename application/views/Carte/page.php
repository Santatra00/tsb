<?php if($this->session->userdata("isAdmin")!="TRUE"){return 0;}?>
<style>
    #map{
        width: 99%;
        height: 99%;
    }
    #datePicker{
        margin-top: 1px;
        height: 25px;
        width: 100%;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
        background-color: rgb(18, 18, 40);
        outline: none;
        border: 0;
        border-radius: 3px;
        padding: 0 3px;
        color: #fff;
    }
    #selectVoyage{
        margin-top: 1px;
        height: 25px;
        width: 100%;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
        background-color: rgb(18, 18, 40);
        outline: none;
        border: 0;
        border-radius: 3px;
        padding: 0 3px;
        color: #fff;
    }
    .marker-ramassage {
        background-size: cover;
        width: 13px;
        height: 13px;
        border: 3px solid rgb(88, 166, 221);
        cursor: pointer;
        border-radius: 38px;
        background-color: white;
    }
    .marker-voiture {
        background-image: url("<?= base_url('assets/images/location-vehicule.png') ?>");
        width: 28px;
        height: 40px;
        cursor: pointer;
        margin-top: -20px;
    }
    .swiper-container {
        width: 200px;
        height: 200px;
    }
    .swiper-button-next{
        font-size: 24px;
    }
    .swiper-button-prev{
       font-size: 24px;
    }

</style>
<div class="row ml-0" id='map' ></div>
<script>
    utils.closeNavBar()        
</script>
<?php 
    if(isset($isPage) && $isPage){
        
        if(isset($styles)) { 
            foreach($styles as $style) { 
?>
        <link rel="stylesheet" href="<?= base_url('assets/'.$style) ?>">
<?php 
            }
        }

        if(isset($scripts)) { 
            foreach($scripts as $script) { 
?>
                <script src="<?= base_url('assets/'.$script) ?>"></script>
<?php 
            }
        }
        
    } 
?>


<!-- Modal -->
<div id="modal-formulaire-compte" class="modal fade modal-part" role="dialog">
    <div class="modal-dialog modal-lg" style="width:60% !important;">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Formulaire chauffeur</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="card modal-body">
                <div class="card-body formulaire-container" style="max-height: 65vh; overflow:auto;">
                    <?php $this->load->view('Chauffeur/formulaire') ?>
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
                <h4 class="modal-title">Configuration de la carte</h4>
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
        var map;
        nomPage = "<?=$name_controller?>";
        $('#btn-open-sidebar-trajet').show();
        $('#btn-close-sidebar-trajet').hide();
        
        $('#btn-open-sidebar-trajet').on('click', function(){
            $('#btn-close-sidebar-trajet').show();
            $('#btn-open-sidebar-trajet').hide();
            utils.openSideBarTrajet(()=>map.resize)
        })
        $('#btn-close-sidebar-trajet').on('click', function(){
            $('#btn-open-sidebar-trajet').show();
            $('#btn-close-sidebar-trajet').hide();
            utils.closeSideBarTrajet(()=>map.resize);
        })
        $(function(){
            $("#paramItineraire").on('click', function(){
                $("#modal-formulaire-image").modal('show');
            })
            document.querySelector("#datePicker").valueAsDate = new Date();
            // Get all coordonate in live
            
        })
        
        
        // misy fotoana tsy miseho ny menu lateral droite
        // initialisation carte date aujourd'hui et selectVoyage(voyage existant pour avoir l'heur)
        // get last position of vehicle if (in last) => en cours et en attente
        // after get all itineraire information, with all (vehicle, nbPlace en fonction de sa position) in this configuration
        // get name of fokontany of this positions
        
        // Menu amboarina ny margin of the sub-menu
        // change the time
        // controlle champs

        // assign the voyage
    </script>
    <?php $this->load->view('_com/modal.script.php')?>
</div>