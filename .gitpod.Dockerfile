FROM gitpod/workspace-full

USER gitpod

RUN sudo apt-get install apt-utils

# Stop apache2 because we'll use Docker images
RUN sudo service apache2 stop

# Remove php7.4 and install php8.1, because we need composer install to work properly (even though we'll use Docker image for app)
RUN sudo apt-get remove -yq php7.4 && \
sudo apt install lsb-release ca-certificates apt-transport-https software-properties-common -y && \
sudo add-apt-repository ppa:ondrej/php && \
sudo apt-get update -q && \
sudo apt-get install -yq php8.1 && \
sudo apt install php8.1-{bcmath,xml,fpm,mysql,zip,intl,ldap,gd,cli,bz2,curl,mbstring,pgsql,opcache,soap,cgi} -yq && \
sudo rm -rf /var/lib/apt/lists/*; exit 0;

RUN sudo apt install php8.1-zip -yq
RUN sudo apt install php8.1-curl -yq
RUN sudo apt install php8.1-gd -yq
RUN sudo apt install php8.1-dom -yq

# Install Kool
#RUN sudo curl -fsSL https://kool.dev/install | bash

# Install NVM
#RUN sudo curl -sL https://raw.githubusercontent.com/nvm-sh/nvm/v0.35.0/install.sh -o install_nvm.sh
#RUN sudo bash install_nvm.sh
#RUN sudo export NVM_DIR="$HOME/.nvm" [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" [ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"; exit 0;
#RUN sudo source ~/.bash_profile; exit 0;

# Install Node, npm, npx
#RUN sudo nvm install 15.14.0; exit 0;
