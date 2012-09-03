Installation
============

Add bundle requirement to composer.json

.. code-block:: php
    :emphasize-lines: 3

    "require": {
        ...
        "difane/difane-twig-database-bundle": "dev-master",
        ...
    }

Run composer to download library and it's dependencies

.. code-block:: bash

    php composer.phar update

Register the bundle in ``app/AppKernel.php``:

.. code-block:: php
    :emphasize-lines: 4

    <?php
    $bundles = array(
        // ...
        new Difane\Bundle\TwigDatabaseBundle\DifaneTwigDatabaseBundle(),
    );