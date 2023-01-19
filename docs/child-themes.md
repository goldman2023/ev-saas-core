# Child Themes

All child themes are automatically registered via filesystem. 
All Child them code is located in `themes/{themeName}` 

Default theme is `WeTailwind`

## Creating new child theme 

To create a new child theme run this command in your terminal in your project root
`php artisan make:theme` 

## Using a theme

All of the theme assignment is done inside Theme Middleware, located in:  
* `/app/Http/Middleware/ThemeMiddleware.php`

Themes can be set based on:
* Domain
* User account settings
* Website language

You can apply your custom logic by extending ThemeMidleware.php 


## Theme Specific code

Theme specific logic extending theme with custom functions or overides can be added in:
`/themes/{ThemeName}/App/Providers/ThemeFunctionsServiceProvider.php`


*Themes support is comming from: https://github.com/qirolab/laravel-themer 

