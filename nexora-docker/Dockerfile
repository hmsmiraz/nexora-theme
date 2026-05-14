FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y \
    apache2 \
    php \
    php-mysql \
    php-curl \
    php-gd \
    php-mbstring \
    php-xml \
    php-zip \
    wget \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

# Download WordPress
RUN wget -q https://wordpress.org/latest.tar.gz -O /tmp/wordpress.tar.gz \
    && tar -xzf /tmp/wordpress.tar.gz -C /var/www/html/ \
    && rm /tmp/wordpress.tar.gz

# Clone Nexora theme
RUN git clone https://github.com/hmsmiraz/nexora-theme.git \
    /var/www/html/wordpress/wp-content/themes/nexora-theme

# WordPress config
COPY wp-config.php /var/www/html/wordpress/wp-config.php

# Apache config
COPY wordpress.conf /etc/apache2/sites-available/wordpress.conf
RUN a2ensite wordpress.conf \
    && a2dissite 000-default.conf \
    && a2enmod rewrite

RUN chown -R www-data:www-data /var/www/html/wordpress

EXPOSE 80

CMD ["apachectl", "-D", "FOREGROUND"]