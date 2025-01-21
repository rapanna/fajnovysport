$ = jQuery;
$(function () {
    $("#more_sports").on('click', function (e) {
        $("#more_sports--div").show();
        $("#less_sports").css("display", "inline-block");
        $("#more_sports").css("display", "none");
    });

    $("#less_sports").on('click', function (e) {
        $("#more_sports--div").hide();
        $("#less_sports").css("display", "none");
        $("#more_sports").css("display", "inline-block");
    });

    $("#clubs").on('click', function (e) {
        e.preventDefault();
        clearStyle();
        removeSelectedButton();
        //showInfo("Nacházíte se v sekci Kluby. Pro vyhledání jiného typu například sportoviště, musíte použít záložku níže.");
        $("#clubs").addClass("selected");
        updateData();
    });

    $("#sports_grounds").on('click', function (e) {
        e.preventDefault();
        clearStyle();
        removeSelectedButton();
        //showInfo("Nacházíte se v sekci Sportoviště. Pro vyhledání jiného typu například kluby, musíte použít záložku níže.");
        $("#sports_grounds").addClass("selected");
        updateData();
    });

    $("#sport_events").on('click', function (e) {
        e.preventDefault();
        clearStyle();
        removeSelectedButton();
        //showInfo("Nacházíte se v sekci Sportovní Akce. Pro vyhledání jiného typu například sportoviště, musíte použít záložku níže.");
        $("#sport_events").addClass("selected");
        updateData();
    });

    $("#serach-sport-button").on('click', function (e) {
        e.preventDefault();
        var search = $("#search-sport").val();
        var sporty = seznamSportu();
        $.each(sporty, function (index, value) {
            if (value == search) {
                afterAutocompleteClick(value);
            }
        });
    });

    $("#selected-sports").on('change', function (e) {
        updateData();
    });

    //autocomplete(document.getElementById("search-sport"), seznamSportu(), (sp, s) => compareWithoutDiacritics(sp, s), sp => sp, afterAutocompleteClick);

    function afterAutocompleteClick(sport) {
        addSport($("img.sport_icon[data-sport-title='" + sport + "']"));
        $("#search-sport").focus();
        $("#search-sport").select();
    }

});

function compareWithoutDiacritics(a, b) {
    a = a.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
    b = b.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
    return a.indexOf(b);
}

function seznamSportu() {
    return $("img.sport_icon")
        .toArray()
        .map(x => $(x).data()["sportTitle"])
}

function createSearchItems() {
    var text = $("#search-sport").val();
    $("img.sport_icon")
        .toArray()
        .map(x => $(x).data()["sportTitle"])
        .filter(x => compareWithoutDiacritics(x, text) > -1)
        .sort(x => compareWithoutDiacritics(x, text))
}

function compareWithoutDiacritics(a, b) {
    a = a.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
    b = b.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
    return a.indexOf(b);
}

function addSport(sportButton) {
    var sportCount = $('#selected-sports .mapa-select__link').length;
    var maxSports = 5;
    var existing = $("[data-sport-id='" + $(sportButton).data()["sportTitle"] + "']");
    if (existing.length > 0) {
        $(sportButton).removeClass('sport--selected');
        existing.remove();
        updateData();
    }
    else {
        if (sportCount < maxSports) {
            $(sportButton).addClass('sport--selected');
            var sport = $(sportButton).data()["sportTitle"];
            //var link = "<a class='mapa-select__link' data-sport-id='" + sport + "'>";
            //$("img.sport_icon[data-sport-title='" + sport + "']")
            // var objectSport = $("img.sport_icon[data-sport-title='" + sport + "']");

            var link = $("<a>")
                .attr("data-sport-id", sport)
                .addClass("mapa-select__link")
                .append(
                    $("<div />")
                        .addClass("remove-sport-button")
                        .on("click", () => addSport(sportButton))
                        .text("X"))
                .append(sport);

            jQuery("#selected-sports").append(link);
            updateData();
        } else {
            showInfo("Jeden sport musíte odebrat,  limit filtru je pět sportů.");
        }
    }

}

