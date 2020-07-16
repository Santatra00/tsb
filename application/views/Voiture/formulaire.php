<form class="forms-sample" id="input-form"  url-save="ajouter" url-get="getVoiture">
    <input type="hidden" id="id-voiture" name="id" >
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                <label>Matricule</label>
                <input type="text" class="form-control input-form" name="voitu_matricule"
                    placeholder="Matricule de la voiture" required>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Marque</label>
                <input type="text" class="form-control input-form" name="voitu_marque"
                    placeholder="Marque de la voiture" required>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Edition</label>
                <input type="text" class="form-control input-form" name="voitu_edition"
                    placeholder="Edition de la voiture" required>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Nombre de place</label>
                <input type="text" class="form-control input-form" name="voitu_nbr_place" datatype='int'
                    placeholder="Nombre de place" required>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Numero du traceur</label>
                <select name="voitu_tracer_numero" id="" class="form-control input-form" datatype='int'>
                    <option selected disabled>Numero du traceur</option>
                <?php
                    if (isset($listTraceur)){                   
                        for ($i=0; $i < count($listTraceur); $i++) { 
                            $row = $listTraceur[$i];
                    ?>
                            <option><?= $row->tracer_numero?></option>
                        <?php        
                        }
                    }?>
                </select>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Chauffeur</label>
                <select name="cond_chauf_id" id="" class="form-control input-form" datatype='int'>
                    <option selected disabled>Chauffeur...</option>
                <?php
                    if (isset($listChauffeur)){                   
                        for ($i=0; $i < count($listChauffeur); $i++) { 
                            $row = $listChauffeur[$i];
                    ?>
                            <option value="<?= $row->chauf_id?>"><?= $row->chauf_nom?><?= $row->chauf_prenom?></option>
                        <?php        
                        }
                    }?>
                </select>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Photo</label>
                <input type="file" class="form-control input-form" name="voitu_photo"
                    placeholder="Edition de la voiture" datatype="file" required>
            </div>
        </div>
        
    </div>
</form>