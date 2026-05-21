## Installation for Hostinger issues
[//]: # all dependencies defined in composer.lock (--no-dev — skips dev dependencies) (--optimize-autoloader — generates a classmap)
`composer install --no-dev --optimize-autoloader`

## Personal notes
- Logements et bateau (section "Comment ça marche") / "Choisissez comment réserver en direct avec l'hôte" (mettre en avant que tu as le choix) / Choisissez votre mode de réservation avec l'hôte + possibilité de ne pas avoir de comission ni frais de services intermédiaire
- Capicité minimale -> capacité

## TODO
- Short term vs long term rental: how do we store this ? in the DB ? and how is it separated ? 
- Enable a search by proximity (20km radius): if a user is searching for Cannes we should also display results for Mandelieu
- Add the autocompletion on the search bar for "name" research
- Never put price: instead we display "from X€"
- Prices and conditions: add message with an asterisk: "* consulter les tarifs et conditions auprès de l'hôte"
- Add a section: "Save this link by sharing it