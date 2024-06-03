## Démo 1 : Exemple de *refactoring* et illustrations de quelques techniques

<!-- Support étudiant : à livrer avec le dossier starting, contenant le script de départ. -->

> Cette démo est basée sur l'ouvrage "Refactoring: Improving the Design of Existing Code de Martin Fowler", Chapitre 1. [Voir les références](#référence)

- [Démo 1 : Exemple de *refactoring* et illustrations de quelques techniques](#démo-1--exemple-de-refactoring-et-illustrations-de-quelques-techniques)
- [Le problème](#le-problème)
  - [Programme de départ](#programme-de-départ)
  - [Changements à apporter](#changements-à-apporter)
- [Refactoring par la pratique](#refactoring-par-la-pratique)
- [Références, liens utiles](#références-liens-utiles)


## Le problème

Imaginez une compagnie de théâtre qui se produit à la demande de clients. Un client commande plusieurs représentations d'un spectacle, la compagnie le facture. Le montant de la facture est défini par la taille de l’audience et le type de pièce joué. La compagnie joue deux types de pièces : des tragédies et des comédies. En plus de la facture, la compagnie délivre à ses clients des "crédits" qu'il peuvent utiliser pour obtenir des réductions sur les prochaines représentations, afin de fidéliser leur clientèle.

La compagnie stocke les données à propos de ses pièces sous la forme d'un document JSON :

~~~JSON
{
    "hamlet": {"name": "Hamlet", "type": "comedy",
    "as-like": {"name": "As You Like it", "type": "comedy",
    "othello": {"name": "Othello", "type": "tragedy",
}
~~~

Leurs données pour les factures sont aussi stockées sous la forme d'un document JSON :

~~~JSON
[
     {
        "customer": "BigCo",
        "performances": [
        {
            "playID": "hamlet",
            "audience": 55
        },
        {
            "playID": "as­like",
            "audience": 35
        },
        {
            "playID": "othello",
            "audience": 40
        }
        ]
    }
]
~~~

### Programme de départ

Le programme de départ qui calcule et imprime la facture est donné dans le fichier source `statement.php`, fourni avec ce document.

Pour executer la fonction :

~~~bash
php statement.php
~~~

### Changements à apporter

La compagnie a des nouveaux besoins et demande les *changements* suivants :

- En plus d'une version au format *plain text* (ASCII), la compagnie souhaiterait publier la facture au format HTML. Le document devrait donner le résultat suivant :

~~~html
<h1>Statement for BigCo</h1>
<table>
<tr><th>play</th><th>seats</th><th>cost</th></tr>
<tr><td>Hamlet</td><td>55</td><td>$650.00</td></tr>
<tr><td>As you like it</td><td>35</td><td>$580.00</td></tr>
<tr><td>Othello</td><td>40</td><td>$500.00</td></tr>
</table>
<p>Amount owed is <em>$1,730.00</em></p>
<p>You earned <em>47 credits</em></p>
~~~

- La compagnie veut joueur d'autres sortes de spectacles : *historique*, *pastoral*, *pastoral-comique*, *poésie*, etc. Ils ne savent pas encore avec certitude quelles pièces ils vont jouer, mais ils ont déjà de nombreuses idées pour étoffer leur répertoire.


## Refactoring par la pratique

1. **Inspecter** le code.
2. Pour chaque nouveau besoin, **identifiez les changements que le code doit subir : quelles parties du code doivent changer et pour quelles raisons**.
3. **Écrire un test** pour vous permettre de refactorer sans introduire de régression et vous assurer que le comportement observé du code reste le même;
4. **Versionner le projet**, **faire un premier commit** pour initialiser le suivi de code;
5. **Refactoriser** le code *par petits pas* pour le structurer, en suivant un cycle *compile, test, commit*
6. Une fois obtenu un résultat *satisfaisant* et suffisamment *structuré* pour entamer les changements demandés, implémentez-les, un par un.


## Références, liens utiles

- [Refactoring: Improving the Design of Existing Code](https://martinfowler.com/books/refactoring.html), de Martin Fowler, publié chez Addison-Wesley, 1999. Voir *Chapitre 1, First Example*
- [Refactoring, catalog](https://refactoring.com/catalog/), le catalogue des techniques de refactoring documentées dans le livre de Martin Fowler 
- [Composer, documentation](https://getcomposer.org/doc/), documentation officielle de Composer, le gestionnaire de dépendances de PHP
- [Writing Tests for PHPUnit](https://docs.phpunit.de/en/11.1/writing-tests-for-phpunit.html), tutoriel sur PHPUnit, le framework le plus populaire pour écrire des tests pour PHP
- [W3C Markup Validation Service](https://validator.w3.org/), le validateur de markup HTML en ligne du W3C pour valider ses documents HTML# refactoring-starter
