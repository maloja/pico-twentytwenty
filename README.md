# PicoTwentytwenty

![GitHub release (latest by date)](https://img.shields.io/github/v/release/maloja/pico-twentytwenty)

This Plugin adds the Twentytwenty image comparison slider in [Pico CMS](http://picocms.org). For further reading see also https://github.com/zurb/twentytwenty

## Screenshots


## Installation

Copy the files from Github https://github.com/maloja/pico-twentytwenty into your Pico CMS plugins folder `plugins/PicoTwentyTwenty`

or clone directly from Github in `plugins/PicoTwentyTwenty`

    cd plugins
    git clone https://github.com/maloja/pico-twentytwenty

or, if you installed Pico CMS with composer

    composer require maloja/pico-twentytwenty

The installation via composer will automatically install the jQuery (see below).

### Permissions

By default your Pico CMS installation will not permit access to javascript files in your `vendor` or `plugins` folders. Make sure yor'll grant access to these files by modifying the Pico CMS `.htaccess` file

    # Permit direct access to jquery scripts
    RewriteRule ^vendor/components/jquery.*\.(js)$ - [L,NC]

## Usage

Add the following expression in your Markdown file:

`(% imgcompare ( /path/to/image1.jpg, /path/to/image2.jpg ) %)`


## Dependencies

This plugin requires **jQuery** to run correctly. If PicoTwentytwenty is installed via composer, then jquery will be installed automatically. Otherwise, jQuery can also be installed manually and will usually be stored under `/yourdomain/vendor/components/jquery`. By default, Pico CMS does not allow access to jquery.js. The Pico `.htaccess` file must be adapted for this.

`RewriteRule ^vendor/components/jquery.*\.(js)$ - [L,NC]`

Then jQuery can be integrated into the Twig templates.

`<script src="vendor/components/jquery/jquery.min.js"></script>`


