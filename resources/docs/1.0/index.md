- ## Get Started
    - [Overview](/{{route}}/{{version}}/overview)
    - [Project Structure ](/{{route}}/{{version}}/testing-and-qa)
    - [Testing and QA](/{{route}}/{{version}}/testing-and-qa)
    - [Frontend Guidelines](/{{route}}/{{version}}/frontend-guidelines)
    - [Multilanguge Guidelines](/{{route}}/{{version}}/multilanguage-guidelines)



## Project Structure

### Javascript 

All of the dependencies that are used by ActiveCommere are located in:
`resources/js/vendor` 


`resources/js/vendor/vendors.js` - This File include all of the libraries and external dependencies (jQuery, Slick Slider, etc)

`resources/js/vendor/aiz-core.js` - This includes custom jQuery functions for default ActiveCommerce functionality to work

`resouces/js/app.js` - Custom jQuery Code for This Specific Project

### CSS

`resources/sass/app.scss` - This is main entry file for css

Custom css should be added to `resources/sass/compnents/index.scss` and `resources/sass/pages/index.scss`

* Other folders can be added if needed, but follow the general structure