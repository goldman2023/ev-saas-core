# BusinessPress Components

BusinessPress uses 2 main types of components

* Blade Components
* Livewire Components


## Components best practices

For reusability purposes we recommend abstracting related Livewire components into single Blade component to be used directly in theme. 

## Overiding components

Any component can be overided in child theme, by using the same structure as in BusinessPress core or any parent theme. 

Main view files are located inside `resources/views` 

If you create any file inside theme located in: `themes/{ThemeName}/views` it will first check for theme view files. If none are found then will resolve with original files from `resources/views` 
