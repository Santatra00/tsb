<?php 
        
        if(isset($styles)) { 
            foreach($styles as $style) { 
?>
        <link rel="stylesheet" href="<?= base_url('assets/'.$style) ?>">
<?php 
            }
        }
  
?>
<style>
  .removeOnHover{
    height: 200px;
  }
  .removeOnHover:hover{
    height: 0px;
  }
</style>
<div class="row-card">
  <ul class="ul-card">
        <?php
          for ($i=0; $i < count($listVoiture); $i++) { 
            $voiture = $listVoiture[$i];
        ?>
          <li class="booking-card"
            style="background-image: url(<?php echo isset($voiture->voitu_photo)?($voiture->voitu_photo):base_url("uploads/bus-default.png")?>)">
            <div class="book-container">
              <div class="content">
              </div>
            </div>
          <div class="informations-container">
            <h2 class="title"><?=$voiture->voitu_marque?>: <?=$voiture->voitu_matricule?></h2>

            <div class="more-information">
              <div class="info-and-date-container">
                <p class="mb-1"><i class="fa fa-map-marker mr-2"></i>Mahazengy</p>
                <p class="mb-2"> <i class="fa fa-user mr-2"></i><?=$voiture->chauf_nom.' '.$voiture->chauf_prenom?> (<?=$voiture->chauf_tel?>)</p>
                <p class="mb-1 mt-3"><i class="fa fa-flash mr-2"></i>15 a 23 km/h</p>
                <p class="mb-1"><i class="fa fa-hourglass-2 mr-2"></i>3 exes de vitesse</p>
                <p class="mb-0"><i class="fa fa-exclamation-triangle mr-2"></i>5 Retard</p>
              </div>
            </div>
          </div>
        </li>
        <?php
          }
        ?>


  </ul>

  <p class="credits" style="display: none;">Designed by <a href="https://www.linkedin.com/in/ana%C3%AFs-laghzali-8b613297/"
      target="_blank" >Anaïs Laghzali</a> & developed by
    <a href="https://remiruc.com" target="_blank">Rémi Rucojevic</a><br>at
    <a href="https://www.hippocampe.fr" target="_blank">Hippocampe.fr</a></p>
</div>