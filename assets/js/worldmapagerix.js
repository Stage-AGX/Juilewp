document.addEventListener('DOMContentLoaded', function () {
    // load the file countries-data.json + parse the data in js
    fetch(agerixcarte_vars.plugin_url + '/assets/js/countries-data.json')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(countriesData => {
            // load the file categories-data.json + parse the data in js
            fetch(agerixcarte_vars.plugin_url + '/assets/js/categories-data.json')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(categoriesData => {
                // Manipuler le SVG après avoir chargé les données JSON
                var svg = document.getElementById('worldmap-svg')
                var countriesGroup = svg.getElementById('countries');
                var paths = countriesGroup.querySelectorAll('path');


                paths.forEach(function(path) {
                    var countryId = path.getAttribute('id'); // ID du pays dans le fichier SVG
                    var countryData = countriesData[countryId]; // Données du pays depuis countries-data.json

                    if (countryData) {
                        // Mettre à jour les attributs du path avec les données du pays
                        path.setAttribute('data-json-id', countryData.countryJsonId);
                        path.setAttribute('data-json-name', countryData['country-json-name']);
                        path.setAttribute('data-json-continent', countryData['country-json-continent']);

                        // Ajouter un événement pour gérer les interactions avec le path (par exemple, survol)
                        path.addEventListener('mouseover', function() {
                            var category = getCategoryForCountry(countryId, categoriesData);
                            if (category) {
                                path.style.fill = category.categoryJsonColor; // Changer la couleur de remplissage en fonction de la catégorie
                            }
                        });

                        path.addEventListener('mouseout', function() {
                            path.style.fill = ''; // Restaurer la couleur par défaut
                        });
                    }
                });
            })
            .catch(error => {
                console.error('Erreur lors du chargement des données JSON :', error);
            });
        })
    .catch(error => {
        console.error('Erreur lors du chargement des données JSON :', error);
    });

    function getCategoryForCountry(countryId, categoriesData) {
    // Parcourir les catégories pour trouver celle du pays donné
    for (var categoryKey in categoriesData) {
        var category = categoriesData[categoryKey];
        if (category.categoryJsonPays && category.categoryJsonPays.includes(countryId)) {
            return category;
        }
    }
    return null;
    }
})
