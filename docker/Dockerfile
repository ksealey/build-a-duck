FROM amd64/ubuntu:focal

# Set to non-interactive
ENV DEBIAN_FRONTEND=noninteractive

# Update repos
RUN apt-get update && \
    apt-get install -y unzip curl

# Add php repo
RUN apt-get install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php
RUN apt-get update && apt-get upgrade -y

# Install PHP 8.2
RUN apt-get install -y \
  php8.2-cli \
  php8.2 \
  php8.2-dev \
  libcurl4-openssl-dev \
  pkg-config \
  libssl-dev \
  apache2 \
  pkg-config \
  php-xml \
  php8.2-apcu \
  php8.2-gd \
  php-json \
  php8.2-ldap \
  php8.2-mbstring \
  php8.2-mysql \
  php8.2-pgsql \
  php8.2-sqlite3 \
  php8.2-soap \
  php8.2-xml \
  php8.2-zip \
  php8.2-curl \
  php8.2-gmp \
  php8.2-grpc \
  php8.2-bcmath \
  php8.2-intl \
  php8.2-redis \
  vim \
  awscli \ 
  libmagickwand-dev \
  imagemagick \
  jq

# Install mongo db driver
RUN apt-get install php-pear && yes '' | pecl install mongodb

# Install imagick extension
RUN apt-get install -y php-imagick

# Switch to PHP 8.2
RUN update-alternatives --set php /usr/bin/php8.2

# Install NVM
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.5/install.sh | bash \
    && export NVM_DIR="$HOME/.nvm" && [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" && [ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion" \
    && nvm install 18 

# Copy apache config 
COPY apache/config/vhost /etc/apache2/sites-available/000-default.conf

# Copy php.ini file
COPY php/php.ini /etc/php/8.2/apache2/php.ini
COPY php/php.ini /etc/php/8.2/cli/php.ini

# Install composer 
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=bin --filename=composer
RUN php -r "unlink('composer-setup.php');"

# Enable Mods
RUN a2enmod rewrite
RUN a2enmod headers

# Expose http
EXPOSE 80

# Kickstart apache
CMD ["/usr/sbin/apachectl", "-D", "FOREGROUND"]