FROM hhvm/hhvm-proxygen:latest

RUN apt-get update -y && apt-get install -y curl

# Install composer
RUN mkdir /opt/composer
RUN curl -sS https://getcomposer.org/installer | hhvm --php -- --install-dir=/opt/composer

# Install app
RUN rm -rf /var/www/app
ADD . /var/www/app
RUN cd /var/www/app && hhvm /opt/composer/composer.phar install

# Reconfigure HHVM
ADD hhvm/site.ini /etc/hhvm/site.ini

EXPOSE 80