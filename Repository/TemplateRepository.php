<?php

namespace Difane\Bundle\TwigDatabaseBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TemplateRepository extends EntityRepository
{
    public function getTemplate($name)
    {
        try {
            return $this->getEntityManager()->createQuery('
                SELECT t FROM DifaneTwigDatabaseBundle:Template t
                WHERE t.name = :name
            ')
            ->setParameter('name', $name)
            ->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    public function getTemplateTimestamp($name)
    {
        try {
            $result = $this->getEntityManager()->createQuery('
                SELECT t.updated_at FROM DifaneTwigDatabaseBundle:Template t
                WHERE t.name = :name
            ')
            ->setParameter('name', $name)
            ->getSingleResult();

            if (false == is_null($result) && is_array($result) && array_key_exists("updated_at", $result)) {
                return $result["updated_at"]->getTimestamp();
            } else {
                return null;
            }
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}
