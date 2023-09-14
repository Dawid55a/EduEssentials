<?php

namespace API;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TeacherApiEndpointsTest extends WebTestCase
{
    public function testGetTeachers()
    {
        $client = static::createClient();
        $client->request('GET', '/api/teachers');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'The response was not successful');
        $this->assertJson($client->getResponse()->getContent(), 'The response is not JSON');
    }

    public function testGetTeacher()
    {
        $client = static::createClient();
        $client->request('GET', '/api/teachers/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'The response was not successful');
        $this->assertJson($client->getResponse()->getContent(), 'The response is not JSON');
    }

    public function testGetTeacherNotFound()
    {
        $client = static::createClient();
        $client->request('GET', '/api/teachers/1000');

        $this->assertEquals(404, $client->getResponse()->getStatusCode(), 'The response was not successful');
        $this->assertJson($client->getResponse()->getContent(), 'The response is not JSON');
    }


}