showInfo("Nacházíte se v sekci Kluby.Pro vyhledání jiného typu například sportoviště, musíte použít záložku níže.");
function showInfo(text) {
    //$("#mapa-tip").text(text);
    var content = text + "<br><div class=\"btn--close\" onclick=\"hideInfo();\">Rozumím</center>";
    if (jQuery().fancybox) {
        $.fancybox({ content: content});
    }
}

function hideInfo(){
    $.fancybox.close();
}
function removeSelectedButton() {
    $("#clubs").removeClass("selected");
    $("#sports_grounds").removeClass("selected");
    $("#sport_events").removeClass("selected");
}

function hasClass(element, className) {
    return (' ' + element.className + ' ').indexOf(' ' + className + ' ') > -1;
}

function createCurrentFilter() {

    //najde ktera sekce  kluby | sportoviste | sportovni akce je oznacena
    selectedType = "typ=Kluby";
    if ($("#clubs").hasClass('selected')) {
        //pridat kluby
        selectedType = "typ=Kluby";
    };
    if ($("#sports_grounds").hasClass('selected')) {
        //pridat sportoviste
        selectedType = "typ=Sportoviste";

    };
    if ($("#sport_events").hasClass('selected')) {
        //pridat akce
        selectedType = "typ=Akce";

    };

    var selectedSports = $("a.mapa-select__link")
        .toArray()
        .map(x => $(x).data()["sportId"])
        .map(x => "sport[]=" + x)
        .join("&");

    selected = selectedType + "&" + selectedSports;
    return selected;
}

var lastUpdateRequest;

//map generation 
mapboxgl.accessToken = 'pk.eyJ1IjoibWFwLW92YSIsImEiOiJjbDVtYzRvb3Qwczk3M2VvMWZyZDlvdXpiIn0.TLnLhtGTWtbEf4HFDKc9jA';
var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11', // styl mapy
    center: [18.2820444, 49.84006444], // střed mapy 
    zoom: 12 // přiblížení
});

 //navigace
 map.addControl(new mapboxgl.NavigationControl());
 var layerList = document.getElementById('js-menu-map');
 var inputs = layerList.getElementsByTagName('input');
 
 //vrsty
 function switchLayer(layer) {
 var layerId = layer.target.id;
 map.setStyle('mapbox://styles/mapbox/' + layerId);
 }
 
 for (var i = 0; i < inputs.length; i++) {
 inputs[i].onclick = switchLayer;
 }


function addToMap(sportItem) {
    if ((sportItem.longitude == null) || (sportItem.latitude == null)) {
        return;
    }

    let type = sportItem.typ;

    if (sportItem.dataLoadedFrom == "json"){
        var popup = "";
        popup = "<div class='mapboxgl-obal'>";
        popup += "  <div class='mapboxgl-obal-obsah'>";
        popup += "      <div class='mapboxgl-obal-obsah-text'>";
        popup += "          <h2 class='title title--h2 title--mapboxgl'>" + sportItem.title + "</h2>";
        popup += "          <div class='mapboxgl-obal-obsah-text__adress'>";
        popup += sportItem.address;
        popup += "          </div>";
        popup += "          <a class='mapboxgl-obal-obsah-text__button'  onclick='displaySingleItemJSON(" + sportItem.PostID + ")'>Zobrazit >></a>";
        popup += "      </div>";
        popup += "  </div>";
        popup += "</div>";
    } else {
        var popup = "";
        popup =  "<div class='mapboxgl-obal'>";
        popup += "  <div class='mapboxgl-obal-obsah'>";
        popup += "      <div class='mapboxgl-obal-obsah-text'>";
        popup += "          <h2 class='title title--h2 title--mapboxgl'>" + sportItem.title + "</h2>";
        popup += "          <div class='mapboxgl-obal-obsah-text__adress'>";
        popup += sportItem.address;
        popup += "          </div>";
        popup += "          <a class='mapboxgl-obal-obsah-text__button'  onclick='displaySingleItem(" + sportItem.PostID + ")'>Zobrazit >></a>";
        popup += "      </div>";
        popup += "  </div>";
        popup += "</div>";
    }
    var el = document.createElement('div');
    el.className = sportItem.marker_style;
    marker = new mapboxgl.Marker(el)
        .setLngLat([sportItem.longitude, sportItem.latitude])
        .setPopup(
            new mapboxgl.Popup({ offset: 25 }) // add popups
                .setHTML(
                    popup
                )
                .setMaxWidth(
                    "300px"
                )
        )
    .addTo(map);

    marker.getElement().addEventListener('click', () => {
        map.flyTo({
            center: [
                sportItem.longitude,
                sportItem.latitude
            ],
            zoom: 12,
            essential: true // this animation is considered essential with respect to prefers-reduced-motion
        });
    });
}


