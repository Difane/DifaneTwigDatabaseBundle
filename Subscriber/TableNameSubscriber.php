<?php
namespace Difane\Bundle\TwigDatabaseBundle\Subscriber;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

class TableNameSubscriber implements \Doctrine\Common\EventSubscriber
{
    protected $name = '';

    public function __construct($name)
    {
        $this->name = (string) $name;
    }

    public function getSubscribedEvents()
    {
        return array('loadClassMetadata');
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        $classMetadata = $args->getClassMetadata();

        if('Difane\Bundle\TwigDatabaseBundle\Entity\Template' != $classMetadata->getName()) return;

        $classMetadata->setTableName($this->name);
        foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping) {
            if ($mapping['type'] == \Doctrine\ORM\Mapping\ClassMetadataInfo::MANY_TO_MANY) {
                //$mappedTableName = $classMetadata->associationMappings[$fieldName]['joinTable']['name'];
                $classMetadata->associationMappings[$fieldName]['joinTable']['name'] = $this->name;
            }
        }
    }

}
