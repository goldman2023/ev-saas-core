#!/bin/bash

ssh -o 'StrictHostKeyChecking no' $HOST_STAGING "mysqldump --no-tablespaces -u $DB_USERNAME_STAGING -p$DB_PASSWORD_STAGING $DB_DATABASE_STAGING " > ~/$DB_DATABASE_STAGING.sql
kool run mysql < ~/$DB_DATABASE_STAGING.sql;
