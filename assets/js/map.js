mapboxgl.accessToken = 'pk.eyJ1IjoiaXRkYyIsImEiOiJja2Jpem11dTgwazNlMnJsc3MydTQ2bzg0In0.Njfhqx6muK6d6oKnAadFEw';
map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [47.095997, -21.455729],
    zoom: 13,
});
map.on('load', function() {
  let data =  {
    type: 'geojson',
    data: {
      "type": "FeatureCollection",
      "features": []
      }
  };
  map.addSource('itineraire',data);
  map.addSource('trace',data);
  map.addSource('ramassage',data);

  map.addLayer({
    'id': 'itineraireLayer',
    "type": "line",
    'source': 'itineraire',
    'layout': {},
    'paint': {
      'line-width': 5,
      "line-color": "rgb(88, 166, 221)"
    },
  });
  map.addLayer({
    'id': 'traceLayer',
    "type": "line",
    'source': 'trace',
    'layout': {
      'line-join': 'round',
      'line-cap': 'round'
    },
    'paint': {
      'line-color': '#888',
      'line-width': 4
    }
  });
  getAllTrajet();
  tick(function(){
    if(isVoitureIsLoad){
      getCoordonnee();
    }else{
      console.log(1101)
    }
  })
})

var markers =[];
var isVoitureIsLoad = false;

var store = {
  voyages: [],
  itineraires: []
};
var state = {
  voya_id: 1,
  voya_heure_depart: 2,
  voya_heure_arrive: 3,
  voya_active: '',
  trajet:[
    {
      'itine_id': '',
      'ramassage': [{
        point_id: '',
        X: 0,
        Y: 0
      }],
      'voitures' : [
        {
          voit_id: '',
          voitu_name: '', 
          heure_depart: '',
          heure_arrive: '',
          'points' : [
            {
              point_id: '1234567', 
              heure: '23:33:55',
              X: -12.34,
              Y: -76.89
            }
          ]
        }
      ]
    }
  ],
  voitures: []
}
var kmlStore=[];
var rechercheEnCours = 0;
var trajetTest = [];
var tickTiming = 15;
function tick(callback = false){
  setInterval(() => {
    if(callback){callback()}
  }, tickTiming * 1000);
}
function showLoading(){
  rechercheEnCours++;
  changeSidebarTrajet(2)
}
function hideLoading(){
  rechercheEnCours--;
  if(rechercheEnCours == 0){
    changeSidebarTrajet(1)
  }
}

// fonctions
function showItineraireList(){
  let itineraireHtml = '';
  let isVoitureExist = false;

  for (let index = 0; index < state.itineraires.length; index++) {
    const itineraire = state.itineraires[index];
    itineraireHtml += '<li class="card nav-item m-2 p-1" style="background-color: white; height: 240px;"><p class="mt-1 ml-2"><b>Itineraire ';
    itineraireHtml += (index+1);
    itineraireHtml += '</b>: '+itineraire.itine_nom +'<br>';
    if(itineraire.voitures.length != 0){
      itineraireHtml += '<div id="voiture-i'+itineraire.itine_id+'"></div>'
    }
    //     Bus: 1 en route
    // </p>
    // <img class="img-xs" id="btn-close-sidebar-trajet" src="<?= base_url('./assets/images/vehicles-set_1308-31099-bus.jpg') ?>" alt="Bus image">
    // <p class="mt-1 ml-2"><b>Transport: 23 personnes</b><br>
    //     a Ampasambazaha
    // </p>
    itineraireHtml +='</li> ';
  }
  $("#itineraireList").html(itineraireHtml);
  
}
function showVoitureList(){
  let isVoitureExist = false;
  for (let index = 0; index < state.itineraires.length; index++) {
    const itineraire = state.itineraires[index];
    let itineraireHtml='';
    if(itineraire.voitures.length != 0){
      isVoitureExist = true;
      itineraireHtml = '<div class="swiper-container"><div class="swiper-wrapper">';
      for (let indexBus = 0; indexBus < itineraire.voitures.length; indexBus++) {
        const voiture = itineraire.voitures[indexBus];
        itineraireHtml += '<div class="swiper-slide">';
        itineraireHtml += '<span>Bus:</span>'+indexBus+'</br>';
        itineraireHtml += voiture.voitu_matricule;
        itineraireHtml += '</div>';
      }
      itineraireHtml += '</div><div class="swiper-pagination"></div><div class="swiper-button-prev"></div><div class="swiper-button-next"></div></div>';
      $("#voiture-i"+itineraire.itine_id).html(itineraireHtml);
    }
  }
  if(isVoitureExist){
    var mySwiper = new Swiper ('.swiper-container', {
      // Optional parameters
      direction: 'horizontal',
      // If we need pagination
      pagination: {
        el: '.swiper-pagination',
      },
  
      // Navigation arrows
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    })
  }
}

