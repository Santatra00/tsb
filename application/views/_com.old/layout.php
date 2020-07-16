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

</head>
<body>
    <!-- Debut input hidden -->
    <input type="hidden" id="base_url" value="<?= base_url() ?>">
    <!-- Fin input hidden -->
    <div class="container-scroller">
        <!-- Debut header -->
        <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="navbar-brand-wrapper d-flex align-items-top">
                <button type="button" class="btn btn-outline-secondary" style="border-style: none !important;" id="btn-toggle-menu"> <i class="fa fa-bars" style="font-size:22px;"></i></button>
                <a class="navbar-brand brand-logo pl-4" href="../">
                    <img src="<?= base_url('assets/images/EMIT.jpg') ?>" alt="logo" width="80"/>
                </a>
                <a class="navbar-brand brand-logo-mini" href="../../index.html">
                    <img src="../../images/logo-mini.svg" alt="logo" />
                </a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center">
                <div class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
                    <p style="padding-top:15px; font-weight:bold;">LOGICIEL DE TRACKING DES BUS DE L'<b>EMIT</b></p>
                </div>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item dropdown d-none d-xl-inline-block">
                    <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown"
                            aria-expanded="false">
                            <span class="profile-text">Bonjour, <?= $this->session->userdata("nom")." ".$this->session->userdata("prenom") ?>!</span>
                            <img class="img-xs rounded-circle" src="<?= base_url('./assets/images/pic-admin.png') ?>" alt="Profile image">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown " aria-labelledby="UserDropdown">
                          
                            <a class="dropdown-item mt-3" href="<?= base_url('login/logout') ?>">
                            <i class="menu-icon mdi mdi-logout"></i>
                                Deconnection
                            </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- Fin header -->
        <div class="container-fluid page-body-wrapper">
            <!-- Debut navigation -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('Acceuil') ?>" active>
                            <i class="menu-icon mdi mdi-chart-bar "></i>
                            <span class="menu-title">Acceuil</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('Reservation') ?>" active>
                            <i class="menu-icon mdi mdi-calendar"></i>
                            <span class="menu-title">Reservation </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('Chauffeur') ?>" active>
                            <i class="menu-icon mdi mdi-account-settings-variant"></i>
                            <span class="menu-title">Chauffeur</span>
                        </a>
                    </li>
                    <!-- <li><legend style="font-size: 12px;padding: 10px 0px 0px 35px;color:#979797;">Carte</legend></li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('Carte') ?>" active>
                            <i class="menu-icon mdi mdi-map"></i>
                            <span class="menu-title">Carte</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('Notification') ?>" active>
                            <i class="menu-icon mdi mdi-exclamation"></i>
                            <span class="menu-title">Notification</span>
                        </a>
                    </li>
                    <?php if($this->session->userdata("isAdmin")=="TRUE"){?>                    

                    <legend style="font-size: 12px;padding: 10px 0px 0px 35px;color:#979797;">Administration</legend>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('Voyage') ?>" active>
                            <i class="menu-icon mdi mdi-car-connected"></i>
                            <span class="menu-title">Voyage </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('Abonnement') ?>" active>
                            <i class="menu-icon mdi mdi-calendar-check"></i>
                            <span class="menu-title">Abonnement et Reservation</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic" target="_self" aria-expanded="false" aria-controls="ui-basic">
                            <i class="menu-icon fa fa fa-user-circle"></i>
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
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#zone-saisi"  target="_self" aria-expanded="false" aria-controls="zone-saisi">
                            <i class="menu-icon fa fa-keyboard-o"></i>
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
                    <li class="nav-item">
                        <a class="nav-link" href="../../pages/forms/basic_elements.html">
                            <i class="menu-icon mdi mdi-settings"></i>
                            <span class="menu-title">Paramétrage</span>
                        </a>
                    </li>
                    <?php }?>

                </ul>
            </nav>
            <!-- Fin navigation -->
            <div class="main-panel" style="flex: auto !important;">
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
        </div>
    </div>
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
        function getPage(page = '', place = '', callback=false){
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

            // Get page content
            $.get(currentPage).then(function(data){
                $(place).html(data)
                if(callback){callback()}
            }, function(error){
                $(place).html($('#not-found-page').html())
            });
        }
        window.onpopstate = function (event){
            popState = true;
            getPage(document.location);
        }
    </script>
</body>
</html>