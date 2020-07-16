var utils = {
    base_url : $('#base_url').val() ,
    currentDate : function(){
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1;
        var yyyy = today.getFullYear();
    
        if(dd<10) {
            dd = '0'+dd; 
        } 
    
        if(mm<10) {
            mm = '0'+mm; 
        } 
    
        today = dd + '/' + mm + '/' + yyyy;
    
        return today;
    },
    formSerialize : function(formId,inputClass,data=false){
        if(!data){
            var data = {};
            $(formId + ' ' + inputClass).each(function(){
                data[$(this).attr('name')] = $(this).val();
            });
            return data;
        }else{
            Object.keys(data).map(function(key,index){
                $(formId +' '+inputClass +'[name='+key+']').val(data[key]);
            });
        }
    },
    buttonLoader : function(buttonId,showLabel=true){
        var button = $(buttonId);
        var content = button.html();
  
        this.demarrer = function(){
            button.addClass('disabled');
            button.html('<span class="rotating fa fa-spinner"></span>'+ ((showLabel)?' En cours...':''));
        }
  
        this.terminer = function(){
            button.removeClass('disabled');
            button.html(content);
        }
    },
    filterTable : function(value, tableID){
        var isEmpty = false;
        $(tableID + " tr").filter(function() {
            isEmpty = $(this).text().toLowerCase().indexOf(value) <= -1;
            $(this).toggle(!isEmpty);
        });
        return isEmpty;
    },
    searchInArrayJson : function(tab, ref, value){
        var res = -1;
        for(var i=0; i<tab.length; i++){
            if(tab[i][ref] == value){
                res = i;
            }
        }
        return res;
    },
    clearCanvas: function(canvas){
        canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
        var w = canvas.width;
        canvas.width = 1;
        canvas.width = w;
    },
    randomColor : function(){
        return "#" + ((1<<24)*Math.random()|0).toString(16);
    },
    initializeChart3Axes : function(labels, datasets, canvas, uniteDeMesure=""){
        let ctx = canvas.getContext('2d');
        let chart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels : labels.xAxis1Labels,
              datasets : datasets
            },
            options : {
                scales : {
                    yAxes : [{
                      barPercentage: 0.3,
                      stacked: true
                    }],
                    xAxes : [{
                      ticks:{
                        autoSkip: false,
                        maxRotation: 90,
                        minRotation: 90,
                      },
                        stacked: true,
                        categoryPercentage:0.1,
                        barPercentage: 0.9
                    }]
                },
                legend : {
                    position : "right"
                },
                tooltips: {
                  callbacks : {
                    label : function(tooltipItem, data){
                        return label = data.datasets[tooltipItem.datasetIndex].label + ': '+ tooltipItem.yLabel +' '+uniteDeMesure;
                    }
                  }
                }
            }
        });
        if(labels.xAxis2Labels != undefined){
            var showlabel = function(){
                var ul = document.createElement('ul');
                $(ul).width($(canvas).width()-185);
                for(var i in labels.xAxis2Labels){
                    var li = document.createElement('li');
                    $(li).width((($(ul).width())/labels.xAxis1Labels.length) * labels.xAxis2Labels[i].nombreItem + "px");
                    $(li).text(labels.xAxis2Labels[i].label);
                    $(ul).append(li);
                }
                $("#chart-second-xAxis").html(ul);
                $(window).on('resize', function(){
                    showlabel();
                })
            }
            showlabel();
        }
    },
    verifyLongueur: function(name, min, max){
        longueur=$("[name='"+name+"']").val().length;
        if(longueur==0){
            $("#form-"+name).text("Champs obligatoire.");
            $("#form-"+name).fadeIn();
            return false;
        }else if((longueur<=min)||(longueur>=max)){
            $("#form-"+name).text("Ce champ doit contenir entre "+(min+1)+" et "+max+" caractères!");
            $("#form-"+name).fadeIn();

            console.log("Erreur! longueur champ "+name+" est "+longueur);
            return false;
        }{
            console.log("Reussi! longueur champ "+name+" est "+longueur);
            return true;
        }
    },
    getDataForm: async function(input_class){
        let data = {};
        for (let index = 0; index < $(input_class).length; index++) {
            const element = $(input_class)[index];
            const datatype = $(input_class)[index].attributes.getNamedItem('datatype');
            let val =  element.value;

            if(datatype != null){
                if(datatype.value == 'int'){
                    val = parseInt(val);
                    console.log('Int value', val);
                }else if(datatype.value == 'float'){
                    val = parseFloat(val);
                }else if(datatype.value == 'file'){
                    val = await this.uploadFile($(input_class)[index])
                }
            }
            data[element.name] = val;
        }
        return data;
    },
    setDataForm:function(input_class, data){
        for (let index = 0; index < $(input_class).length; index++) {
            const name = $(input_class)[index].name;
            $('[name="'+name+'"]').val(data[name]||'');
            if(typeof(data[name]) == 'object'){
                $('[name="'+name+'"]').trigger('change');
            }
        }
    },
    resetDataForm:function(input_class){
        for (let index = 0; index < $(input_class).length; index++) {
            const name = $(input_class)[index].name;
            if(typeof($('[name="'+name+'"]').val()) == 'object'){
                $('[name="'+name+'"]').val([]);
                $('[name="'+name+'"]').trigger('change');
            }else{
                $('[name="'+name+'"]').val('');
            }
        }
    },
    uploadFile: async function (file){ 
        var formData = new FormData();
        if(file.files.length == 0){
            return '';
        }
        let fileToUpload = file.files[0];
        formData.append('file', fileToUpload);
        let link = '';
        await $.ajax({
            url: utils.base_url + 'Upload/do_upload',
            type: 'POST',
            enctype: 'multipart/form-data',
            data:formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function(response){
                console.log(response)
                link = response.link
            },
            error: function(error){
                console.log("Error", error);
                link = ''
            }
        });
        return this.base_url+link;
    },
    createTable: function(data, propertiesName, placeId){
        $("#"+placeId).html('');
        let htmlValue = '';
        for (let index = 0; index < data.length; index++) {
            const element = data[index];
            htmlValue += '<tr>'
            for (let indexObject = 0; indexObject < propertiesName.length; indexObject++) {
                const name = propertiesName[indexObject];
                htmlValue += '<td class="td-sandwitch">' + element[name] + '</td>';
            }
            htmlValue += '</tr>'
        }
        $("#"+placeId).html(htmlValue);
    },
    designPropriete: function (props){
        // transforme l'objet props en parametre pour une requette GET
        let parametre = '?';
        for (let index = 0; index < Object.entries(props).length; index++) {
            if(index >=1){
                parametre += '&'
            }
            parametre += Object.entries(props)[index][0] + '=' + Object.entries(props)[index][1]
        }
        return parametre;
    },
    closeNavBar: function(){
        console.log('closeNavBar');
        $('#main').css('margin-top', '-24px');
        $("#nav-haut").css('height', '0px')
        $(".profile-text").hide()
        $("#content-page").addClass('p-0');
    },
    openNavBar: function(){
        console.log('openNavBar');
        $('#main').css('margin-top', '64px');
        $("#nav-haut").css('height', '64px')
        $(".profile-text").show()
        $("#content-page").removeClass('p-0');
    },
    openSideBarTrajet: function(callback){
        $('#navbar-top').css('margin-right', '20%');
        $("#sidebar-trajet").css('width', '280px')
        if(callback){
            setTimeout(() => {
                callback();
            }, 3500);
        }
    },
    closeSideBarTrajet: function (callback){
        $('#navbar-top').css('margin-right', '0%');
        $("#sidebar-trajet").css('width', '0px');
        if(callback){
            setTimeout(() => {
                callback();
            }, 3500);
        }
    },
    alleeToString: function(allee){
        return (allee)?'Allee':'Retour';
    },
    formatDate: function(date){
        return date.substr(8, 2)+'/'+date.substr(5, 2)+'/'+date.substr(0, 4)
    }
}