function clearMap() {
    $(".mapboxgl-marker").each(function (m) {
        $(".mapboxgl-marker").remove();
    });
    $(".mapboxgl-popup").each(function () {
        $(this).remove();
    });
}

function clearList() {
    jQuery('#mapa-show').empty();
}

function clearData() {
    clearMap();
    clearList();
}


function addToList(sportItem) {
    var a = document.createElement("a");
    //$(a).attr("href", sportItem.link);
    $(a).addClass("mapa-show-link");

    if (sportItem.dataLoadedFrom == "json"){
        $(a).on("click", (function () {
            displaySingleItemJSON(sportItem.PostID);
        }));
    } else {    
        $(a).on("click", (function () {
            displaySingleItem(sportItem.PostID);
        }));
    }

    var img = document.createElement("img");
    $(img).addClass("mapa-show-link__img");
    img.setAttribute('src', sportItem.thubmnailMap);
    img.setAttribute('alt', sportItem.title);
    img.setAttribute('title', sportItem.title);
    img.style.width = '90';
    img.style.width = '90';
    jQuery(a).append(img);

    var showLinkText = document.createElement("div");
    $(showLinkText).addClass("mapa-show-link-text");
    var title = document.createElement("h2");
    $(title).addClass("title title--h2 title--mapa");
    title.innerHTML = sportItem.title;
    jQuery(showLinkText).append(title);

    var address = document.createElement("div");
    $(address).addClass("mapa-show-link-text__info");
    address.innerHTML = sportItem.address;
    jQuery(showLinkText).append(address);
    jQuery(a).append(showLinkText);

    jQuery('#mapa-show').append(a);
}


function clearStyle() {
    $("#clubs").css("background-color", "");
    $("#sport_events").css("background-color", "");
    $("#sports_grounds").css("background-color", "");
}

