# Neos Moltin Integration

This project can be used to build an e-commerce solutions by integrating [Neos](http://neos.typo3.org) and [Moltin](http://moltin.com).

The current status of the project is pre alpha, so everything can change, explode in your face ... or just don't work. 

This package is not feature complete, we hope to have something stable and a first 1.0 release mid june 2015.

Features
--------

* Basic NodeType mixins to use any NodeTypes as a Product
* Syncronize NodeType with the moltin product on workspace publishing
* Use the PropertyMapper to convert Node to Product (so feel free to use your own TypeConverter, ex. you can generate your SKU, extract content for the description, ...)

Next steps
----------

* Delete product on Moltin when the node is deleted from the content repository
* TypoScript object to display the Moltin card (basket)
* Support JS SDK integration
* Support for flexible checkout (JS + PHP)
* Add a cache layer on top of Moltin API, based on Caching Framework
* Javascript Inspector editor to connect directly to Moltin (live dashboard)
* Support Moltin Webhooks to update cached data in Neos
* General Dashboard module to have an overview of the shop

Acknowledgments
---------------

Development sponsored by [ttree ltd - neos solution provider](http://ttree.ch).

If you have any suggestion, feel free to ping us or send us a pull request, send us some beers, or wathever gift ... we even accept sponsoring.

We try our best to craft this package with a lots of love, we are open to sponsoring, support request, ... just contact us.

License
-------

Licensed under MIT, see [LICENSE](LICENSE)