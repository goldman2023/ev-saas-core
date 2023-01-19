#!/bin/bash

for theme in $(ls ./themes); do
    if [ -f "./themes/${theme}/webpack.mix.js" ]; then
        echo "PROD Compilation starting for theme: ${theme}"
        npx mix --production --mix-config="themes/${theme}/webpack.mix.js"
    fi
done