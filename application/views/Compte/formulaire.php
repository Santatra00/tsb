<form class="forms-sample" id="input-form" url-save="<?= $urlSave ?>" url-get="<?= $urlGet ?>">
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                <label>Nom</label>
                <input type="text" class="form-control input-form" name="uti_nom"
                    placeholder="Nom de l'utilisateur" required>
            </div>
            <div id="form-voiture_marque" class="controlle-champ"></div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Prenom</label>
                <input type="text" class="form-control input-form" name="uti_prenom"
                    placeholder="Prenom de l'utilisateur" required>
            </div>
            <div id="form-voiture_type_voiture" class="controlle-champ"></div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Username</label>
                <input type="text" class="form-control input-form" name="username"
                    placeholder="Pseudo de l'utilisateur" required>
            </div>
            <div id="form-voiture_type_voiture" class="controlle-champ"></div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Telephone</label>
                <input type="text" class="form-control input-form" name="uti_tel"
                    placeholder="Telephone de l'utilisateur" required>
            </div>
            <div id="form-voiture_type_voiture" class="controlle-champ"></div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Email</label>
                <input type="text" class="form-control input-form" name="email"
                    placeholder="Email de l'utilisateur" required>
            </div>
            <div id="form-voiture_type_voiture" class="controlle-champ"></div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Groupe</label>
                <select id="group-select" name="id_group" multiple=multiple" style="width:100%;" class="input-form">
                    <?php foreach($listeGroupe as $group) { ?>
                        <option value="<?= $group->id ?>"><?= $group->name ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>        
        <div class="col-sm-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Password</label>
                <input type="password" class="form-control input-form" name="password"
                    placeholder="Password" required>
            </div>
            <div id="form-voiture_type_voiture" class="controlle-champ"></div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Confirm Password</label>
                <input type="password" class="form-control input-form" name="password_confirm"
                    placeholder="Confirmer password" required>
            </div>
            <div id="form-voiture_type_voiture" class="controlle-champ"></div>
        </div>
    </div>
    <script>
    $(function(){
        $("#group-select").select2()
    })
    </script>
</form>