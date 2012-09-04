Configuration
=============

Configuration options

* ``difane_twig_database``
    * ``table_name`` : Table name for storing templates
    * ``auto_create_templates`` : Set to **true** if You want to automatically create referenced templates that are not exists
    * ``sonata_admin``
        * ``enabled`` : Set to **true** if You want to enable Sonata-Admin integration
        * ``group`` : Sonata-Admin group name
        * ``label`` : Sonata-Admin label name

Full Configuration Options
--------------------------

.. code-block:: yaml

    difane_twig_database:
        table_name: "MyTwigTable"                   # Default is 'difane_twig_database_template'
        auto_create_templates: true                 # Default is false
        sonata_admin:
            enabled: true                           # Default is true
            group: "This is my group"               # Default is 'Twig'
            label: "Twig Templates from bundle"     # Default is 'Templates'
