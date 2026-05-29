## Installation for Hostinger issues
[//]: # all dependencies defined in composer.lock (--no-dev — skips dev dependencies) (--optimize-autoloader — generates a classmap)
`composer install --no-dev --optimize-autoloader`

## Personal notes
- Logements et bateau (section "Comment ça marche") / "Choisissez comment réserver en direct avec l'hôte" (mettre en avant que tu as le choix) / Choisissez votre mode de réservation avec l'hôte + possibilité de ne pas avoir de comission ni frais de services intermédiaire
- Capicité minimale -> capacité

## TODO
- section "Comment ça marche":
  - retirer mot "direct" + "authentique" et ajouter "hébergements et bateaux" // fait
  changer "échanger -> communiquer" // fait
- "Réservez en direct avec l'hôte via différents canaux de contacts" // fait
- page "Publier" (`resources/views/account/create/step-2-location.blade.php`): prédictif pour le google map (ville ou adresse exacte)
- remplacer unité "sortie" sur la partie bateau par "heure" + "demi-journée" // fait
- supprimer unité "minimum" + "unité de durée" par "jour" // fait
- sites classiques de réservation