function showPRamassageOnItineraire(itine_id = 0){
  // if itine_id == 0 show all point
  for (let j = 0; j < state.itineraires.length; j++) {
    const itineraire = state.itineraires[j];
    if((itine_id==itineraire.itine_id)||(itine_id == 0)){
      for (let index = 0; index < itineraire.ramassages.length; index++) {
        const point = itineraire.ramassages[index];

        var el = document.createElement('div');
        el.className = 'marker-ramassage';
        // make a marker for each feature and add to the map
        var marker = new mapboxgl.Marker(el)
        .setLngLat([parseFloat(point.point_y), parseFloat(point.point_x)])
        .addTo(map);
      }
    }
  }
  
}

function showVoiture(voit_id = 0){
  // show all if voit_id == 0
}

function showVoitureOnItineraire(itine_id = 0){
  // show all if itine_id == 0
}

function showItineraire(itine_id = 0){
  if(itine_id != 0){
    for (let index = 0; index < store.itineraires.length; index++) {
      const itineraire = store.itineraires[index];
      let features = [];
      fetch(itineraire.coordonnees)
      .then(function (response) {
        if (response.status === 200 || response.status === 0) {
          return Promise.resolve(response.blob());
        } else {
          return Promise.reject(new Error(response.statusText));
        }
      })
      .then(JSZip.loadAsync)
      .then(function (zip) {
        return zip.file(/.*\.kml/)[0].async("string");
      })
      .then(function success(kml) {
        var p = omnivore.kml.parse(kml);
        features.push(p._layers[p._leaflet_id - 1].feature);
        if(features.length == store.itineraires.length){
          let data = {
            type: "FeatureCollection",
            features
          }
          trajetTest = data;
          console.log("set data in itineraire shower");
          map.getSource('itineraire').setData(data);
          showItineraireList();
        }
      });
    }
  }else{
    nbItineraireToShow = store.itineraires.length;
    let data = {
      "type": "FeatureCollection",
      "features": []
    }
    for (let index = 0; index < store.itineraires.length; index++) {
      const itineraire = store.itineraires[index];
      fetch(itineraire.coordonnees)
      .then(function (response) {
        if (response.status === 200 || response.status === 0) {
          return Promise.resolve(response.blob());
        } else {
          return Promise.reject(new Error(response.statusText));
        }
      })
      .then(JSZip.loadAsync)
      .then(function (zip) {
        return zip.file(/.*\.kml/)[0].async("string");
      })
      .then(function success(kml) {
        var p = omnivore.kml.parse(kml);
        kmlStore.push(p)
        data.features.push(p._layers[p._leaflet_id - 1].feature);
        trajetTest = data;
        nbItineraireToShow--;
        console.log("nombre de itineraire restant", nbItineraireToShow);

        if(nbItineraireToShow == 0){
          map.getSource('itineraire').setData(data);
          console.log("set many data in itineraire shower");
          showItineraireList();

        }
      })
    }
  }
}

function getXYBus({voyage, trajets:[{traj_id, voiture: {voit_id, point_id}}]}){
// get reste of coordinate 
}

