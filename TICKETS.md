## 1| L'utilisateur non connecté ne doit pas voir le bouton "ADD TO FAVORITE" des cards ARTICLE

## 2| Ajouter dans la barre de navigation le lien vers la page contact (La methode contact() se trouve dans HomeController) | Le lien vers la page contact est accessible à l'utilisateur connecté et déconnecté

## 3| Les boutons show des cards articles ne fonctionne pas. La méthode show d'ArticleController ne semble pas complète. Le template de show_article existe et recoit une variable twig "article".

## 4| Sur la page login, le bouton de soumission du formulaire nécessite un changement de wording => "Register !" doit être remplacé par "Login now !"

## 5| Créer un page about qui affiche un H1 "page about wip". Celle ci est relié à la partie Home du projet. Ajouter le lien dans le nav pour se diriger vers cette page. Lien accessible à tous les users (logué or not).

## 6| Il ya un pb sur la page login qui affiche toujours un message d'erreur même lorsque je n'ai pas encore soumis le formulaire. Régler ce bug.

## 7| Le crud des categories n'est pas disponible sur l'interface admin /admin/index : mettre en place la table qui affiche toutes les categories et permettez les actions delete, edit & add à l'admin. Les methodes addCategorie / editCategorie et deleteCategorie existent déjà ainsi que leurs templates. Le model de la table categorie est présent aussi. 

## 8| La fonctionnalité search ne fonctionne pas encore, il faudrait que celle ci permette à l'utilisateur de rechercher un terme et que celui ci lui retourne un resultat de recherche par rapports aux titres des articles en base de données.
