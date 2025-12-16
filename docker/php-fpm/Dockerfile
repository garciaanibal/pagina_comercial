# Usa la imagen de PHP
FROM phpdockerio/php:8.1-fpm

# Establece el directorio de trabajo
WORKDIR "/application"

# Instala dependencias necesarias y limpia la caché
RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        git \ 
        php8.1-mysql php8.1-gd php8.1-intl \
        curl \
        ca-certificates \
        xz-utils; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Descarga y descomprime el archivo binario de Node.js
RUN curl -o node.tar.xz https://nodejs.org/dist/v20.11.0/node-v20.11.0-linux-x64.tar.xz \
    && tar -xf node.tar.xz --strip-components=1 -C /usr/local \
    && rm node.tar.xz

RUN apt-get update && apt-get install -y curl gnupg2 && \
    curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && \
    apt-get update && apt-get install -y yarn

