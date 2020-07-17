<script>
        modalState = '';
        idOnUpdate = 0;
        dataDetails = {};
        function changeDatatable(){
            $("#datatable_filter").children()[0].classList.add('input-group');
            $("#datatable_filter").children()[0].firstChild =$('#loupe-icon')
            // $("#datatable_filter").children()[0].innerText= '';
            $("#datatable_filter").children()[0].children[0].append('<div class="input-group-prepend bg-primary border-primary"><span class="input-group-text bg-transparent"><i class="fa fa-search text-white"></i></span></div>');
        }
        function changeButtonSave(btn_name){
            modalState = btn_name;
            if(modalState == 'Modifier'){
                $('#send-data').html('<i class="fa fa-save"></i>Modifier')
            }else if(modalState == 'Enregistrer'){
                $('#send-data').html('<i class="fa fa-save"></i>Enregister')
            }else{
                $('#send-data').html('<i class="fa fa-save"></i>'+btn_name)
            }
        }
        function hideModal(){
            $('.modal-part').modal('hide')
        }
        function getUrl(nomUrl){
            let url = utils.base_url + nomPage + ((modalState=='Modifier')?'/update':'/save');
            if(nomUrl == 'url-get'){
                url = utils.base_url + nomPage + '/lister';
            }
            
            if($('#input-form').attr(nomUrl) != undefined){
                url =  utils.base_url + nomPage + '/' + $('#input-form').attr(nomUrl);
            }
            return url;
        }
        $(function(){
            if(typeof(btn_detail_callback) == 'undefined'){
                btn_detail_callback = function (data){
                    console.log('details');
                }
            }
            $('.modal-btn').click(function () {
                changeButtonSave('Enregistrer')
                $('.modal-part').modal('show')
                utils.resetDataForm('.input-form')
            })
            $('.btn-supprimer').click(function () {
                let id = $(this).attr('id');
                console.log('Delete')
                $.ajax({
                    url: baseUrl + nomPage + '/delete',
                    data: {id},
                    method: 'POST', 
                    success: function(response){
                        getPage();
                    },
                    error: function(error){
                        // Notifier erreur
                        notifier("Erreur de suppression", 'erreur');
                        console.log(error);
                    }
                });
            })
            $('.btn-detail').click(function () {
                let id = $(this).attr('id');
                idOnUpdate = id;
                if($(this).attr('action')!= undefined){
                    changeButtonSave($(this).attr('action'))
                }else{
                    changeButtonSave('Modifier')
                }
                let url = getUrl('url-get');
                $.ajax({
                    url,
                    data: {id, me: 'ws', dataDetails},
                    method: 'GET', 
                    success: function(response){
                        $('.modal-part').modal('show');
                        utils.setDataForm('.input-form', response.msg)
                        btn_detail_callback(response.msg)
                        dataDetails = {};
                    },
                    error: function(error){
                        // Notifier erreur
                        dataDetails = {};
                        notifier("Erreur d'affichage de details", 'erreur');
                        console.log(error);
                    }
                });
            })
            $('.send-data').click(async function(){
                // serialiser le formulaire
                let data = await utils.getDataForm('.input-form');
                let contenueButton = $(this).html()
                let that = $(this);
                // let url = utils.base_url + nomPage + ((modalState=='Modifier')?'/update':'/save');
                let url = getUrl('url-save');
                $(this).html('En cours ...')

                if(modalState=='Modifier'){
                    data['id']= idOnUpdate;
                }

                // send data
                $.ajax({
                    url,
                    type: 'post',
                    data,
                    success: function(response){
                        hideModal()

                        that.html(contenueButton);

                        // notifier reussi

                        // reset form
                        utils.resetDataForm('.input-form');

                        // reload page
                        setTimeout(() => {
                            getPage();
                        }, 1100);
                    },
                    error: function(error){
                        $(this).html(contenueButton);
                        console.log(error);
                    }
                });
            })
            $("#datatable").DataTable();
            $(".notifyjs-corner").css('font-size','13px');
        })
    </script>
