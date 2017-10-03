/*!
 * Start Bootstrap - SB Admin 2 v3.3.7+1 (http://startbootstrap.com/template-overviews/sb-admin-2)
 * Copyright 2013-2016 Start Bootstrap
 * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap/blob/gh-pages/LICENSE)
 */
// $(function() {
//     $('#side-menu').metisMenu();
// });

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        var topOffset = 50;
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    // var element = $('ul.nav a').filter(function() {
    //     return this.href == url;
    // }).addClass('active').parent().parent().addClass('in').parent();
    var element = $('ul.nav a').filter(function() {
        return this.href == url;
    }).addClass('active').parent();

    while (true) {
        if (element.is('li')) {
            element = element.parent().addClass('in').parent();
        } else {
            break;
        }
    }
});

// Funktion når der klikkes på knap med id tilfoej_tid
// $('#tilfoej_tid').click( function() {
//     // Vælg sidste element med klassen row i div med id tidspunkter. Det indeholder valg af ugedage og tid fra/til. gem i var.
//     var element = $('#tidspunkter .row:last'),
//         // Kopier element
//         kopi = element.clone().html(),
//         // Hent id på element
//         id = element.attr('id'),
//         // Læg en til id
//         nyt_id = parseInt(id) + 1;
//     // Overskriv id med nyt id på ugedag
//     kopi = kopi.replace('tidspunkt[' + id + '][ugedag]', 'tidspunkt[' + nyt_id + '][ugedag]');
//     // Overskriv id med nyt id på tid_fra
//     kopi = kopi.replace('tidspunkt[' + id + '][tid_fra]', 'tidspunkt[' + nyt_id + '][tid_fra]');
//     // Overskriv id med nyt id på tid_fra
//     kopi = kopi.replace('tidspunkt[' + id + '][tid_til]', 'tidspunkt[' + nyt_id + '][tid_til]');
//     // Læg kopi ind i row container med nyt id
//     kopi = '<div class="form-group row" id="' + nyt_id + '">' + kopi + '</div>';
//     // Tilføj kopierede element efter andre elementer i container.
//     $('#tidspunkter').append(kopi);
//     $('#fjern_tid').removeClass('disabled');
// });

// Funktion når der klikkes på knap med id fjern_tid
// $('#fjern_tid').click( function() {
//     // Vælg sidste element med klassen row i div med id tidspunkter. Det indeholder valg af ugedage og tid fra/til. gem i var.
//     var element = $('#tidspunkter .row:last'),
//         // Hent id på element
//         id = element.attr('id');
//     // Hvis id er større end 0 må rækken fjernes, ellers har vi ikke noget html at kopiere fra når vi tilføjer felter
//     if (id > 0)
//     {
//         // Fjern sidste element med klassen row i div med id tidspunkter.
//         element.remove();
//         // Hvis det aktuelle id er 1 tilføjes klassen disabled for at indekere man ikke kan fjerne flere
//         if ( id == 1)
//         {
//             $('#fjern_tid').addClass('disabled');
//         }
//     }
//
// });
