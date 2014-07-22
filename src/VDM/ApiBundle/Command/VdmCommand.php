<?php
// src/VDM/ApiBundle/Command/VdmCommand.php
namespace VDM\ApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;
use VDM\ApiBundle\Entity\Vdm;
use Doctrine\ORM\EntityManager;
use \DateTime;

class VdmCommand extends ContainerAwareCommand
{
  protected $em;
  protected $path;

  protected function configure()
  {
    $this
        ->setName('vdm:flux')
        ->setDescription('Extract the last 200 VDM and insert them into database');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $kernel      = $this->getContainer()->get('kernel');
    $this->path  = $kernel->locateResource('@ApiBundle/Resources/public/html');
    $this->em    = $this->getContainer()->get('doctrine')->getManager();
    $output->writeln('<info>Current processing</info>');
    $this->wrapper();
  }

  // Function to extract Vdm to Viedemerde.fr
  protected function wrapper(){
    $html = $this->path."/vdm.html";
    $i    = 0;
    $j    = 1;

    while ($j <= 200){
        $i++;
        $url     = "http://www.viedemerde.fr/?page={$i}";
        $current = file_get_contents($url);

        file_put_contents($this->path."/vdm.html",$current);
        $j = $this->read($html, $j);
      }
    $this->em->getRepository('ApiBundle:Vdm')->deleteAll();
    $this->em->flush();
  }

  // Function to parse Html Extracted
  protected function read($url, $j)
  {
    $file       = file_get_contents($url);
    $crawler    = new Crawler($file);

    $nodeValues = $crawler->filterXPath("//div[@class='post article']")->each(function ($node, $i) {

      $author     = $this->getAuthor($node);
      $published  = $this->getPublished($node);
      $content    = $this->getContent($node);

      $date =  DateTime::createFromFormat('d/m/Y H:i', $published);
      $vdm  = new Vdm();

      $vdm->setAuthor($author);
      $vdm->setPublished($date);
      $vdm->setContent($content);

      $this->em->persist($vdm);

    });
    return $j += count($nodeValues);
  }


  // Collect content of curent VDM
  public function getContent($nodes){
    $content = $nodes->filterXPath("//a[@class='fmllink']")->each(function ($node, $i) {
        return $node->text();
    });

    $content_str = implode("", $content);
    return $content_str;
  }

  // Collect published date of current VDM
  public function getPublished($node){
    $published = $node->filterXPath("//div[@class='right_part']/p/text()[substring-before(.,' -')]")->last()->text();

    $published = str_replace(' - ', '', $published);
    $published = str_replace('Le ', '', $published);
    $published = str_replace(' à', '', $published);

    return $published;
  }

  // Collect author of  current VDM
  public function getAuthor($node){
    $author = $node->filterXPath("//div[@class='right_part']/p/text()[substring-after(.,'- ')]")->last()->text();

    $author = str_replace('- ', '', $author);
    $author = str_replace(' (', '', $author);
    $author = str_replace(' par ', '', $author);

    return $author;
  }
}