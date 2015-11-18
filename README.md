# Facebook Quizz #

Je crée ce petit readme pour vous expliquez comment config

## Configuration de GIT ##

* On met un peu de couleurs dans ce monde de brutes
```
#!bash

git config --global color.diff auto
git config --global color.status auto
git config --global color.branch auto
```
* Je mets un pseudo pour savoir sur qui on crie quand ça foire


```
#!bash

git config --global user.name "mon_pseudo"
```
* J'ajoute le mail avec lequel je me suis inscrit sur bitbucket


```
#!bash

git config --global user.email "mail@exemple.com"
```
La config de base est ici terminée.

## Comment récupéré les sources? ##

* Il faut généré une clée ssh avec votre git bash (ou terminal si vous êtes sur linux)

```
#!bash

ssh-keygen  -t rsa -C "mon_mail@example.fr"
# Creates a new ssh key, using the provided email as a label
# Generating public/private rsa key pair.
# Enter file in which to save the key (/home/you/.ssh/id_rsa): [entrée]

Enter passphrase (empty for no passphrase): [perso j'en mets pas donc entrée]
# Enter same passphrase again: [entrée]
```
* Vous aurez un résultat de ce genre : 

```
#!bash

Your identification has been saved in /home/you/.ssh/id_rsa.
# Your public key has been saved in /home/you/.ssh/id_rsa.pub.
# The key fingerprint is:
# 01:0f:f4:3b:ca:85:d6:17:a1:7d:f0:68:9d:f0:a2:db mon_mail@example.fr [ou un petit dessin]
```

* Une fois la clé généré il faut l'ajouter à votre terminal et compte en allant sur manage account => ssh-keys  (en appuyant sur votre avatar en haut à droite)


```
#!bash

eval "$(ssh-agent -s)"
# Agent pid 59566
ssh-add ~/.ssh/id_rsa
xclip -sel clip < ~/.ssh/id_rsa.pub [sur gitbash il y est de base sur linux faut le télécharger en tapant sudo apt-get install xclip]

```


* Quand la clée est sur github retourner sur votre terminal

1. Rendez-vous dans le répertoire local (genre c:/wamp/www/tekofil)
```
#!git

git init [création du .git qui va surveillé le projet]
git remote add origin  git@bitbucket.org:tekofil/tekofil.git [on indique où est le serveur git]
git pull origin master [on récup les sources]
```
* Lorsque l'on a récupéré master on crée tout de suite la branche preprod


```
#!git

git checkout -b preprod
```

* On récupère son contenu 


```
#!git

git pull origin preprod
```


## Comment contribuer? ##

* Lorsque les sources ont été récupérées vous allez créer une branche depuis PREPROD (car elle est toujours en avance sur master et elle est censée être stable aussi) en faisant 

```
#!git

git branch
master
*preprod   [on doit être sur celle-la en vert et avec l'étoile]

git checkout -b feature/laNouvelleFeatureDeLaMort
```

* Quand j'ai finit une partie de ma feature on ajoute les fichiers qu'on a modifié (généralement on ajoute les fichiers séparément et et on commit du coup séparément)

```
#!git

git add leFichier
git commit -m "[ADD || MOD ||FIX] ce que j'ai fait pour voir que je bosse bien ou mal"
```

* Ensuite on push au serveur git

```
#!git

git push origin feature/laNouvelleFeatureDeLaMort
```


## Une fois la feature terminée ##

* Une fois que j'ai terminé je retourne sur preprod 

```
#!git

git checkout preprod
```

* Je fais un pull pour vérifier que je suis à jour

```
#!git

git pull origin preprod
```

* Je rajoute les modifs de ma feature dans preprod

```
#!git

git merge feature/laNouvelleFeatureDeLaMort
```

* Je test en local si tout va bien, si tout va bien et uniquement si tout va bien je push sur preprod

```
#!git

git push origin preprod
```


## Je veux voir le résultat en ligne ##

### http://facebook.tekofil.fr/ ###

Mais avant il faut que le pull request soit accepté et ensuite je mettrai le tout en ligne.
