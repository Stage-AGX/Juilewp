document.addEventListener('DOMContentLoaded', function () {


    console.log("tejjjjjst");

}

)



(document).ready(function($) {

    console.log("teouist");

    var countriesData = JSON.parse(agerix_countries_data); // R�cup�rer les donn�es des pays

    var categoriesColors = agerixData.categoriesColors; // R�cup�rer les couleurs des cat�gories

    $('.agerix-map-container path').on('mouseover', function() {

        var countryId = $(this).attr('data-id'); //id of the svg

        var country = countriesData.find(c => c['categoryJsonPays'] === countryId); // id of the countries-data.json



        if (countryData) {

            // Change the fill color on hover

            $(this).css('fill', categoryJsonColor);

            // Display country details 



        }

    }).on('mouseout', function() {

        // Reset the fill color on mouseout

        $(this).css('fill', '#ececec');

    });

});

