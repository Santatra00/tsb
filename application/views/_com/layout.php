<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EMITRACK</title>

    <!-- Chargement des styles global -->
    <?php $this->load->view('_com/css') ?>
    <?php if(isset($styles)) { foreach($styles as $style) { ?>
        <link rel="stylesheet" href="<?= base_url('assets/'.$style) ?>">
    <?php } } ?>
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/utils.js') ?>"></script>

    <style>
        .nav-dessus {
            position: absolute;
            width: 60px;
            left: auto;
            top: 0px;
            height: 7em;
            background-color: rgb(18, 20, 68);
            height: 100%;
        }
        .color-nav{
            background-color: rgb(18, 18, 40);
            color: black;
        }
        .color-nav-item{
            background-color: rgb(18, 18, 40);
        }
        .color-nav-item:hover{
            background-color: rgb(118, 18, 40, 0.8);
        }
        #nav-haut{
            width: calc(100% - 300px);
            -moz-transition: width 0.25s ease;
        }
        .white-color{
            color: white;
        }
        .bleu{
            color: rgb(18, 20, 68);
        }
        .bleu-bg{
            background-color: rgb(18, 20, 68);
        }
        .bleu-soft-color{
            color: rgb(88, 166, 221);
        }
        .bleu-soft-color-bg{
            background-color: rgb(88, 166, 221) !important;
        }
        .bleu-hard{
            color: rgb(18, 18, 40);
        }
        .bleu-hard-bg{
            background-color: rgb(18, 18, 40)
        }
        .menu-icon-navbar{
            height: calc(100% - 50px);
            display: table-cell; /* comportement visuel de cellule */
            vertical-align: middle;
            line-height: 50em; /* hauteur de ligne (identique) */
            white-space: nowrap; /* interdiction de passer à la ligne */
            width: 63px;
        }
        .icon-in-sidebar{
            border-style: none !important;
            padding-top: 18px;
            padding-bottom: 20px;
            padding-right: 16px;
            padding-left: 20px;
            border-radius: 0px;
            margin: 2px;
            display: block;
            width: 58px;
        }
        .icon-in-sidebar:hover{
            background-color: rgb(23, 26, 90);
        }
        .menu-item-personalized{
            padding-top: 4px !important;
            padding-bottom: 5px !important;
        }
    </style>
