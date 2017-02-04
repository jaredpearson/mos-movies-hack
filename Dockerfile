FROM hhvm/hhvm-proxygen:latest

RUN apt-get update -y && apt-get install -y curl

# Install composer
RUN mkdir /opt/composer
RUN curl -sS https://getcomposer.org/installer | hhvm --php -- --install-dir=/opt/composer

# Install app
RUN rm -rf /var/www/public
ADD ./public /var/www/public
RUN cd /var/www/public && hhvm /opt/composer/composer.phar install

EXPOSE 80