var url_compte = {
    ajouterCompte : utils.base_url + 'compte/ajouterCompte/',
    nouveauCompte : utils.base_url + 'compte/nouveauCompte/',
    listeCompte : utils.base_url + 'compte/listeCompte',
    detailCompte : utils.base_url + 'compte/detailCompte/',//+id
    supprimerCompte : utils.base_url + 'compte/supprimerCompte/'//+id
}
var obj_etu={};
var id_compte="";
function actualiserListeCompte(callback=false){
    $.get(url_compte.listeCompte, function(listeCompte){
        $('#body-liste-compte').html(listeCompte);
        activateButtonSupprimer();
        activateButtonModifier();
        activateDetaillerImage();

        if(callback) callback();
    })
};

$("#form-mdp-invalide").fadeOut();
$("#form-mdp-compte-existant").fadeOut();

$(function(){
    
      
    $('#btn-ajouter-compte').on('click',function(){
        id_compte="";
        $.get(url_compte.nouveauCompte, function(detail){
            $('#modal-formulaire-compte .formulaire-container').html(detail);
            $('#modal-formulaire-compte').modal('show');
            $('#personnel-select').select2({
                templateSelection: formatState
            });
            $("#group-select").select2();
        })
               

    });
    $('#input-rechercher-compte').on('keyup', function(){
        var value = $(this).val();
        var isEmpty = utils.filterTable(value, '#body-liste-compte');
        if(isEmpty){
            $("#msg-liste-vide").show();
        }else{
            $("#msg-liste-vide").hide();
        }

    })
    $('#btn-enregistrer-compte').on('click',function(){
        var info_compte = utils.formSerialize("#formulaire-compte", '.fc-compte');

        verifierForm(function(){
            console.log("Envoye de formulaire");
            $.post(url_compte.ajouterCompte+id_compte, { compte : info_compte }, function(id){
                actualiserListeCompte(function(){
                    $('#modal-formulaire-compte').modal('hide');
                });
            });
        });
        
    });
    
    activateButtonSupprimer();
    activateButtonModifier();
    activateDetaillerImage();
});
function formatState (state) {
    if (!state.id) {
      return state.text;
    }
    $("[name='nom']").val(state.element.attributes.nom.value);
    $("[name='prenom']").val(state.element.attributes.prenom.value);
    console.log(state);
    st=state;
    var $state = $(
      '<span><img src="' +  state.element.attributes.photo.value+ '" class="img-flag" /> ' + state.text + '</span>'
    );
    return $state;
};


function activateButtonSupprimer(){
    $('.btn-supprimer-compte').on('click', function(){
        var id = $(this).attr('id');
        $.confirm({
            icon: 'fa fa-warning',
            title: 'Suppression',
            content: 'Voulez-vous vraiment supprimer ce compte?',
            type: 'red',
            buttons: {
                valider: {
                    text: 'Valider',
                    btnClass: 'btn-danger',
                    action: function(){
                        $.get(url_compte.supprimerCompte + id, function(){
                            actualiserListeCompte();
                        })
                    }
                },
                annuler: {
                    text : 'Annuler',
                    btnClass : 'btn'
                }
            }
        });
    })
}
function activateButtonModifier(){
    $('.btn-detail-compte').on('click', function(){
        var id = $(this).attr('id');
        id_compte=id;
        $('#id-compte').val($(this).attr('id'));
        console.log(id);
        var buttonLoader = new utils.buttonLoader(this,false);
        buttonLoader.demarer();
        $.get(url_compte.detailCompte+id, function(detail){
            buttonLoader.terminer();
            $('#modal-formulaire-compte .formulaire-container').html(detail);
            $('#modal-formulaire-compte').modal('show');
            $('#personnel-select').select2({
                templateSelection: formatState
            });
            $("#group-select").select2();
            

            var idCompte=$("#id-compte").val()+"";
            $('#personnel-select').val(idCompte); 
            $('#personnel-select').trigger('change');
             
            var valeurUtile=$("#valeur_selected").val();
            $("#group-select").val(JSON.parse(valeurUtile));
            $("#group-select").trigger('change');  
        })
    });
}
function activateDetaillerImage(){
    $('.image-detaillable').on('click', function(){
        src_image = $(this).children().attr("src");
        console.log(src_image);

        $("#modal-formulaire-image").modal("show");
        $("#btn-fermer-image").on("click", function(){
            $("#modal-formulaire-image").modal("close");
        });
        $("#group-select").select2();
        var valueSelected=$("#group-select").attr("selectValue");
        console.log(valueSelected);
        $("#group-select").val(valueSelected);
        $("#group-select").trigger("change");
        $("#image-detail").attr("src", src_image);
        $("#username-detail").text($(this).parent().get(0).childNodes[3].innerText);
        $("#name-detail").text($(this).parent().get(0).childNodes[5].innerText);
        $("#last-name-detail").text($(this).parent().get(0).childNodes[7].innerText);
        $("#email-detail").text($(this).parent().get(0).childNodes[9].innerText);

        console.log($(this).parent().get(0));
    });
}
function verifierForm(callback=false){
    $("#form-mdp-invalide").fadeOut();
    $("#form-mdp-compte-existant").fadeOut();
    if(id_compte==""){
        $.get(utils.base_url+"compte/isExistUsername/"+$("#his-username").val(), function(detail){
            detail=JSON.parse(detail);
            if(detail.result=="true"){
                console.log("Username existant");
                $("#form-mdp-compte-existant").fadeIn();
                $("#form-mdp-compte-existant").text("Cette pseudo est dejà prise.");
                return false   
            }else{
                if($("[name='password']").val()!=$("[name='confirm_password']").val()){
                    console.log("Password à verifier");
                    $("#form-mdp-invalide").fadeIn();
                    $("#form-mdp-invalide").text("Veuillez bien confirmer le mot de pass.");
                    return false;
                }else{
                    if($("[name='password']").val().length<6){
                        $("#form-mdp-invalide").fadeIn();
    
                        $("#form-mdp-invalide").text("Veuillez mettre un mot de pass de longueur supperieur à 6");
                        return false;
                    }else{
                        console.log("Formulaire OK");
                        if(callback) callback();
                        return 0;
                    }
                    
                }
            }
        });
    }else{
        if(callback) callback();

    }
    
}