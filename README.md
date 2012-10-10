Rest Sample CakePHP app
=======================

Ce projet est une �bauche d'API Rest avec syst�me d'authentification proche de OAuth (avec syst�me de cl�s partag�es par application + Jeton utilisateur)

Installation
------------

* Cr�er la base de donn�es MySQL � l'aide du script create_database.sql inclu dans le r�pertoire /sql
* Ce script contient une cl� par d�faut "Sample Application" (mais vous pouvez cr�er les autres dans la table keys)
* Configurer l'acc�s � votre base de donn�es en renommane le fichier database.php.sample en database.php dans le r�pertoire /app/Config
* Installer la derni�re version de CakePHP 2 (R�pertoire /lib/Cake) dans le r�pertoire /lib (https://github.com/cakephp/cakephp)

Cr�er un utilisateur
--------------------

* Envoyez une requ�te POST vers /users.xml, avec comme param�tre 'email' et 'password' valides
* Si la cr�ation se passe bien vous devriez avoir ceci en retour :
    <?xml version="1.0" encoding="UTF-8"?>
    <response>
        <user>
            <email>first.user@hostname.com</email>
            <id>user-50756c36c1e586.47447762</id>
            <updated>2012-10-10 13:38:14</updated>
            <created>2012-10-10 13:38:14</created>
        </user>
    </response>

* Vous pouvez d�sormais demander un token d'authentification necessaire � chaque requ�te.

Demander un token d'authentification
------------------------------------

* Envoyez une requ�te POST vers /auth.xml?key=cle_de_votre_application, avec comme param�tre 'email' et 'password' valides. (cl� de "Sample Application" = 3c6e0b8a9c15224a8228b9a98ca1531d)
* Si l'authentification est r�ussie, vous devriez avoir un token en retour :
    <response>
        <user>
            <id>user-50756c36c1e586.47447762</id>
            <email>first.user@hostname.com</email>
            <created>2012-10-10 13:38:14</created>
            <updated>2012-10-10 13:38:14</updated>
        </user>
        <token>991ae7419a32e074e9a4ff4ea7ac4b70</token>
    </response>
* Le token sera aussi pr�sent dans le cookie "rest[Auth][token]"

Utiliser le token pour signer vos requ�tes suivantes
----------------------------------------------------

* Vous pouvez maintenant faire des requ�tes sur cette api en signant vos requ�tes avec un param�tre "hash".
* Le token devra �tre pr�sent dans le cookie "rest[Auth][token]" tel qu'il vous a �t� retourn� par l'authentification
* La signature "hash" se contruit en faisant un md5 d'une concatenation des donn�es suivantes :
TOKEN + METHODE_HTTP + RESSOURCE_REST + CLE_SECRETE_DE_APPLICATION
La cl� secr�te de l'application de "Sample Application" est 5ebe2294ecd0e0f08eab7690d2a6ee69 (table keys, colonne secret)
Dans notre exemple, si on veux faire une requete GET /items.xml, on va signer de la mani�re suivante :
    md5(991ae7419a32e074e9a4ff4ea7ac4b70getitems5ebe2294ecd0e0f08eab7690d2a6ee69) = 72d1b04127ff83298c04227197df297e
On va donc faire un GET /items.xml?hash=72d1b04127ff83298c04227197df297e

* On peux acceder aux ressources dans leur repr�sentation xml ou json