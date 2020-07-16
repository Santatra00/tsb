$('.modal-btn').click(function () {
    $('.modal-part').modal('show')
})
function toMonth(mois) {
    switch (mois) {
        case "01":
            return "Janvier";
            break;
        case "02":
            return "Février";
            break;
        case "03":
            return "Mars";
            break;
        case "04":
            return "Avril";
            break;
        case "05":
            return "Mai";
            break;
        case "06":
            return "Juin";
            break;
        case "07":
            return "Juillet";
            break;
        case "08":
            return "Août";
            break;
        case "09":
            return "Septembre";
            break;
        case "10":
            return "Octobre";
            break;
        case "11":
            return "Novembre";
            break;
        case "12":
            return "Decembre";
            break;
        default:
            return "Janvier";
            break;
    }
}
function toJour(jour) {
    switch (jour) {
        case 'Mon':
            return "Lundi";
            break;
        case 'Tue':
            return "Mardi";
            break;
        case 'Wed':
            return "Mercredi";
            break;
        case 'Thu':
            return "Jeudi";
            break;
        case 'Fri':
            return "Vendredi";
            break;
        case 'Sat':
            return "Samedi";
            break;
        case 'Sun':
            return "Dimanche";
            break;
        default:
            break;
    }
}
function showDateInMenu(){
    let now = new Date();
    iNow = now.toDateString().substr(0, 3);
    jNow = now.toISOString().substr(8, 2);
    mNow = now.toISOString().substr(5, 2);
    yNow = now.getFullYear();
    $("#daySideBar").html(toJour(iNow)+" "+jNow+" "+toMonth(mNow)+" "+yNow);
}
function showHour(){
    let now = new Date();
    minute = now.getMinutes();
    heure = now.getHours();
    if(String(heure).length == 1){
        heure = "0"+heure;
    }
    if(String(minute).length == 1){
        minute = "0"+minute;
    }
    $("#hourSideBar").html("<b>"+heure+":"+minute+"</b>");
}
showDateInMenu();
showHour();

setInterval(() => {
    showHour();
}, 60000);