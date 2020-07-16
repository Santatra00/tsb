<form class="forms-sample" id="input-form"  url-save="ajouter" url-get="getReservation">
    <input type="hidden" id="id-voiture" name="id" >
    <div class="row">
        
        <div class="col-sm-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Heure de depart</label>
                <input type="time" class="form-control input-form" name="heure_depart"
                    placeholder="Nom et prenom de l'etudiant" required>
            </div>
            <div id="form-voiture_type_voiture" class="controlle-champ"></div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Heure d'arrivee</label>
                <input type="time" class="form-control input-form" name="heure_arrivee"
                    placeholder="Nom et prenom de l'etudiant" required>
            </div>
            <div id="form-voiture_type_voiture" class="controlle-champ"></div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label>Choix de voiture</label>
                <select name="voitu_id" id="" class="form-control input-form">
                    <option disabled selected>Choisir...</option>
                    <?php
                    if (isset($listVoiture)){                   
                        for ($i=0; $i < count($listVoiture); $i++) { 
                            $row = $listVoiture[$i];
                    ?>
                        <option value="<?= $row->voitu_id?>"><?= $row->voitu_matricule?> (<?= $row->voitu_nbr_place?>place)</option>
                    <?php        
                        }
                    }?>
                </select>
            </div>
            <div id="form-voiture_marque" class="controlle-champ"></div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Voyage (allee ou retour)</label>
                <select name="reserv_allee" id="" class="form-control input-form">
                    <option value="true">Allee</option>
                    <option value="false">Retour</option>
                </select>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Passager<span class="badge badge-dark ml-2" id="nbPlace">23/24</span></label>
                <div class="" style='width: 100%;'>
                    <select name="passager_nom" id="passager_nombre" 
                        class="form-control input-form selectPassager d-inline"
                        style="width: 100%;" multiple="multiple">
                        <option value="07:00">07:00 (1)</option>
                        <option value="7">08:00 (23)</option>
                    </select>
                    
                </div>
            </div>
        </div>
        <script>
            var nb_place = 0;
            var selectedVoituId ;
            var selectedReservation;

            $(function(){
                $(".selectPassager").select2();
                $("[name='voitu_id']").on('change', function(){
                    let voitu_id = $(this).val()

                    listeVoitureStore.map(function(k, v){
                        console.log(k, voitu_id);
                      if(k.voitu_id == voitu_id){
                        nb_place = k.voitu_nbr_place;
                        $("#nbPlace").html('0/'+k.voitu_nbr_place);
                      }  
                      return 0;
                    })
                })

                $("#passager_nombre").on('change', function(){
                    let tIndexNombre = $(this).val()

                    // get somme reservation 
                    let somme = 0;
                    for (let index = 0; index < tIndexNombre.length; index++) {
                        const reserv_heure = tIndexNombre[index];
                        listeReservationStore.map(function(reservation, v){
                            console.log(reservation, reserv_heure);
                            if(reservation.reserv_heure == reserv_heure){
                                somme += parseInt(reservation.reserv_etu_total);
                            }
                            return 0;
                        })
                    }
                    console.log(somme)
                    $("#nbPlace").html(somme+'/'+nb_place);

                    // changer les donnees

                    // listeReservationStore.map(function(reservation, v){
                    //     console.log(reservation, reserv_heure);
                    //     if(reservation.reserv_heure == reserv_heure){
                    //         somme += parseInt(reservation.reserv_etu_total);
                    //     }  
                    //     return 0;
                    // })
                    
                })
            });
        </script>


        <!-- 
            Liste concentrer les reservations faite en cette journee, sur cette itineraire
            heure arrivee | nombre de reservation | action

            affichage: { voiture 1 | place | Etat | Action(annulee(en cours) - verifiee)}
         -->
    </div>
</form>