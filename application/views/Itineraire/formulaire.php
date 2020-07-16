<form class="forms-sample" id="formulaire-voiture">
    <input type="hidden" id="id-voiture" name="id" >
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                <label>Nom Itineraire</label>
                <input type="text" class="form-control input-form" name="itine_nom"
                    placeholder="Matricule de la voiture" required>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Description</label>
                <input type="text" class="form-control input-form" name="itine_description"
                    placeholder="Marque de la voiture" required>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Coordonnees</label>
                <input type="file" class="form-control input-form" name="coordonnees"
                    placeholder="Edition de la voiture" datatype="file" required>
            </div>
        </div>
    </div>
</form>