</head>
<body>
    <!-- Debut input hidden -->
    <input type="hidden" id="base_url" value="<?= base_url() ?>">
    <!-- Fin input hidden -->
    <div class="container-scroller ">

            <!-- Debut navigation -->
               
            <!-- Fin navigation -->
            <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row" id="nav-haut" style="background-color:white!important;">
                <!-- <div class="navbar-brand-wrapper d-flex align-items-top reste-sidebar" style="background-color:rgb(18, 18, 40);">
                    <button type="button" class="btn btn-outline-secondary" style="border-style: none !important; background-color:rgb(18, 18, 140);" id="btn-toggle-menu">
                        <i class="fa fa-bars" style="font-size:22px;"></i>
                    </button>
                    <a class="navbar-brand brand-logo pl-4 color-nav" href="../">
                        <img src="<?= base_url('assets/images/EMIT.jpg') ?>" alt="logo" width="80"/>
                    </a>
                    <a class="navbar-brand brand-logo-mini color-nav" href="../../index.html">
                        <img src="../../images/logo-mini.svg" alt="logo" />
                    </a>
                </div> -->
                <div class="navbar-menu-wrapper d-flex align-items-center" style="background-color:transparent!important; -moz-transition: width 0.25s ease;" id="navbar-top">
                    <div class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
                        <div style="padding-top:15px; font-weight:bold; color: black;" id="titre-page">
                            <?=$titre?>
                        </div>
                    </div>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item dropdown d-none d-xl-inline-block mr-0">
                            <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                                <span class="profile-text" style="color: black;">Bonjour, <?= $this->session->userdata("nom")." ".$this->session->userdata("prenom") ?>!</span>
                                <img class="img-xs rounded-circle" src="<?= base_url('./assets/images/pic-admin.png') ?>" alt="Profile image">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown " aria-labelledby="UserDropdown">
                            
                                <a class="dropdown-item mt-3" href="<?= base_url('login/logout') ?>">
                                <i class="menu-icon mdi mdi-logout"></i>
                                    Deconnection
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown d-none d-xl-inline-block">
                            <img style="display:none;" class="img-xs rounded-circle" id="btn-open-sidebar-trajet" src="<?= base_url('./assets/images/vehicles-set_1308-31099-bus.jpg') ?>" alt="Bus image">
                            <img style="display:none;" class="img-xs rounded-circle" id="btn-close-sidebar-trajet" src="<?= base_url('./assets/images/vehicles-set_1308-31099-bus.jpg') ?>" alt="Bus image">
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                        data-toggle="offcanvas">
                        <span class="mdi mdi-menu"></span>
                    </button>
                </div>
            </nav>
            <div class="container-fluid page-body-wrapper" style="margin-top: -63px">
                <div style="height: 100vh;">
                    <nav id="sidebar" class="sidebar sidebar-offcanvas color-nav" style="height: 100vh; overflow: auto; position: fixed; top: 0; left: 0;">
                        <ul class="nav" style="margin-left: 60px; " id="ul-nav-bar">
                            <div style="vertical-align: middle;">
                                <div class="align-items-center white-color" style="text-align: center;">
                                    <div style="margin-top: 26px;"/>
                                    <img src="<?= base_url('assets/images/EMIT.jpg') ?>" alt="logo" width="80"/>
                                    <p style="margin-top: 15px; font-size: 16px;">EMIT's SchoolBUS</p>
                                    <p style="margin-top: -18px; font-size: 10px;">Application de Tracking</p>
                                    <p style="font-size: 16px; text" id="hourSideBar"><b>14:30</b> </p>
                                    <p style="margin-top: -18px; font-size: 11px;" id="daySideBar">Vendredi 19 Juin 2020</p>
                                </div>
                            </div>
                        </ul>
                        <ul class="nav" style="margin-left: 60px; ">
                            <li class="nav-item  menu-item-personalized">
                                <a class="nav-link" data-toggle="collapse" href="#acceuil-link"  target="_self" aria-expanded="false" aria-controls="acceuil-link">
                                    <span class="menu-title">Acceuil</span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="collapse" id="acceuil-link">
                                    <ul class="nav flex-column sub-menu">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('Reservation') ?>" active>Reservation</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('Voiture') ?>" active>Voiture</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item  menu-item-personalized">
                                <a class="nav-link" data-toggle="collapse" href="#Statistique-link"  target="_self" aria-expanded="false" aria-controls="Statistique-link">
                                    <span class="menu-title">Statistique </span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="collapse" id="Statistique-link">
                                    <ul class="nav flex-column sub-menu">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('TdbReservation') ?>" active>Reservation</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('TdbVoiture') ?>" active>Voiture</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item menu-item-personalized">
                                <a class="nav-link" href="<?= base_url('Carte') ?>" active>
                                    <span class="menu-title">Carte</span>
                                </a>
                            </li>
                            <!-- <li><legend style="font-size: 12px;padding: 10px 0px 0px 35px;color:#979797;">Carte</legend></li> -->
                            <li class="nav-item  menu-item-personalized">
                                <a class="nav-link" data-toggle="collapse" href="#zone-saisi"  target="_self" aria-expanded="false" aria-controls="zone-saisi">
                                    <span class="menu-title">Zone de saisi</span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="collapse" id="zone-saisi">
                                    <ul class="nav flex-column sub-menu">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('Chauffeur') ?>" active>Chauffeur</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('Voiture') ?>" active>Voiture</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('Itineraire') ?>" active>Itineraire</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('Ramassage') ?>" active>Point de ramassage</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('Abonnement') ?>" active>Abonnement</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item menu-item-personalized">
                                <a class="nav-link" data-toggle="collapse" href="#ui-basic" target="_self" aria-expanded="false" aria-controls="ui-basic">
                                    <span class="menu-title">Utilisateur</span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="collapse" id="ui-basic">
                                    <ul class="nav flex-column sub-menu">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('compte') ?>" active>Compte</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('groupe') ?>" active>Groupe</a>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('historique') ?>" active>Historique</a>
                                        </li> -->
                                    </ul>
                                </div>
                            </li>
                            <!-- <li class="nav-item menu-item-personalized">
                                <a class="nav-link" href="<?= base_url('Notification') ?>" active>
                                    <i class="menu-icon mdi mdi-exclamation"></i>
                                    <span class="menu-title">Notification</span>
                                </a>
                            </li> -->
                      
                        </ul>
                    </nav>
                    <div class="nav-dessus" style="z-index: 11; position: fixed; top: 0; left: 0;" >
                        <button type="button" class="btn icon-in-sidebar  bleu-soft-color-bg" style="margin-top: 0px; margin-left: 0px; margin-right: 0px;" id="btn-toggle-menu">
                            <i class="fa fa-bars" style="font-size:22px; color: rgb(18, 18, 40);"></i>
                        </button>
                        <div class="menu-icon-navbar">
                            <div style="display: inline-block;">
                                    <button type="button" class="btn icon-in-sidebar bleu-bg" >
                                        <i class="fa fa-home " style="font-size:22px; color: white; "></i>
                                    </button>

                                    <button type="button" class="btn icon-in-sidebar bleu-bg" >
                                        <a data-toggle="collapse" href="#Statistique-link"  target="_self" aria-expanded="false" aria-controls="Statistique-link">
                                            <i class="menu-icon mdi mdi-chart-bar " style="font-size:22px; color: white;"></i>
                                        </a>
                                    </button>

                                    <button type="button" class="btn icon-in-sidebar bleu-bg" >
                                        <i class="mdi mdi-map" style="font-size:22px; color: white;"></i>
                                    </button>

                                    <button type="button" class="btn icon-in-sidebar bleu-bg" >
                                    <a data-toggle="collapse" href="#zone-saisi"  target="_self" aria-expanded="false" aria-controls="zone-saisi">
                                        <i class="menu-icon fa fa-keyboard-o" style="font-size:22px; color: white;"></i>
                                    </a>
                                    </button>

                                    <button type="button" class="btn icon-in-sidebar bleu-bg" >
                                        <a data-toggle="collapse" href="#ui-basic" target="_self" aria-expanded="false" aria-controls="ui-basic">
                                            <i class="menu-icon mdi mdi-account-circle" style="font-size:22px; color: white;"></i>
                                        </a>
                                    </button>

                            </div>
                                
                        </div>
                    </div>
                </div>
                <div class="main-panel" id="main" style="flex: auto !important; margin-top: 63px;  position: relative; margin-left: 300px;">
                    <!-- Debut contenu -->
                    <div class="content-wrapper" id="content-page">
                        <?php
                            if(isset($contenu)){
                                $this->load->view($contenu);
                            }
                        ?>
                    </div>
                    <!-- Fin contenu -->
                    <!-- Debut footer -->
                    <footer class="footer">
                        <div class="container-fluid clearfix">
                            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2020
                                <a href="http://www.bootstrapdash.com/" target="_blank">iTDC MADA</a>. All rights reserved.
                            </span>
                        </div>
                    </footer>
                    <!-- Fin footer -->
                </div>
                <nav id="sidebar-trajet" class="sidebar sidebar-offcanvas" style="width: 0px; background-color: #f3f2f9; margin-left: -10px;">
                    <ul class="nav" style="" id="ul-nav-bar" style="background-color: #f3f2f9;">
                        <div class="align-items-center"
                            style="padding-top: 26px; padding-left: 10px; background-color: white; height: 70px; width: 100%;">
                                <span class="" style="font-size: 17px;"> Itineraire
                                </span>
                                <i class="menu-icon mdi mdi-settings mr-2 mt-1" style="float: right;" id="paramItineraire"></i>
                        </div>
                        <div id="itineraireList" style="height: 89vh; overflow: auto;">
                            <li class="card nav-item m-2 p-1" style="background-color: white; height: 140px;">
                                <p class="mt-1 ml-2"><b>Itineraire 1</b>: Sahalava<br>
                                    Bus: 1 en route
                                </p>
                                <img class="img-xs" id="btn-close-sidebar-trajet" src="<?= base_url('./assets/images/vehicles-set_1308-31099-bus.jpg') ?>" alt="Bus image">
                                <p class="mt-1 ml-2"><b>Transport: 23 personnes</b><br>
                                    a Ampasambazaha
                                </p>
                            </li>
                        </div>
                        
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Debut header -->
        
        <!-- Fin header -->
        
    <div id='chargement-page' style='display: none'>
        <div style="width: 100%; background-color:rgba(255, 255, 255, 0.8); text-align: center; height: 200px; vertical-align: middle; padding-top: 70px;">
            <div style="background-color: white; width: 96px; display: inline; margin: auto; ">
                <img src="<?= base_url('/assets/images/preloading.gif') ?>" alt="">
            </div>
        </div>
    </div>
    <div id='not-found-page' style='display: none'>
        <div style="width: 100%; background-color:rgba(255, 255, 255, 0.8); text-align: center; height: 300px; vertical-align: middle; padding-top: 20px;">
            <img src="<?= base_url('/assets/images/notFound.PNG') ?>" alt="">
            <h2>Page introuvable</h2>
        </div>
    </div>

    <!-- Chargement des scripts global -->
    <?php $this->load->view('_com/js'); ?>

    <?php if(isset($scripts)) { foreach($scripts as $script) { ?>
        <script src="<?= base_url('assets/'.$script) ?>"></script>
    <?php } } ?>
    <script>
        var popState = false; 
        var stateSidebarTrajet = 0;
        var imageSidebarTrajet = [
            "<?= base_url('./assets/images/vehicles-set_1308-31099-bus.jpg') ?>",
            "<?= base_url('./assets/images/vehicles-set_1308-31099-bus.jpg') ?>",
            "<?= base_url('/assets/images/preloading.gif') ?>"
        ];
        var baseUrl = "<?=base_url()?>";
        var pageState = {
            me: 'page'
        }
        var currentPage = baseUrl+"<?=$name_controller?>" + utils.designPropriete(pageState);
        
        
        $('a').click(function(event){
            if($(this).attr('active') == ''){
                event.preventDefault()
                getPage($(this).attr('href'));
            }
        });
        
        function changeSidebarTrajet(s = 0){
            stateSidebarTrajet = s;
            $("#btn-open-sidebar-trajet").attr('src', imageSidebarTrajet[stateSidebarTrajet]);
        }
        function getPage(page = '', place = '', callback=false){
            $('#btn-open-sidebar-trajet').hide();

            if(place == ''){
                place = '#content-page';
            }

            if(page != ''){
                currentPage = page + utils.designPropriete(pageState);
            }

            if(!popState){
                // Change url & prie en compte du retour du navigateur
                const state = {};
                const title = 'EMITRACK';
                const url = currentPage.substr(0, currentPage.length - utils.designPropriete(pageState).length);
                history.pushState(state, title, url)
            }
            popState = false;
            
            // Chargement de loading
            $(place).html($('#chargement-page').html())
            $('#titre-page').html('');

            // Get page content
            $.get(currentPage).then(function(data){
                $(place).html(data.page)

                if(data.fullsize){
                    utils.closeNavBar()        
                }else{
                    utils.openNavBar()       
                }
                $('#titre-page').html(data.title);

                if(callback){callback()}
            }, function(error){
                utils.openNavBar()      
                $(place).html($('#not-found-page').html())
            });
        }
        window.onpopstate = function (event){
            popState = true;
            getPage(document.location);
        }

        $.notify.addStyle('happyblue', {
            html: "<div style='margin-right: 8px;'><img src='<?=base_url('assets/images/checkmark_64px.png')?>' width='18' height='18' style='margin-left: 4px; margin-right: 8px; margin-bottom: 1px;  margin-top: 1px;'/><span data-notify-text/></div>",
            classes: {
                base: {
                    "white-space": "nowrap",
                    "background-color": "rgba(255, 255, 255, 0.9)",
                    "padding": "6px",
                    "border-radius": "10px",
                    "box-shadow": "0 2px 5px rgba(0, 0, 0, 0.06)",
                    "transition": "height 2s linear",
                    "margin-top": "10px"
                },
                superblue: {
                    "color": "white",
                    "background-color": "blue"
                }
            }
        });
        function notifier(msg, type = 'message'){
            if(type == 'message'){
                $.notify(msg, {
                    style: 'happyblue'
                });
            }else{
                $.notify(msg, type);
            }
        }

    </script>
</body>
</html>