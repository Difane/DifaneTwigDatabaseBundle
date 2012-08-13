<?php

namespace Difane\Bundle\TwigDatabaseBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TemplateRepository extends EntityRepository
{
    public function getTemplate($name)
    {
        try
        {
            return $this->getEntityManager()->createQuery('
                SELECT t FROM DifaneTwigDatabaseBundle:Template t                
                WHERE t.name = :name
            ')
            ->setParameter('name', $name)
            ->getSingleResult();
        }
        catch (\Doctrine\ORM\NoResultException $e)
        {
            return null;
        }
    }

    public function getTemplateTimestamp($name)
    {
        try
        {
            return $this->getEntityManager()->createQuery('
                SELECT t.updated_at FROM DifaneTwigDatabaseBundle:Template t                
                WHERE t.name = :name
            ')
            ->setParameter('name', $name)
            ->getSingleScalarResult();
        }
        catch (\Doctrine\ORM\NoResultException $e)
        {
            return null;
        }
    }
}