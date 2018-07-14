FROM php:7.1.3-alpine

LABEL maintainer="Ryan Durham <ryan@stagerightlabs.com>"

RUN apk update && \
    apk upgrade && \
    apk add git curl openssh

# clean
RUN rm -rf /tmp/* /var/cache/apk/*

# Operate as a non-root user
RUN adduser -D -u 1000 devop
USER devop

RUN mkdir -p /home/devop/composer
ENV PATH "/home/devop/composer/:${PATH}"

# Install composer
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/home/devop/composer/ --filename=composer
