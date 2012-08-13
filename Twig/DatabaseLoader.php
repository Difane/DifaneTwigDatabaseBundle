<?php

namespace Difane\Bundle\TwigDatabaseBundle\Twig;

use Twig_LoaderInterface;
use Twig_Error_Loader;

class DatabaseLoader implements Twig_LoaderInterface
{
    private $entityManager;
    private $logger;

    public function __construct($entityManager, $logger)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function getSource($name)
    {        
        $this->logger->debug("DatabaseLoader::getSource() called with parameters[name: ".$name."]");

        $template = $this->entityManager->getRepository('DifaneTwigDatabaseBundle:Template')->getTemplate($name);

        if($template instanceof \Difane\Bundle\TwigDatabaseBundle\Entity\Template)
        {
            return $template->getContent();
        }
        else
        {
            throw new Twig_Error_Loader(sprintf('TwigDatabase: Unable to find template "%s".', $name));            
        }
    }

    public function isFresh($name, $time)
    {
        $this->logger->debug("DatabaseLoader::isFresh() called with parameters[name: ".$name.", time:".$time."]");

        $templateTimestamp = $this->entityManager->getRepository('DifaneTwigDatabaseBundle:Template')->getTemplateTimestamp($name);

        if(false == is_null($templateTimestamp))
        {
            return  ($templateTimestamp <= $time);
        }
        else
        {
            throw new Twig_Error_Loader(sprintf('TwigDatabase: Unable to find template "%s".', $name));            
        }
    }

    public function getCacheKey($name)
    {
        $this->logger->debug("DatabaseLoader::getCacheKey() called with parameters[name: ".$name."]");
        
        return "twig:db:".$name;
    }
}