function getCoordonnee(){
  let day = $("#datePicker").val();
  if($("#selectVoyage").val() == 'live'){
    day = '';
  }
  // get all the coordinate of all voiture
  let voitures = state.voitures; 
  for (let iVoiture = 0; iVoiture < voitures.length; iVoiture++) {
    const voiture = voitures[iVoiture];
    $.get(utils.base_url + 'Carte/getMarkerOfVoiture', {voitu_id: voiture.voitu_id, heure_depart: voiture.poss_heure_initial, heure_arrive: voiture.poss_heure_final, day, me: 'ws'})
      .done(function(response){
        for (let iResponse = 0; iResponse < response.msg.length; iResponse++) {
          const coordonnees = response.msg[iResponse];
          for (let iC = 0; iC < coordonnees.length; iC++) {
            const coordonnee = coordonnees[iC];

            for (let iiVoiture = 0; iiVoiture < state.voitures.length; iiVoiture++) {
              if(coordonnee.voitu_id == state.voitures[iiVoiture].voitu_id){
                if(state.voitures[iiVoiture].points == undefined){
                  state.voitures[iiVoiture].points = [];
                }
                let res = state.voitures[iiVoiture].points.find(function(p){
                  return p.tracer_id == coordonnee.tracer_id
                })
                if(res == undefined){
                  state.voitures[iiVoiture].points.push(coordonnee); 
                }
              }
            } 
          }
           
        }
        showTrace();
        showVoiturePosition();
      })
      .fail(function(err) {
        console.log(err);
      })
  }
  
}
function showTrace(){
  let data = {
    "type": "FeatureCollection",
    "features": []
  }
  for (let iiVoiture = 0; iiVoiture < state.voitures.length; iiVoiture++) {
    data.features.push({
      "type": "Feature",
      "geometry": {
        "type": "LineString",
        "coordinates": state.voitures[iiVoiture].points.map(function(point){
                        console.log(point);
                        return [point.tracer_x, point.tracer_y];
                      })
      },
      "properties": {
        "name": "Trace-" + state.voitures[iiVoiture].voitu_id
      }
    });
  }
  console.log(data);
  map.getSource('trace').setData(data);
}
function showVoiturePosition(){
  for (let iiVoiture = 0; iiVoiture < state.voitures.length; iiVoiture++) {
    const voiture = state.voitures[iiVoiture];
    if(markers[voiture.voitu_id] != undefined){
      markers[voiture.voitu_id].remove();
    }

    var el = document.createElement('div');
        el.className = 'marker-voiture';
    var marker = new mapboxgl.Marker(el)
      .setLngLat([parseFloat(voiture.points[voiture.points.length - 1].tracer_x), parseFloat(voiture.points[voiture.points.length - 1].tracer_y)])
      .addTo(map);
    markers[voiture.voitu_id]=marker;
  }
}

function getAllThing(){

}

function getAllVoiture(voya_id, itine_id){
  // get all voiture
  // SI le voyage est 0 ca veux dire que aucunne voyage en particulier n'est choisi, 
  // ce qui veux dire que on get all voiture in a intervall and day
  $.get(utils.base_url + 'Voiture/getByVoyage', {voya_id, itine_id, me: 'ws'})
    .done(function(response){
      for (let iVoiture = 0; iVoiture < response.msg.length; iVoiture++) {
        const voiture = response.msg[iVoiture];
        for (let index = 0; index < state.itineraires.length; index++) {
          if(state.itineraires[index].itine_id == voiture.poss_itine_id){
            state.itineraires[index]['voitures'].push(voiture);
          }
        }
        for (let index = 0; index < response.msg.length; index++) {
          const voiture = response.msg[index];
          let res ;
          res = state.voitures.find(function(v){
            return v.voitu_id == voiture.voitu_id;
          });
          if(res == undefined){
            state.voitures.push(voiture);
          }
        }

        
      }

      showVoitureList();
      isVoitureIsLoad = true;
    })
    .fail(function(err) {
      console.log(err);
    })
}

function getAllRamassage(itine_id, callback=false){
  // get all the coordinate
  $.get(utils.base_url + 'Ramassage/getRamassageByItineraire', {itine_id, 'me': 'ws'})
    .done(function(response){
      const points = response.msg;      
      for (let index = 0; index < state.itineraires.length; index++) {
        if(state.itineraires[index].itine_id == itine_id){
          console.log('trouvee');
          state.itineraires[index]['ramassages']=points;
        }else{
          console.log(state.itineraires[index].itine_id, itine_id);
        }
      }
      if(callback){callback()}
    })
    .fail(function(err) {
      console.log(err);
    })
}

