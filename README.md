# Neos Moltin Integration

This project can be used to build an e-commerce solutions by integrating [Neos](http://neos.typo3.org) and [Moltin](http://moltin.com).

The current status of the project is pre alpha, so everything can change, explode in your face ... or just don't work. 

This package is not feature complete, we hope to have something stable and a first 1.0 release mid june 2015.

Features
--------

* Basic NodeType mixins to use any NodeTypes as a Product
* Syncronize NodeType with the moltin product on workspace publishing
* Use the PropertyMapper to convert Node to Product Properties
* Use the PropertyMapper to convert Node to Product SKU

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

How to synchronize your product from Neos to Moltin ?
-----------------------------------------------------

You can use the ``Ttree.Moltin:ProductMixins`` in your own NodeType. This mixin add a new tab in the inspector to set default product informations.

The product if created / updated on Moltin backend when you publish the Node to the live workspace.

*Warning: Currently only create and update API is supported. If you delete a product in Neos, it will stay available in the Moltin backend.*

How to convert Node properties to Moltin Product properties ?
-------------------------------------------------------------

This package use Flow PropertyMapper to generate product properties from your Node. This package provide a default type converter. 
You can check the file [NodeToProductConverter.php](Classes/TypeConverter/NodeToProductConverter.php). By creating your own type converter
with a higher priority you can override the type converter.

How to generate a SKU for my product ?
--------------------------------------

By default you need to fill the node property ``productSku`` provided by the ``Ttree.Moltin:ProductMixins``. If you need to generate the SKU based on 
custom logic, you can create a specific type converter. You can check the file [NodeToSkuConverter.php](Classes/TypeConverter/NodeToSkuConverter.php).

*Warning: You SKU must be unique per store, if the SKU is not unique, you can not push your product to Moltin, and Neos will throw an exception when you 
publish your "product" nodes.*

What kind of value is used for the Moltin Product Slug ?
--------------------------------------------------------

By default the node identifier is used for the product slug, you you don't have to deal with the uniqness of this Moltin Product property.

Acknowledgments
---------------

Development sponsored by [ttree ltd - neos solution provider](http://ttree.ch).

If you have any suggestion, feel free to ping us or send us a pull request, send us some beers, or wathever gift ... we even accept sponsoring.

We try our best to craft this package with a lots of love, we are open to sponsoring, support request, ... just contact us.

License
-------

Licensed under MIT, see [LICENSE](LICENSE)