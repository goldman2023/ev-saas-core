1. Add Cloud Server to Hetzner

2. Create new SSH key 

3. Add your public key(s) AND the newly generated SSH public key to new Server

4. Copy newly generated SSH key id_rsa and id_rsa.pub to new server: /root/.ssh/

5. Check if .ssh folder in root has following files: authorized_keys, id_rsa, id_rsa.pub and double check if authorized_keys file has your (EIM/Vukasin/future Team-Lead) public ssh keys ALONG with id_rsa.pub of the previously generated ssh key (which is id_rsa.pub of the server itself)
6.Go as root and install:

6.1 Github - https://www.digitalocean.com/community/tutorials/how-to-install-git-on-ubuntu-20-04
6.1.1 Github settings must be: user.name="{Current developer name}" and user.email="{provided github user for current dev server}"

7. Install PHP 8.1 - https://www.digitalocean.com/community/tutorials/how-to-install-php-8-1-and-set-up-a-local-development-environment-on-ubuntu-22-04
7.1 Intall php-fpm8.1 - apt install php8.1-fpm (https://www.videotutorialzone.com/ubuntu/LAMP/how-to-install-php-and-php-fpm-on-ubuntu-20-04-lamp) + install imagick - php8.1-imagick

8. Install Composer - same link

9. Install nginx - https://www.digitalocean.com/community/tutorials/how-to-install-nginx-on-ubuntu-20-04
9.1 Copy nginx avilable sites conf from main dev server and set ev-saas.com domain instead of dev-wesaas.com
9.2 Enable sites:
=> ln -s /etc/nginx/sites-available/code-server.conf /etc/nginx/sites-enabled/
=> ln -s /etc/nginx/sites-available/ev-saas.com /etc/nginx/sites-enabled/
9.3 Copy *.ev-saas.com SSL cert and key to new server and reference these two files in ssl_certificate and ssl_certificate_key in sites config

10. Install MySQL - https://www.digitalocean.com/community/tutorials/how-to-install-mysql-on-ubuntu-20-04
10.1 Create user with username: app
10.2 Create user with password: #@>)<GDTYD*Ss4Xmh@tDeT_8kMy[-Z
10.3 Import DB(s) from dev server or production

11. Install code-server - https://github.com/coder/code-server - https://coder.com/docs/code-server/latest/guide#using-a-subdomain
11.1 Allow 8080 over ufw (for code-server)
11.2 Create Origin Server SSL in Cloudflare and add both crt an key to root folder and add path to ssl files to nginx sites config(s)
11.3 Open /root/.config/code-server/config.yaml, and set password to: MWq2g2rGDv4qy9WZ AND restart code-server with: systemctl restart code-server@$USER
11.4 Install all extensions from main dev server for VSCode

12. Install Redis - https://www.digitalocean.com/community/tutorials/how-to-install-and-secure-redis-on-ubuntu-20-04 (can be left without password since only localhost can acces it)

13. Add previously created SSH key to Github dev user
14. Clone git repo to /var/www/html + use bash terminal instead of sh (https://www.shanebart.com/set-default-vscode-terminal/) - ADD github to .ssh/config - check https://superuser.com/questions/232373/how-to-tell-git-which-private-key-to-use

15. Install nvm and npm - https://www.digitalocean.com/community/tutorials/how-to-install-node-js-on-ubuntu-20-04 - use Option 3 — Installing Node Using the Node Version Manager

16. Install yarn - npm install --global yarn

17. Run: composer install 
18. Run: yarn install
19. Run: npx mix --mix-config="themes/EvTailwind/webpack.mix.js"

20. Run: chown -R www-data:www-data html