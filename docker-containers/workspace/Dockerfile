FROM phusion/baseimage:latest


# RUN apt-get install -y software-properties-common && \
#     add-apt-repository -y ppa:ondrej/php
    
# # Install PHP Extentions
# RUN apt-get update && \
#     apt-get install -y --allow-downgrades --allow-remove-essential \
#         --allow-change-held-packages \
#         php7.1-cli \
#         php7.1-common \
#         php7.1-curl \
#         php7.1-intl \
#         php7.1-json \
#         php7.1-xml \
#         php7.1-mbstring \
#         php7.1-mcrypt \
#         php7.1-mysql \
#         php7.1-pgsql \
#         php7.1-sqlite \
#         php7.1-sqlite3 \
#         php7.1-zip \
#         php7.1-bcmath \
#         php7.1-memcached \
#         php7.1-gd \
#         php7.1-dev \
#         pkg-config \
#         libcurl4-openssl-dev \
#         libedit-dev \
#         libssl-dev \
#         libxml2-dev \
#         xz-utils \
#         libsqlite3-dev \
#         sqlite3 \
#         git \
#         curl \
#         vim \
#         nano \
#         postgresql-client \
#         mysql-client \
#     && apt-get clean


# Set default work directory
WORKDIR /var/www


# RUN apt-get update && apt-get install apt-transport-https && \
#     curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
#     echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && \
#     apt-get update && apt-get install -y yarn mysql-client