function displaySingleItem(postID) {
    $('#js-mapa-back__link').show();
    $("#js-mapa-back").show();

    showLoaderLeft();
    clearList();
    $.ajax({
        url: theme_directory.theme_directory + "/inc/load_map_data-single.php?id=" + postID,
        success: function (data) {
            var div = document.createElement("div");
            map.flyTo({
                center: [
                    data.longitude,
                    data.latitude
                ],
                zoom: 18,
                essential: true // this animation is considered essential with respect to prefers-reduced-motion
            });
            hideLoaderLeft();

            //title
            var h2 = document.createElement("h2");
            $(h2).addClass("title title--h2 title--mapa-detail");
            h2.innerHTML = data.title;
            jQuery(div).append(h2);

            //adresa
            var address = document.createElement("div");
            $(address).addClass("mapa-show__adrress");
            address.innerHTML = data.address;
            jQuery(div).append(address);

            var basicInfoDiv = document.createElement("div");
            $(basicInfoDiv).addClass("mapa-show-nacionale");
            //datum akce
            if (!!data.datum_akce) {
                var dateDiv = document.createElement("div");
                $(dateDiv).addClass("mapa-show-nacionale__date");
                dateDiv.innerHTML = "Datum akce: " + data.datum_akce;
                jQuery(div).append(dateDiv);
            }

            //konec akce
            if (!!data.datum_akce_konec) {
                var dateDiv2 = document.createElement("div");
                $(dateDiv2).addClass("mapa-show-nacionale__date");
                dateDiv2.innerHTML = "Konec akce: " + data.datum_akce_konec;
                jQuery(div).append(dateDiv2);
            }

            //www
            var wwwDiv = document.createElement("div");
            $(wwwDiv).addClass("mapa-show-nacionale__web");
            var a = document.createElement("a");
            a.setAttribute('href', data.www);
            a.innerText = data.www;
            jQuery(wwwDiv).append(a);
            jQuery(div).append(wwwDiv);

            //content
            var innerDiv = document.createElement("div");
            innerDiv.innerHTML = "<br>" + data.content;
            $(innerDiv).addClass("mapa-mapa-show-content entry");
            jQuery(div).append(innerDiv);

            jQuery('#mapa-show').append(div);
            $("#mapa-show a.fancybox").fancybox({ arrows: true })
        }
    });
}

function displaySingleItemJSON(postID) {
    $('#js-mapa-back__link').show();
    $("#js-mapa-back").show();
    console.log(theme_directory.theme_directory + "/inc/load_map_data-single.php?id=" + postID + "&type=JSON");
    showLoaderLeft();
    clearList();
    $.ajax({
        url: theme_directory.theme_directory + "/inc/load_map_data-single.php?id=" + postID + "&type=JSON",
        success: function (data) {
            console.log(data);
            var data = data["Data"][0];
            var div = document.createElement("div");
            map.flyTo({
                center: [
                    data.latitude,
                    data.longitude
                ],
                zoom: 18,
                essential: true // this animation is considered essential with respect to prefers-reduced-motion
            });
            hideLoaderLeft();

            //title
            var h2 = document.createElement("h2");
            $(h2).addClass("title title--h2 title--mapa-detail");
            h2.innerHTML = data.title;
            jQuery(div).append(h2);

            //adresa
            var address = document.createElement("div");
            $(address).addClass("mapa-show__adrress");
            address.innerHTML = data.address;
            jQuery(div).append(address);


            //ikony sportu
            var catSportyDiv = document.createElement("div");
            $(catSportyDiv).addClass("mapa-show__icons");
            jQuery.each(data.cathegories, function f(sport) {
                var cathegoryImage = document.createElement("img");
                cathegoryImage.setAttribute('src', data.cathegories[sport]);
                cathegoryImage.setAttribute('alt', data.cathegoriesTitle[sport]);
                cathegoryImage.setAttribute('title', data.cathegoriesTitle[sport]);
                cathegoryImage.setAttribute('style', 'width: 50px; height:50px');
                jQuery(catSportyDiv).append(cathegoryImage);
            });
            
            jQuery(div).append(catSportyDiv);

            var basicInfoDiv = document.createElement("div");
            $(basicInfoDiv).addClass("mapa-show-nacionale");
            //datum akce
            if (!!data.datum_akce) {
                var dateDiv = document.createElement("div");
                $(dateDiv).addClass("mapa-show-nacionale__date");
                dateDiv.innerHTML = "Datum akce: " + data.datum_akce;
                jQuery(div).append(dateDiv);
            }

            //konec akce
            if (!!data.datum_akce_konec) {
                var dateDiv2 = document.createElement("div");
                $(dateDiv2).addClass("mapa-show-nacionale__date");
                dateDiv2.innerHTML = "Konec akce: " + data.datum_akce_konec;
                jQuery(div).append(dateDiv2);
            }

            //www
            if (!!data.www) {
                var wwwDiv = document.createElement("div");
                $(wwwDiv).addClass("mapa-show-nacionale__web");
                var a = document.createElement("a");
                a.setAttribute('href', data.www);
                a.innerText = data.www;
                jQuery(wwwDiv).append(a);
                jQuery(div).append(wwwDiv);
            }

            //content
            if(data.content != null) {
            var innerDiv = document.createElement("div");
            innerDiv.innerHTML = "<br>" + data.content;
            $(innerDiv).addClass("mapa-mapa-show-content entry");
            jQuery(div).append(innerDiv);
            }
            //fotky
            var fotkyDiv = document.createElement("div");
            jQuery.each(data.images, function f(image) {
                if (data.images[image] != false) {
                    //vytvoreni a
                    var a = document.createElement("a");
                    $(a).addClass("fancybox image");
                    a.setAttribute('href', data.images[image]['url']);
                    a.setAttribute('data-caption', data.images[image]['alt']);
                    a.setAttribute('rel', "fancybox");


                    var displayImage = document.createElement("img");
                    displayImage.setAttribute('src', data.images[image]['sizes']['thumbnail']);
                    displayImage.setAttribute('alt', data.images[image]['alt']);

                    displayImage.style.width = '142';
                    displayImage.style.width = '95';


                    jQuery(a).append(displayImage);
                    jQuery(fotkyDiv).append(a);
                    /* 
                    a.click(function (e) {
                        e.preventDefault();
                            lightbox.start($(this));
                            return false;
                    })*/
                }
            });
            jQuery(div).append(fotkyDiv);

            jQuery('#mapa-show').append(div);
            $("#mapa-show a.fancybox").fancybox({ arrows: true })
        }
    });
}

