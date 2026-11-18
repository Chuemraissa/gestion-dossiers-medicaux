# 1. On part d'une image officielle qui contient déjà PHP 8.3 et Apache
FROM php:8.3-apache

# 2. On ajoute les extensions PHP qui manquent : pdo_mysql (parler à MySQL) et zip
RUN apt-get update && apt-get install -y libzip-dev unzip \
    && docker-php-ext-install pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# 3. On active la réécriture d'adresses (nécessaire aux routes Laravel)
RUN a2enmod rewrite

# 4. Apache doit servir le dossier public/ de Laravel, pas la racine du projet
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf

# 5. On récupère Composer depuis son image officielle
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 6. Dossier de travail dans le conteneur
WORKDIR /var/www/html

# 7. On copie le code du projet dans l'image
COPY . .

# 8. On installe les bibliothèques Laravel (dossier vendor/)
RUN composer install --no-interaction --optimize-autoloader

# 9. Apache (utilisateur www-data) doit pouvoir écrire les logs, sessions et cache
RUN chown -R www-data:www-data storage bootstrap/cache