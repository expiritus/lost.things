$(document).ready(function () {

    var lnk = document.links;
    for (j = 0; j < lnk.length; j++)
        if (lnk [j].href == document.URL) {
            $(lnk [j]).css({
                'color': '#ffffff',
                'display': 'inline-block',
                'padding': '10px',
                'font-size': '150%',
                'font-weight': 'bold',
                'text-decoration': 'none',
                'border-bottom': '1px dashed #EBFFCB',
                'width': '100%',
                'background-color': '#CEEBFE',
                'text-shadow': '1px 1px 0 #000'
            });
        }
});
