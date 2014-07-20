<?php 


// src/VDM/ApiBundle/Command/VdmCommand.php
namespace VDM\ApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use VDM\ApiBundle\Entity\Vdm;
use Doctrine\ORM\EntityManager;
use \DateTime;

class VdmCommand extends ContainerAwareCommand
{
  protected $em;

  protected function configure()
  {
    $this
        ->setName('vdm:flux')
        ->setDescription('Récupère les dernières Vie de Merde');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $this->em = $this->getContainer()->get('doctrine')->getManager();
    $this->read("http://feeds.feedburner.com/viedemerde?format=xml");
  }
  
  protected function read($url)
  { 
    $xml = simplexml_load_file($url);

    foreach ($xml->entry as $entry) 
    {
      $name      = $entry->author->name;
      $content   = $entry->content;  
      $published = $entry->published;

      $date = new DateTime($published);      
      $vdm  = new Vdm();

      $vdm->setAuthor($name);
      $vdm->setPublished($date);
      $vdm->setContent($content);

      $this->em->persist($vdm);
      $this->em->flush();
    }
  }
}