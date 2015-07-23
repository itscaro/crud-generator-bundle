# CrudGeneratorBundle

This Symfony2 bundle extends [SensioGeneratorBundle] (https://github.com/sensio/SensioGeneratorBundle), it creates a nice CRUD with pagination, filter, translation and Twitter bootstrap 3 features.

This bundle is based on the one made by Jordi Llonch [CrudGeneratorBundle] (https://github.com/jordillonch/CrudGeneratorBundle)

[![Build Status](https://secure.travis-ci.org/itscaro/crud-generator-bundle.png?branch=master)](http://travis-ci.org/itscaro/crud-generator-bundle)

## Screenshot

![Screenshot](https://raw.github.com/itscaro/crud-generator-bundle/master/screenshot.png "Screenshot")

## Why use a CRUD generator?

Well, because CRUD generator creates simple code, no magic, no configuration files, just simple and plain code that you can extend and modify easily.

## Installation

Add following lines to your `composer.json` file:

    "require": {
      "itscaro/crud-generator-bundle": "dev-master"
    },

Execute:

    php composer.phar update

Add it to the `AppKernel.php` class:

    new Lexik\Bundle\FormFilterBundle\LexikFormFilterBundle(),
    new Itscaro\CrudGeneratorBundle\ItscaroCrudGeneratorBundle(),

Add it to your `app/config/config.yml`

    framework:
        translator: { fallback: en }

    twig:
        form:
            resources:
                - LexikFormFilterBundle:Form:form_div_layout.html.twig

**This bundle works on Symfony >= 2.5 version.**

## Dependencies

This bundle extends [SensioGeneratorBundle](https://github.com/sensio/SensioGeneratorBundle) and add 

* a paginator using [KnpPaginatorBundle](https://github.com/knplabs/knp-paginator-bundle)
* a filter support using [LexikFormFilterBundle](https://github.com/lexik/LexikFormFilterBundle)

## Usage

Use following command from console:

    app/console itscaro:generate:crud
    
or to generate for all entities in a bundle
    
    app/console itscaro:generate:all BUNDLE_NAME

## Translation
Put your translations in :
* BUNDLE_DIR/Resources/translations/ItscaroCrudGeneratorBundle.<locale>.yml
* ROOT_DIR/app/Resources/translations/ItscaroCrudGeneratorBundle.<locale>.yml

## Use your own skeleton

You can put your own templates in :
* BUNDLE_DIR/Resources/ItscaroCrudGeneratorBundle/skeleton
* ROOT_DIR/app/Resources/ItscaroCrudGeneratorBundle/skeleton

## Credits

Jordi Llonch

## License

CrudGeneratorBundle is licensed under the MIT License. See the LICENSE file for full details.
