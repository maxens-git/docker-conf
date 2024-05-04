# Authelia avec Nginx proxy manager


## Modification de la stack NPM

Ajoutez dans le fichier docker-compose.yml de npm la ligne :
```
- /docker/npm/snippets:/snippets
```

Puis deplacez le fichier snippets dans le dossier /docker/npm.

Attention !! : La ligne n°25 du fichier authelia-authrequest.conf doit être modifié avec l'url du site

## Creation du proxy dans NPM
Creez le proxy d'authelia dans npm
```
http://authelia:9091
```

Ajoutez dans advanced le code suivant :
```
location / {
    include /snippets/proxy.conf;
    proxy_pass $forward_scheme://$server:$port;
}
```

## Ajout de site 
Chaque ajout de site doit être référencé dans le fichier configuration.yml d'authelia, et dans NPM > Advanced doit être spécifié :
```
include /snippets/authelia-location.conf;
location / {
    include /snippets/proxy.conf;
    include /snippets/authelia-authrequest.conf;
    proxy_pass $forward_scheme://$server:$port;
}
```
## Générer client_secret
```
sudo docker run authelia/authelia:latest authelia crypto hash generate pbkdf2 --variant sha512 --random --random.length 72 --random.charset rfc3986
```

```
sudo docker run authelia/authelia:latest authelia crypto rand --length 72 --charset rfc3986

sudo docker run authelia/authelia:latest authelia crypto rand --length 64 --charset alphanumeric
```
## Générer des certificats pour openid connect
```
sudo docker run authelia/authelia:latest authelia crypto certificate rsa generate && cat private.pem && cat public.crt
```
