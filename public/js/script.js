$(document).ready(function () {
    $('.radial-gradient').each(function (index) {
        $(this).find(">div").css("background-size", "auto " + $(this).height() + "px");
        if ($(this).height() < $(this).find(">div").height()) {
            $(this).css("display", "block");
        }
    });

    // $('.js_project_languages').each(function (index) {
    //     const url = $(this).text();
    //     var message='';
    //     $.ajax(url)
    //         .done((data) => {
    //             message ='Languages : ' + Object.keys(data).join(', ') + '.';
    //         }).fail((xhr) =>{
    //         console.log(xhr.status, ' xhr.responseText', xhr);
    //             message = 'Languages : Error '
    //                 + xhr.status + '<br />'
    //                 + xhr.responseJSON.message
    //                 +'<br /><a href="'+xhr.responseJSON.documentation_url+
    //                 '" target="_blank">documentation_url</a>'
    //             ;
    //         $(this).removeClass('primary')
    //             .addClass('error');
    //         console.log(xhr.status);
    //
    //     }).always(()=>{
    //         console.log(message);
    //         $(this).html(message);
    //     })
    //     ;
    // });

    //This tag is not displayed in the DOM, but can be used in Javascript
    const projectTag = $('#readme project');
    console.info('Tag(#readme project) name',projectTag.attr('name'),' : ',projectTag.attr('value'));

    $('#input_color').change(function () {
        const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec($(this).val());
        rgb = result
            ? {
                r: parseInt(result[1], 16),
                g: parseInt(result[2], 16),
                b: parseInt(result[3], 16)
            }
            : {r: 15, g: 45, b: 49};
        change_document_color(rgb.r, rgb.g, rgb.b);
    });
    $('#input_color').click(function () {
        const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec($(this).val());
        rgb = result
            ? {
                r: parseInt(result[1], 16),
                g: parseInt(result[2], 16),
                b: parseInt(result[3], 16)
            }
            : {r: 15, g: 45, b: 49};
        change_document_color(rgb.r, rgb.g, rgb.b);
        $(this).val('rgb(15,45,49)');
    });
    // let lang = "fr-FR";
    date_heure("afficheDate", "fr-FR");

    //date_heure("afficheDate");

    $("#on-menu").click(function () {
        $('#ul-menu li').toggleClass("d-none");
        $("#off-menu").toggleClass("d-none");
    });
    $("#off-menu").click(function () {
        $('#ul-menu li').toggleClass("d-none");
        $("#off-menu").toggleClass("d-none");

    });
    // $("#menu").click(function () {
    //     $('#ul-menu li').each(function (index) {
    //         $(this).toggleClass("d-none", index>0)
    //         const elementClasses = $(this).classList
    //         if (index == 0) {
    //             $(this).removeClass("menu-on").addClass("menu-off")
    //             console.log('index=0', elementClasses)
    //         } else {
    //             console.log(index, ' - index!=0', elementClasses)
    //         }
    //     });
    // });
});


function date_heure(id, lang) {
    //https://developer.mozilla.org/fr/docs/Web/JavaScript/Reference/Objets_globaux/DateTimeFormat/format
    const option = {
        year: 'numeric',
        month: 'long',
        weekday: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric'
    };
    let date = new Date();

    document.getElementById(id).innerHTML = '<span class="glyphicon glyphicon-calendar"></span> ' +
        date.toLocaleDateString(lang, option)
            .replace(',', '<br /><span class="glyphicon glyphicon-time"></span> ');
    // console.log('date-heure', resultat);
    setTimeout('date_heure("' + id + '", "' + lang + '");', 1000);
    return true;
}

if ($("#mailto")) {
    $("#mailto").html("@");
}