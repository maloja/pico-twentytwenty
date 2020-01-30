# PicoTwentytwenty

![GitHub release (latest by date)](https://img.shields.io/github/v/release/maloja/pico-twentytwenty)

This Plugin adds the Twentytwenty image comparison slider in [PicoCMS](http://picocms.org). For further reading see also https://github.com/zurb/twentytwenty

## Installation

Copy the files from Github https://github.com/maloja/pico-twentytwenty into your Pico CMS plugins folder `plugins/PicoTwentyTwenty`

or clone directly from Github in `plugins/PicoTwentyTwenty`

    cd plugins
    git clone https://github.com/maloja/pico-twentytwenty

or, if you installed Pico CMS with composer

    composer require maloja/pico-twentytwenty

The installation via composer will automatically install the jQuery library into vour main vendor folder under `vendor/components/jquery`, if not allready installed.

### Permissions

By default your Pico CMS installation will not permit access to javascript files in your `vendor` or `plugins` folders. Make sure yor'll grant access to these files by modifying the Pico CMS `.htaccess` file

    # Permit direct access to jquery scripts
    RewriteRule ^vendor/components/jquery.*\.(js)$ - [L,NC]

## Usage

Add the following expression in your Markdown file:

`(% imgcompare ( image1.jpg, image2.jpg ) %)`

where:

| filename  | image location|
| :-------- | :-------      |
| http://foo.bar/image1.jpg | external images from the web            |
| /assets/foo/image1.jpg    | internal image                          |
| image1.jpg                | internal image within the content folder|



## Dependencies
This Plugin depends on the **jQuery** library. Therefore some steps are needed to get Pico CMS ready for jQuery. The easiest way is an installation via composer. This will place jquery in the `vendor` folder of Pico CMS

1. Install jQuery `composer require components/jquery`

2. Grant access to jquery.js in your `.htaccess` file: `RewriteRule ^vendor/components/jquery.*\.(js)$ - [L,NC]`

3. Include jQuery in your twig template: `<script src="vendor/components/jquery/jquery.min.js"></script>`

