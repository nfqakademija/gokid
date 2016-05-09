<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\User;
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
    
    public function testIndexPage()
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertEquals(
            9,
            $crawler->filter('input')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Ieškoti")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("prisijunkite")')->count()
        );

        $this->logIn();

        $crawler = $this->client->request('GET', '/');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Atsijungti")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Jūsų paskyra")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Įkelti būrelį")')->count()
        );
    }

    public function testSearch()
    {
        $crawler = $this->client->request('GET', '/');
        $form = $crawler->filter('.searchbar-submit')->form([], 'POST');
        $crawler = $this->client->submit($form);

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Rasta būrelių")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Atstumas")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Kaina")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Sabonio krepšinio centras")')->count()
        );
    }

    public function testLoginFail()
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->filter('form')->form(
            [
                '_username' => 'admin',
                '_password' => 'fail'
            ],
            'POST'
        );

        $crawler = $this->client->submit($form);

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Klaidingi duomenys.")')->count()
        );
    }

    public function testLoginSuccess()
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->filter('form')->form(
            [
                '_username' => 'admin',
                '_password' => 'pass',
            ],
            'POST'
        );

        $crawler = $this->client->submit($form);

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Aktyvus vaikas")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Atsijungti")')->count()
        );
    }

    public function testAddOfferEmpty()
    {
        $this->logIn();
        $crawler = $this->client->request('GET', '/coaches');
        $form = $crawler->filter('form')->form([], 'POST');
        $crawler = $this->client->submit($form);

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Prašome įvesti būrelio pavadinimą")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Prašome įvesti būrelio aprašymą")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Prašome įvesti būrelio kontaktinę informaciją")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Prašome įvesti būrelio kainą")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Prašome pasirinkti bent vieną lytį")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Prašome įvesti didžiausią galimą vaiko amžių")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Prašome įvesti mažiausią galimą vaiko amžių")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Prašome įvesti būrelio vykimo vietą")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Prašome pasirinkti būrelio sporto šaką")')->count()
        );
    }

    public function testAddOfferAges()
    {
        $this->logIn();
        $crawler = $this->client->request('GET', '/coaches');
        $form = $crawler->filter('form')->form(
            [
                'offer[ageFrom]' => '10',
                'offer[ageTo]' => '2',
            ],
            'POST'
        );
        $crawler = $this->client->submit($form);

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Vaikų amžių rėžiai įvesti neteisingai")')->count()
        );
    }

    public function testProfileEdit()
    {
        $this->logIn();
        $crawler = $this->client->request('GET', '/profile');
        $form = $crawler->filter('form')->form(
            [
                'app_user_registration[name]' => 'Vardas Pavardė',
                'app_user_registration[phone]' => '+370111',
                'app_user_registration[current_password]' => 'pass',
                'app_user_registration[plainPassword][first]' => 'newpass',
                'app_user_registration[plainPassword][second]' => 'newpass',
            ],
            'POST'
        );
        $crawler = $this->client->submit($form);

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Profilis atnaujintas")')->count()
        );

        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        /** @var User $user */
        $user = $entityManager->getRepository('AppBundle:User')
            ->findOneBy(['username' => 'admin']);

        $this->assertEquals(
            'Vardas Pavardė',
            $user->getName()
        );

        $this->assertEquals(
            '+370111',
            $user->getPhone()
        );

        $link = $crawler->filter('a:contains("Atsijungti")')->eq(0)->link();
        $crawler = $this->client->click($link);

        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->filter('form')->form(
            [
                '_username' => 'admin',
                '_password' => 'newpass',
            ],
            'POST'
        );

        $crawler = $this->client->submit($form);

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Aktyvus vaikas")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Atsijungti")')->count()
        );
    }

    public function testoffersPage()
    {
        $this->logIn();
        $crawler = $this->client->request('GET', '/offers');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Sabonio krepšinio centras")')->count()
        );

        $form = $crawler->filter('form')->form([], 'POST');
        $crawler = $this->client->submit($form);
        $form = $crawler->filter('form')->form(
            [
                'answer' => 'y',
            ],
            'POST'
        );
        $crawler = $this->client->submit($form);
        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $offer = $entityManager->getRepository('AppBundle:Offer')
            ->findOneBy(['name' => 'Sabonio krepšinio centras']);

        $this->assertEquals(
            null,
            $offer
        );
    }

    public function testAddOfferSuccess()
    {
        $this->logIn();
        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $activity = $entityManager->getRepository('AppBundle:Activity')
            ->getAllActivities()[0];
        $crawler = $this->client->request('GET', '/coaches');
        $form = $crawler->filter('form')->form(
            [
                'offer[name]' => 'Pavadinimas',
                'offer[description]' => 'Papildoma informacija',
                'offer[contactInfo]' => 'Kontaktinė informacija',
                'offer[price]' => '10',
                'offer[male]' => '1',
                'offer[female]' => '1',
                'offer[ageFrom]' => '1',
                'offer[ageTo]' => '18',
                'offer[address]' => 'Adresas',
                'offer[activity]' => "{$activity->getId()}",
                'offer[latitude]' => '50',
                'offer[longitude]' => '49',
            ],
            'POST'
        );
        $crawler = $this->client->submit($form);

        $offer = $entityManager->getRepository('AppBundle:Offer')
            ->findOneBy(['name' => 'Pavadinimas']);

        $this->assertEquals('admin', $offer->getUser()->getUsername());
        $this->assertEquals('Pavadinimas', $offer->getName());
        $this->assertEquals('Papildoma informacija', $offer->getDescription());
        $this->assertEquals('Kontaktinė informacija', $offer->getContactInfo());
        $this->assertEquals(10, $offer->getPrice());
        $this->assertEquals(true, $offer->isMale());
        $this->assertEquals(true, $offer->isFemale());
        $this->assertEquals(1, $offer->getAgeFrom());
        $this->assertEquals(18, $offer->getAgeTo());
        $this->assertEquals('Adresas', $offer->getAddress());
        $this->assertEquals(50, $offer->getLatitude());
        $this->assertEquals(49, $offer->getLongitude());
        $this->assertEquals($activity->getName(), $offer->getActivity()->getName());

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Jūsų būrelis patalpintas į sistemą")')->count()
        );
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
