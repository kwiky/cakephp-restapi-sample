Rest Sample CakePHP app
=======================

Ce projet est une ébauche d'API Rest avec système d'authentification proche de OAuth (avec système de clés partagées par application + Jeton utilisateur)

Installation
------------

* Créer la base de données MySQL à l'aide du script create_database.sql inclu dans le répertoire /sql
* Ce script contient une clé par défaut "Sample Application" (mais vous pouvez créer les autres dans la table keys)
* Configurer l'accès à votre base de données en renommane le fichier database.php.sample en database.php dans le répertoire /app/Config
* Installer la dernière version de CakePHP 2 (Répertoire /lib/Cake) dans le répertoire /lib (https://github.com/cakephp/cakephp)

Créer un utilisateur
--------------------

* Envoyez une requète POST vers /users.xml, avec comme paramètre 'email' et 'password' valides
* Si la création se passe bien vous devriez avoir ceci en retour :
	<?xml version="1.0" encoding="UTF-8"?>
	<response>
		<user>
			<email>first.user@hostname.com</email>
			<id>user-50756c36c1e586.47447762</id>
			<updated>2012-10-10 13:38:14</updated>
			<created>2012-10-10 13:38:14</created>
		</user>
	</response>

* Vous pouvez désormais demander un token d'authentification necessaire à chaque requète.

Demander un token d'authentification
------------------------------------

* Envoyez une requète POST vers /auth.xml?key=cle_de_votre_application, avec comme paramètre 'email' et 'password' valides. (clé de "Sample Application" = 3c6e0b8a9c15224a8228b9a98ca1531d)
* Si l'authentification est réussie, vous devriez avoir un token en retour :
	<?xml version="1.0" encoding="UTF-8"?>
	<response>
		<user>
			<id>user-50756c36c1e586.47447762</id>
			<email>first.user@hostname.com</email>
			<created>2012-10-10 13:38:14</created>
			<updated>2012-10-10 13:38:14</updated>
		</user>
		<token>991ae7419a32e074e9a4ff4ea7ac4b70</token>
	</response>
* Le token sera aussi présent dans le cookie "rest[Auth][token]"

Utiliser le token pour signer vos requètes suivantes
----------------------------------------------------

* Vous pouvez maintenant faire des requètes sur cette api en signant vos requètes avec un paramètre "hash".
* Le token devra être présent dans le cookie "rest[Auth][token]" tel qu'il vous a été retourné par l'authentification
* La signature "hash" se contruit en faisant un md5 d'une concatenation des données suivantes :
TOKEN + METHODE_HTTP + RESSOURCE_REST + CLE_SECRETE_DE_APPLICATION
La clé secrète de l'application de "Sample Application" est 5ebe2294ecd0e0f08eab7690d2a6ee69 (table keys, colonne secret)
Dans notre exemple, si on veux faire une requete GET /items.xml, on va signer de la manière suivante :
	md5(991ae7419a32e074e9a4ff4ea7ac4b70getitems5ebe2294ecd0e0f08eab7690d2a6ee69) = 72d1b04127ff83298c04227197df297e
On va donc faire un GET /items.xml?hash=72d1b04127ff83298c04227197df297e

* On peux acceder aux ressources dans leur représentation xml ou json