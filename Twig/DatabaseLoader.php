<?php

namespace Difane\Bundle\TwigDatabaseBundle\Twig;

use Twig_LoaderInterface;
use Twig_Error_Loader;

class DatabaseLoader implements Twig_LoaderInterface
{
    private $entityManager;
    private $logger;
    private $autoCreateTemplates;

    public function __construct($entityManager, $logger, $autoCreateTemplates)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->autoCreateTemplates = $autoCreateTemplates;
    }

    public function getSource($name)
    {
        $this->logger->debug("DatabaseLoader::getSource() called with parameters[name: ".$name."]");

        $template = $this->entityManager->getRepository('DifaneTwigDatabaseBundle:Template')->getTemplate($name);

        if ($template instanceof \Difane\Bundle\TwigDatabaseBundle\Entity\Template) {
            $this->logger->debug("DatabaseLoader::getSource() Template was found. Returning its content.");

            return $template->getContent();
        } else {
            $this->logger->debug("DatabaseLoader::getSource() Template was not found. Trying to create it.");
            $newTemplate = $this->tryCreateTemplate($name);
            if (true == is_null($newTemplate)) {
                throw new Twig_Error_Loader(sprintf('TwigDatabase: Unable to find template "%s".', $name));
            } else {
                return $newTemplate->getContent();
            }
        }
    }

    public function isFresh($name, $time)
    {
        $this->logger->debug("DatabaseLoader::isFresh() called with parameters[name: ".$name.", time:".$time."]");

        $templateTimestamp = $this->entityManager->getRepository('DifaneTwigDatabaseBundle:Template')->getTemplateTimestamp($name);

        if (false == is_null($templateTimestamp)) {
            $this->logger->debug("DatabaseLoader::isFresh() Template was found. Returning its fresh status");

            return  ($templateTimestamp <= $time);
        } else {
            $this->logger->debug("DatabaseLoader::isFresh() Template was not found. Trying to create it.");
            if (true == is_null($this->tryCreateTemplate($name))) {
                throw new Twig_Error_Loader(sprintf('TwigDatabase: Unable to find template "%s".', $name));
            } else {
                return false;
            }
        }
    }

    public function getCacheKey($name)
    {
        $this->logger->debug("DatabaseLoader::getCacheKey() called with parameters[name: ".$name."]");

        return "twig:db:".$name;
    }

    private function tryCreateTemplate($name)
    {
        if( false == $this->autoCreateTemplates ) return null;

        try {
            $template = new \Difane\Bundle\TwigDatabaseBundle\Entity\Template();
            $template->setName($name);
            $template->setContent("{% for i in range(0, 3) %} Lorem ipsum dolor sit amet. {% endfor %}");
            $this->entityManager->persist($template);
            $this->entityManager->flush();

            return $template;
        } catch (\Exception $ex) {
            return null;
        }
    }
}
