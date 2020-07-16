<div class="badge badge-pill pl-2" style="display: inline-flex; height: 45px; color: black;">
    <span class="ml-2 mr-1" style='margin-top: 9px;'>
        <h4>Reservation par itineraire </h4>
    </span>
    <span class="ml-2 mr-2" style="width: 140px; height: 35px;">
        <select name="voyage_name" class="form-control d-inline ml-3" id="selectTypePeriode" style="width: 100%; height: 35px;">
            <option>Journalier</option>
            <option>Mensuel</option>
            <option>Annuelle</option>
        </select>
    </span>
    <span class="ml-2 mr-2" style="width: 140px; height: 35px;" id="spanSelectMois">
        <select name="voyage_name" class="form-control d-inline ml-3" id="selectMois" style="width: 100%; height: 35px;">
            <?php
                if (isset($listMois)){                   
                    for ($i=0; $i < count($listMois); $i++) { 
                        $row = $listMois[$i];
                ?>
                    <option value="<?= $row->mois?>"><?= $row->mois?></option>
                <?php        
                    }
                }?>
        </select>
    </span>
    <span class="ml-2 mr-2" style="width: 140px; height: 35px; display: none;" id="spanSelectAnnee">
        <select name="voyage_name" class="form-control d-inline ml-3" id="selectAnnee" style="width: 100%; height: 35px;">
            <?php
            if (isset($listAnnee)){                   
                for ($i=0; $i < count($listAnnee); $i++) { 
                    $row = $listAnnee[$i];
            ?>
                <option value="<?= $row->annee?>"><?= $row->annee?></option>
            <?php        
                }
            }?>
        </select>
    </span>
    <script>
        var listColor = ['#ff4747', '#4d83ff', '#ffc100', '#E91E63', '#3bd949', '#58d8a3', '#8ba2b5', '#ab8ce4'];
        var listItineraire = [ 
        <?php
            if (isset($listItineraire)){                   
                for ($i=0; $i < count($listItineraire); $i++) { 
                    $row = $listItineraire[$i];
            ?>
                "<?= $row->itine_nom?>",
            <?php        
                }
            }?>
        ];
        var lastAnnee = "<?=$lastAnnee->lastannee?>";
        var lastMois = "<?=$lastMois->lastmois?>";
        var listLabel = [];
        function chartBuilder(canvas, data, options){
            return new Chart(canvas, {
                type: 'line',
                data,
                options
            });
        }

        function designData(nameOfPropertie, data, itineraires, colors){
            let labels = getLabels(nameOfPropertie, data);
            let dataResult = {
                labels,
                datasets: itineraires.map(function(itineraire, i){
                    let dataFiltered =[];
                    for (let index = 0; index < labels.length; index++) {
                        const lab = labels[index];
                        let nombre = data.
                                        filter((e)=>e.itineraire == itineraire).
                                        filter((e)=>e[nameOfPropertie] == lab).
                                        map((d)=>d.nombre);
                            
                        if(nombre.length == 0){
                            dataFiltered.push(0)
                        }else{
                            dataFiltered.push(parseInt(nombre[0]))
                        }
                    }
                    return {
                        label: itineraire,
                        data: dataFiltered,
                        borderColor: [
                            colors[i%colors.length]
                        ],
                        borderWidth: 2,
                        fill: false,
                        pointBackgroundColor: "#fff"
                    };
                })
            };
            return dataResult;
        }

        function getLabels(nameOfPropertie, data){
            let listLabels = [];
            for (let index = 0; index < data.length; index++) {
                const element = data[index];
                var isFind = listLabels.find(function(label){
                    return label == element[nameOfPropertie]
                })
                if(isFind == undefined){
                    listLabels.push(element[nameOfPropertie]);
                }
            }
            return listLabels;
        }
    </script>
</div>