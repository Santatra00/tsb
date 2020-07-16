<form class="forms-sample" id="formulaire">
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                <label>Nom de ce point de ramassage</label>
                <input type="text" class="form-control input-form" name="point_nom"
                    placeholder="Nom du point" required>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Itineraire</label>
                <select name="point_itine_id" id="" class="form-control input-form" datatype='int'>
                    <option selected disabled>Itineraire ...</option>
                <?php
                    if (isset($listItineraire)){                   
                        for ($i=0; $i < count($listItineraire); $i++) { 
                            $row = $listItineraire[$i];
                    ?>
                            <option value="<?= $row->itine_id?>"><?= $row->itine_nom?></option>
                        <?php        
                        }
                    }?>
                </select>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">X</label>
                <input type="text" class="form-control input-form" name="point_x"
                    placeholder="X du point" required>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Y</label>
                <input type="text" class="form-control input-form" name="point_y"
                    placeholder="Y du point" required>
            </div>
        </div>
        
    </div>
</form>