FROM gitpod/workspace-mysql

USER root

# setup php 7.4
RUN apt-get update && \
    add-apt-repository ppa:ondrej/php && \
    install-packages php7.4 && \
    update-alternatives --set php /usr/bin/php7.4

RUN apt update && \
    apt-get install -y php7.4-cli php7.4-json php7.4-common php7.4-mysql php7.4-zip php7.4-gd php7.4-mbstring php7.4-curl php7.4-xml php7.4-bcmath

# install wp-cli
RUN apt-get update && \
    apt-get install -y wget && \
    wget https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
    chmod +x wp-cli.phar && \
    mv wp-cli.phar /usr/local/bin/wp && \
    apt-get install -y xdg-utils && \
    apt -y install rsync grsync

USER gitpod
