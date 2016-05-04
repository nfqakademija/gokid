<?php

namespace AppBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class HomeControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        error_reporting(E_ALL & ~E_DEPRECATED);
        $this->client = static::createClient();
        $this->client->followRedirects();
        $this->loadFixtures(['AppBundle\DataFixtures\ORM\LoadData']);
    }

    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessfulLoggedIn($url)
    {
        $this->logIn();
        $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        return [
            ['/'],
            ['/search'],
            ['/login'],
            ['/register'],
            ['/offers'],
            ['/profile'],
            ['/activity'],
        ];
    }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        $userRepo = $this->client->getContainer()->get('doctrine')
            ->getManager()
            ->getRepository('AppBundle:User');

        $user = $userRepo->findOneByUsername('admin');

        $token = new UsernamePasswordToken($user, null, 'main', ['ROLE_ADMIN']);
        $session->set('_security_main', serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
