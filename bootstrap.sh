#!/bin/bash

source config/environment.sh

echo "Luodaan projektikansio..."

# Luodaan projektin kansio
ssh kauvo@users.cs.helsinki.fi "
cd htdocs
touch favicon.ico
mkdir muistilista
cd muistilista
touch .htaccess
echo 'RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [QSA,L]' > .htaccess
exit"

echo "Valmis!"

echo "Siirretään tiedostot users-palvelimelle..."

# Siirretään tiedostot palvelimelle
scp -r app config lib vendor sql assets index.php composer.json kauvo@users.cs.helsinki.fi:htdocs/muistilista

echo "Valmis!"

echo "Asetetaan käyttöoikeudet ja asennetaan Composer..."

# Asetetaan oikeudet ja asennetaan Composer
ssh kauvo@users.cs.helsinki.fi "
chmod -R a+rX htdocs
cd htdocs/muistilista
curl -sS https://getcomposer.org/installer | php
php composer.phar install
exit"

echo "Valmis! Sovelluksesi on nyt valmiina osoitteessa kauvo.users.cs.helsinki.fi/muistilista"
