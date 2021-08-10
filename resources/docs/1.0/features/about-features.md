#Features

This is the documentation about available features in this project.

## Available Features

* Events (events)
* News
* More features to be added when developing the project...

## Dependencies and Coding Practices

This project uses `ylsideas/feature-flags` composer package to enable usage of features based logic in aplication code.

For documentation and extensive examples please check github:
https://github.com/ylsideas/feature-flags

## Usage

###Blade

To check agains enabled features you use following syntax
```phpt
@feature('my-feature')
    <p>Your feature flag is turned on.
@endfeature

```

###Feature accesibility
```phpt
Features::accessible('my-feature') // returns true or false
```
