<?php

class UserControllerTest extends TestCase {

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $crawler = $this->call('GET', '/login');

        $this->assertTrue($this->client->getResponse()->isOk());

        // $this->assertCount(1, $crawler->filter('h1:contains("Welcome")'));
    }

    public function testPostLoginFails()
    {
        $crawler = $this->call('GET', '/login');



        // $this->assertRedirectedTo('/index.php');
    }

}
