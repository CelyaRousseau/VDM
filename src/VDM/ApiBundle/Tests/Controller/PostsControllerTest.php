<?php

namespace VDM\VdmBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostsControllerTest extends WebTestCase
{

    
    public function testgetPosts()
    {
      $client   = static::createClient();
      $crawler = $client->request('GET', '/api/posts');


      $response = $client->getResponse();
      $this->assertJsonResponse($response, 200);


      // Vérifie que la réponse est bien un json
      $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));

    }

    public function testgetPost()
    {
      $client   = static::createClient();
      $crawler = $client->request('GET', '/api/post/{id}');
    }

    protected function assertJsonResponse($response, $statusCode = 200)
    {
        $this->assertEquals(
            $statusCode, $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }
}
