<?php

namespace Minishop\ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductApiControllerTest extends WebTestCase
{
    public function testGetproducts()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api');
    }

}
