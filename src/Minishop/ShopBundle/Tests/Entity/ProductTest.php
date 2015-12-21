<?php
/**
 * Created by PhpStorm.
 * User: raymond
 * Date: 22/12/15
 * Time: 9:11 AM
 */
namespace Minishop\ShopBundle\Entity;

use Doctrine\Bundle\DoctrineBundle\Command\CreateDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\DropDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\Proxy\CreateSchemaDoctrineCommand;
use Minishop\ShopBundle\Entity\Product as Product;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class ProductTest extends WebTestCase
{
  private $em;
  private $application;

  public function setUp()
  {
    static::$kernel = static::createKernel();
    static::$kernel->boot();

    $this->application = new Application(static::$kernel);

    //drop database
    $command = new DropDatabaseDoctrineCommand();
    $this->application->add($command);
    $input = new ArrayInput(array(
      'command' => 'doctrine:database:drop',
        '--force' => true
    ));
    $command->run($input, new NullOutput());

    //close database connection temprary
    $connection = $this->application->getKernel()->getContainer()->get('doctrine')->getConnection();
    if ($connection->isConnected()) {
      $connection->close();
    }

    //create database
    $command = new CreateDatabaseDoctrineCommand();
    $this->application->add($command);
    $input = new ArrayInput(array(
      'command' => 'doctrine:database:create',
    ));
    $command->run($input, new NullOutput());

    //create schema
    $command = new CreateDatabaseDoctrineCommand();
    $this->application->add($command);
    $input = new ArrayInput(array(
      'command' => 'doctrine:schema:create',
    ));
    $command->run($input, new NullOutput());

    //get the Entity Manager
    $this->em = static::$kernel->getContainer()->get('doctrine')->getManager();

    //load fixtures
    $client = static::createClient();
    $loader = new \Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader($client->getContainer());
    $loader->loadFromDirectory(static::$kernel->locateResource('@MinishopShopBundle/DataFixtures/ORM'));
    $purger = new \Doctrine\Common\DataFixtures\Purger\ORMPurger($this->em);
    $executor = new \Doctrine\Common\DataFixtures\Executor\ORMExecutor($this->em, $purger);
    $executor->execute($loader->getFixtures());
  }

  public function testGetProduct()
  {
    $product = $this->em->createQuery('SELECT p FROM MinishopShopBundle:Product p')
        ->setMaxResults(1)
        ->getSingleResult();

    $this->assertEquals($product->getName(), Product::$product->getName());
  }

  protected function tearDown()
  {
    parent::tearDown();
    $this->em->close();
  }
}