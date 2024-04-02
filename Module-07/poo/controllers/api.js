const adresseInput = document.getElementById('adresseInput');
const suggestionsList = document.getElementById('suggestionsList');
const wetherDiv = document.getElementById('wether');

adresseInput.addEventListener('input', function() {
    const inputValue = adresseInput.value;

    fetch(`https://api-adresse.data.gouv.fr/search/?q=${inputValue}`)
        .then(response => response.json())
        .then(data => {
            const suggestions = data.features;
            afficherSuggestions(suggestions);
        })
        .catch(error => console.error('Erreur lors de la récupération des suggestions:', error));
});

function afficherSuggestions(suggestions) {
    suggestionsList.innerHTML = ''; // Efface les anciennes suggestions

    suggestions.forEach(suggestion => {
        const li = document.createElement('li');
        li.textContent = suggestion.properties.label;
        li.addEventListener('click', function() {
            adresseInput.value = suggestion.properties.label; // Met à jour la valeur de l'input avec la suggestion sélectionnée
            suggestionsList.innerHTML = ''; // Efface les suggestions après avoir choisi une
        });
        suggestionsList.appendChild(li);
    });
}

// Empêche la soumission du formulaire si l'adresse n'est pas dans la liste des suggestions
// document.querySelector('form').addEventListener('submit', function(event) {
//     const inputValue = adresseInput.value;
//     const suggestions = Array.from(suggestionsList.children).map(li => li.textContent);
//     const canDo = false

//     if (!canDo) {
//         console.log(canDo);
//         event.preventDefault(); 
//         alert('Veuillez choisir une adresse parmi les suggestions.');
//         canDo = true
//     }
// });



 