function compareWithoutDiacritics(a, b) {
    a = a.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
    b = b.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
    return a.indexOf(b);
}

function returnFilteredSports(text) {
    var sport = seznam_sportu.filter(function (search) {
        return compareWithoutDiacritics(search, text) >= 0;
    });
}

function showLoaderLeft() {
    $("#loader-left").show();       //vypis
}

function hideLoaderLeft() {
    $("#loader-left").hide();       //vypis
}

function showLoaderRight() {
    $("#loader-right").show();       //vypis
}

function showLoaderRight() {
    $("#loader-right").hide();       //vypis
}

function showLoaders() {
    $("#loader-left").show();       //vypis
    $("#loader-right").show();      //mapa
}

function hideLoaders() {
    $("#loader-left").hide();       //vypis
    $("#loader-right").hide();      //mapa
}
function scrollBackToDefault() {
    map.flyTo({
        center: [
            18.2820444,
            49.84006444
        ],
        zoom: 12,
        essential: true // this animation is considered essential with respect to prefers-reduced-motion
    });
}

function updateData(addToMapVar = true, addToListVar = true) {

    //skryje tlacitko zpet
    $("#js-mapa-back__link").hide();
    $("#js-mapa-back").hide();

    clearMap();
    clearList();
    showLoaders();

    if (!!lastUpdateRequest)
        lastUpdateRequest.abort();


    lastUpdateRequest = $.ajax({
        url: theme_directory.theme_directory + "/inc/load_map_data.php?" + createCurrentFilter(),
        success: function (data) {
            hideLoaders();
            console.log(data);
            console.log(theme_directory.theme_directory + "/inc/load_map_data.php?" + createCurrentFilter());
            if (!data.Data) {
                var info = document.createElement("div");
                info.innerHTML = "Nebyly nalezeny žádné položky";
                $("#mapa-show").append(info);

                //mapa-show
                return;
            }

            //clearData();
            if (addToListVar){
                clearList();
                data.Data.forEach(addToList);
            }
            if (addToMapVar) {
                clearMap();
                data.Data.forEach(addToMap);
            }
            
            
        },
        error:  function (data) {
            hideLoaders();
            console.log(data);
        }
    });
}