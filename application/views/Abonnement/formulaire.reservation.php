<form class="forms-sample" id="input-form-reservation" url-save="reserver" url-get="getReservation">
    <input type="hidden" class="input-form-reservation" name="reserv_etu_id" >
    <div class="row">
        <div class="col-sm-7">
            <div class="form-group">
                <label>Etudiant</label>
                <input type="text" class="form-control input-form-reservation" name="reserv_etu_nom"
                    placeholder="Nom et prenom de l'etudiant (ou Numero maticule)" required>
            </div>
            <div id="form-voiture_marque" class="controlle-champ"></div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Date&Heure du voyage</label>
                <select name="voya_date" class="form-control input-form-reservation">
                    <option selected disable>Date et heure</option>
                    <option value="1">12/12/2020 a 12:20</option>
                </select>
            </div>
            <div id="form-voiture_type_voiture" class="controlle-champ"></div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Itineraire</label>
                <select name="voya_itine_nom" class="form-control input-form-reservation">
                    <option selected disable>Itineraire</option>
                    <option value="1">Mahazengy</option>
                </select>
            </div>
            <div id="form-voiture_type_voiture" class="controlle-champ"></div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="exampleFormControlSelect2">Point de ramassage</label>
                <select name="voya_point_ramassage" class="form-control input-form-reservation">
                    <option selected disable>Ramassage</option>
                    <option value="1">Rondpoint</option>
                </select>
            </div>
            <div id="form-voiture_type_voiture" class="controlle-champ"></div>
        </div>
        <div class="col-sm-12 ticket-place" style="margin-top: 20px">
            <div class="form-group">
                <label>Reservation effectuee</label>
                <table class="table table-striped" id="liste-reservation">
                    <thead>
                        <tr>
                            <th>
                                ID
                            </th>
                            <th>
                                Itineraire
                            </th>
                            <th>
                                Point de ramassage
                            </th>
                            <th>
                                Fait le
                            </th>
                            <th>
                                Pour un voyage du
                            </th>
                        </tr>
                    </thead>
                    <tbody id="body-liste-reservation">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>