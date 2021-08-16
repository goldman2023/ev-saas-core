#!/usr/bin/env bash
while getopts ":pdw" option; do
   case $option in
      d) echo "Compiling(DEV): Central Webpack"
         npx mix --mix-config="webpack.mix.js" # Compile CENTRAL and ADMIN app
         for theme in themes/*/     # list directories in the form "/themes/{theme_name}/"
         do
            echo "Compiling(DEV): ${theme}webpack.mix.js"
            npx mix --mix-config="${theme}webpack.mix.js" # Compile current theme webpack
         done
         exit;;
      p) echo "Compiling(PROD): Central Webpack"
         npx mix --mix-config="webpack.mix.js" --production # Compile CENTRAL and ADMIN app
         for theme in themes/*/     # list directories in the form "/themes/{theme_name}/"
         do
            echo "Compiling(PROD): ${theme}webpack.mix.js"
            npx mix --mix-config="${theme}webpack.mix.js" --production # Compile current theme webpack
         done
         exit;;
      w) echo "Compiling(WATCH): Central Webpack"
         npx -q mix watch --mix-config="webpack.mix.js" # Compile CENTRAL and ADMIN app
         for theme in themes/*/     # list directories in the form "/themes/{theme_name}/"
         do
           echo "Compiling(PROD): ${theme}webpack.mix.js"
           npx -q mix watch --mix-config="${theme}webpack.mix.js" # Compile current theme webpack
         done
         exit;;
   esac
done
