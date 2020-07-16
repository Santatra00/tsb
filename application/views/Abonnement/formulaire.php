<form class="forms-sample" id="input-form" url-save="ajouter" url-get="getAbonnement">
    <input type="hidden" class="input-form" name="abon_etu_id" >
    <div class="row">
        <div class="col-sm-7">
            <div class="form-group">
                <label>Etudiant</label>
                <input type="text" class="form-control input-form" name="abon_etu_nom"
                    placeholder="Nom et prenom de l'etudiant (ou Numero maticule)" required>
            </div>
            <div id="form-voiture_marque" class="controlle-champ"></div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Nombre de ticket</label>
                <input type="text" class="form-control input-form" name="nombre_ticket"
                    placeholder="Nombre de ticket" required>
            </div>
            <div id="form-voiture_marque" class="controlle-champ"></div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Date de payement</label>
                <input type="date" class="form-control input-form" name="abon_date"
                    placeholder="Prenom du chauffeur" required>
            </div>
            <div id="form-voiture_type_voiture" class="controlle-champ"></div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Date de validite</label>
                <input type="date" class="form-control input-form" name="date_validite"
                    placeholder="Telephone du chauffeur" required>
            </div>
            <div id="form-voiture_type_voiture" class="controlle-champ"></div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Par</label>
                <input type="text" class="form-control" name="user_id" 
                    value="<?= $this->session->userdata('nom').' '.$this->session->userdata('prenom')?>">
            </div>
            <div id="form-voiture_type_voiture" class="controlle-champ"></div>
        </div>
        <div class="col-sm-12 ticket-place" style="margin-top: 20px">
            <div class="form-group">
                <label>Tickets valide</label>
                <table class="table table-striped" id="liste-ticket">
                    <thead>
                        <tr>
                            <th>
                                ID
                            </th>
                            <th>
                                Ticket(s)
                            </th>
                            <th>
                                Du
                            </th>
                            <th>
                                Valable jusqu'a
                            </th>
                            <th>
                                Par
                            </th>
                        </tr>
                    </thead>
                    <tbody id="body-liste-ticket">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>