function getAllTrajet(voya_id = 0){
  // get all itineraire
  $.get(utils.base_url + 'Itineraire/getItineraireByVoyage', {voya_id, 'me': 'ws'})
    .done(function(response){
      store.itineraires = response.msg;
      state.itineraires = response.msg;
      // mettre les information a cotee du titre
      // setInfo(response.msg);
      
      showItineraire();
      for (let index = 0; index < state.itineraires.length; index++) { 
        state.itineraires[index]['voitures'] = [];
        getAllRamassage(state.itineraires[index].itine_id, ()=>showPRamassageOnItineraire(state.itineraires[index].itine_id))
        getAllVoiture(voya_id, state.itineraires[index].itine_id);
      }
    })
    .fail(function(err) {
      console.log(err);
    })
}

function getAllVoyageWithDate(dateSelected){
  let now = new Date();
  jNow = now.toISOString().substr(8, 2)
  mNow = now.toISOString().substr(5,2);
  yNow = now.getFullYear();
  
  // formater la date
  let j = dateSelected.substr(8, 2);
  let m = dateSelected.substr(5, 2);
  let a = dateSelected.substr(0, 4);
  
  console.log((jNow+'/'+mNow+'/'+yNow),(j+'/'+m+'/'+a), dateSelected);
  // aleo atao timestamp
  // loading
  $("#selectVoyage").html('<option selected disabled>Chargement ...</option>')
  // get all voyage and put desctipyion in selectVoyage
  $.get(utils.base_url + 'Carte/getVoyageOnDate', {'voya_date': m+'/'+j+'/'+a, 'me': 'ws'})
    .done(function(response){
      store.voyages = response.msg;
      if(response.msg.length == 0){
        if((jNow+'/'+mNow+'/'+yNow)==(j+'/'+m+'/'+a)){
          $("#selectVoyage").html('<option value="live" selected disabled>En direct</option>')
        }else{
          $("#selectVoyage").html('<option selected disabled>Aucune</option>')
        }
      }else{
        let data = response.msg;
        let options = '<option selected disabled>Heure </option>';
        if((jNow+'/'+mNow+'/'+yNow)==(j+'/'+m+'/'+a)){
          options += '<option value="live">En direct</option>';
        }
        for (let index = 0; index < data.length; index++) {
          options += '<option value="'+data[index].voya_id+'">'+data[index].voya_heure_depart+' ('+utils.alleeToString(data[index].voya_allee)+') </option>';
        }
        $("#selectVoyage").html(options);
      }
    })
    .fail(function(err) {
      $("#selectVoyage").html('<option selected disabled>Erreur serveur</option>');
      console.log(err);
    })
}
// Jerena ny heure actuel de jerena izay akaiky indrindra azy @ voyage omena
function formatTitre(nombre, nomInfo){
  return '<span class="ml-4 white-color" style="margin-top: 13px; display: inline-block;"><h5><b>'+nombre+'</b>:'+nomInfo+'</h5></span>';
}

function setTitre(data){
  let titre = '';
  for (let index = 0; index < data.length; index++) {
    const info = data[index];
    titre += formatTitre(info);
  }
  $("#info-titre").html(titre);
}

// events
$(function(){
  $(".titre-option").hide();
  $("#datePicker").on('change', function(){
    getAllVoyageWithDate($("#datePicker").val())
  })
  $("#selectVoyage").on('change', function(){
    let voya_id = $("#selectVoyage").val();

    if(voya_id != "live"){
      for (let index = 0; index < store.voyages.length; index++) {
        const voyage = store.voyages[index];
        if(voyage.voya_id == voya_id){
          state = voyage;
          break;
        }
      }
      getAllTrajet(voya_id);
      // getAllVoiture({id_voyage});
    }else{
      getAllTrajet();
    }
  })
  console.log('event declared');
  // initialisation de la carte pour afficher toute les routes
})

// map.setCenter([-21.455729, 47.095997]);
// var marker = new mapboxgl.Marker()
// .setLngLat([47.095997, -21.455729])
// .addTo(map);

// add road
// var runLayer = omnivore.kml('/mapbox.js/assets/data/line.kml')
// .on('ready', function() {
//     map.fitBounds(runLayer.getBounds());
// })
// .addTo(map);