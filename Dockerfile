FROM php:8.1-cli

# Instalace curl, git a unzip (potřebné pro Composer a PHPStan)
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip

# Instalace Composeru
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalace PHPStan přes Composer
RUN /usr/local/bin/composer global require phpstan/phpstan

# Přidání cesty Composeru do PATH
ENV PATH="/root/.composer/vendor/bin:${PATH}"

# Nastavení pracovního adresáře
WORKDIR /app
COPY . .

# Spuštění PHPStan
CMD ["phpstan", "analyse", "wp"]
