<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WorkersControllerTest extends WebTestCase
{
    public function testIndexPageIsUp()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/workers');

        $this->assertResponseIsSuccessful();
    }

    public function testSearchFormIsDisplayed()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/workers');

        $this->assertSelectorExists('form input[id=default-search]');
    }

    public function testTurboFrameInIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/workers');

        $this->assertSelectorExists('turbo-frame[id=teacher-details]');
    }

    public function testFormSubmit()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/workers');

        $form = $crawler->selectButton('Search')->form();
        $form['teacher_find_form[teacher]'] = 'John';

        $crawler = $client->submit($form);

        $this->assertResponseIsSuccessful();
    }
}
