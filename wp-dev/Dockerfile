FROM wordpress:latest

# Install composer
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Uncomment if need clear default templates
# RUN rm -rf /var/www/html/wp-content/themes/twentytwentyfive \
#     /var/www/html/wp-content/themes/twentytwentyfour \
#     /var/www/html/wp-content/themes/twentytwentythree

# Set working directory
WORKDIR /var/www/html
