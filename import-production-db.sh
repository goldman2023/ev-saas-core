#!/bin/bash

ssh -o 'StrictHostKeyChecking no' $HOST_PRODUCTION "mysqldump --no-tablespaces -u $DB_USERNAME_PRODUCTION -p$DB_PASSWORD_PRODUCTION $DB_DATABASE_PRODUCTION " > ~/$DB_DATABASE_PRODUCTION.sql
kool run mysql < ~/$DB_DATABASE_PRODUCTION.sql; exit;
