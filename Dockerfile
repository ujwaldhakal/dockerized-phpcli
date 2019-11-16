FROM php:7.3-cli

RUN apt-get update && apt-get install -y && apt-get install git -y
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

WORKDIR /cli

CMD ["php"]
