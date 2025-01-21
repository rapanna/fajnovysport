FROM wordpress:latest

# Instalace Composeru
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Nastavení pracovního adresáře
WORKDIR /var/www/html
