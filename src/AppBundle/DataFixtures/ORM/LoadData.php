<?php
/**
 * Created by PhpStorm.
 * User: rimas
 * Date: 3/11/16
 * Time: 1:45 AM
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Offer;
use AppBundle\Entity\User;
use AppBundle\Entity\Activity;

/**
 * Class LoadData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setFirstName('Aurimas');
        $user1->setLastName('Jasilionis');
        $user1->setPhone('865778030');
        $user1->setEmail('a.jasilionis@saboniocentras.lt');
        $user1->setUsername('Aurimas');
        $user1->setPassword('password');
        $user1->setRating(10);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setFirstName('Darius');
        $user2->setLastName('Sirtautas');
        $user2->setPhone('868637833');
        $user2->setEmail('d.sirtautas@saboniocentras.lt');
        $user2->setUsername('Darius');
        $user2->setPassword('password');
        $user2->setRating(10);
        $manager->persist($user2);

        $user3 = new User();
        $user3->setFirstName('Laimis');
        $user3->setLastName('Bičkauskas');
        $user3->setPhone('865221255');
        $user3->setEmail('email@mail.com');
        $user3->setUsername('Laimis');
        $user3->setPassword('password');
        $user3->setRating(10);
        $manager->persist($user3);

        $user4 = new User();
        $user4->setFirstName('Kazimieras');
        $user4->setLastName('Bričkus');
        $user4->setPhone('861235851');
        $user4->setEmail('email2@mail.com');
        $user4->setUsername('Kazimieras');
        $user4->setPassword('password');
        $user4->setRating(10);
        $manager->persist($user4);

        $user5 = new User();
        $user5->setFirstName('Donatas');
        $user5->setLastName('Januševičius');
        $user5->setPhone('860000001');
        $user5->setEmail('email3@mail.com');
        $user5->setUsername('Donatas');
        $user5->setPassword('password');
        $user5->setRating(10);
        $manager->persist($user5);

        $user6 = new User();
        $user6->setFirstName('Justas');
        $user6->setLastName('Bugailiškis');
        $user6->setPhone('861376228');
        $user6->setEmail('j.bugailiskis@gmail.com');
        $user6->setUsername('Justas');
        $user6->setPassword('password');
        $user6->setRating(10);
        $manager->persist($user6);

        $user7 = new User();
        $user7->setFirstName('Justė');
        $user7->setLastName('Kubiliūtė');
        $user7->setPhone('860015689');
        $user7->setEmail('juste@tennisvilnius.lt');
        $user7->setUsername('Justė');
        $user7->setPassword('password');
        $user7->setRating(10);
        $manager->persist($user7);

        $user8 = new User();
        $user8->setFirstName('Eduardas');
        $user8->setLastName('Belevičius');
        $user8->setPhone('868711391');
        $user8->setEmail('email4@mail.com');
        $user8->setUsername('Eduardas');
        $user8->setPassword('password');
        $user8->setRating(10);
        $manager->persist($user8);

        $activity1 = new Activity();
        $activity1->setName('Basketball');
        $manager->persist($activity1);

        $activity2 = new Activity();
        $activity2->setName('Football');
        $manager->persist($activity2);

        $activity3 = new Activity();
        $activity3->setName('Athletics');
        $manager->persist($activity3);

        $activity4 = new Activity();
        $activity4->setName('Tennis');
        $manager->persist($activity4);

        $activity5 = new Activity();
        $activity5->setName('Swimming');
        $manager->persist($activity5);

        $offer1 = new Offer();
        $offer1->setMale(true);
        $offer1->setFemale(true);
        $offer1->setAgeFrom(8);
        $offer1->setAgeTo(16);
        $offer1->setAddress('Kaunas');
        $offer1->setName('Sabonio krepšinio centras');
        $offer1->setDescription('Strateginis krepšinio rinkos partneris, ugdantis aktyvius ir sveikus visuomenės narius, lyderiaujantis rengiant profesionalaus krepšinio pamainą.');
        $offer1->setLatitude('54.907187');
        $offer1->setLongitude('23.965188');
        $offer1->setImage('sabonio.png');
        $offer1->setActivity($activity1);
        $offer1->setUser($user1);
        $offer1->setPrice(10.0);
        $manager->persist($offer1);

        $offer2 = new Offer();
        $offer2->setMale(true);
        $offer2->setFemale(true);
        $offer2->setAgeFrom(8);
        $offer2->setAgeTo(13);
        $offer2->setAddress('Kaunas');
        $offer2->setName('„TORNADO“ Krepšinio mokykla');
        $offer2->setDescription('"Tornado" krepšinio mokykla kasmet sulaukia vis didesnio būrio berniukų ir vaikinų, norinčių žaisti krepšinį. Šiuo metu mokykloje sportuoja daugiau nei 550 vaikų.  "Tornado" KM dirba patyrę treneriai, ne vienerius metus ugdantys krepšininkus nuo pirmųjų žingsnių krepšinio aikštelėje.');
        $offer2->setLatitude('54.8963829');
        $offer2->setLongitude('23.8306256');
        $offer2->setImage('tornadas.jpg');
        $offer2->setActivity($activity1);
        $offer2->setUser($user2);
        $offer2->setPrice(10.0);
        $manager->persist($offer2);

        $offer3 = new Offer();
        $offer3->setMale(true);
        $offer3->setFemale(false);
        $offer3->setAgeFrom(10);
        $offer3->setAgeTo(13);
        $offer3->setAddress('Kaunas');
        $offer3->setName('Kauno futbolo mokykla „Tauras“');
        $offer3->setDescription('Kauno futbolo mokykla „Tauras“ yra vaikų, jaunimo ir suaugusiųjų papildomo ugdymo Kauno miesto savivaldybės biudžetinė įstaiga.');
        $offer3->setLatitude('54.911455');
        $offer3->setLongitude('23.900993');
        $offer3->setImage('tauras.jpg');
        $offer3->setActivity($activity2);
        $offer3->setUser($user3);
        $offer3->setPrice(10.0);
        $manager->persist($offer3);

        $offer4 = new Offer();
        $offer4->setMale(true);
        $offer4->setFemale(false);
        $offer4->setAgeFrom(13);
        $offer4->setAgeTo(15);
        $offer4->setAddress('Kaunas');
        $offer4->setName('Kauno vaikų ir jaunimo futbolo mokykla „Ąžuolas“');
        $offer4->setDescription('Siekiame būti geriausiais, stengiamės, jog treniruotės būtų kuo įdomesnės ir įvairesnės, o sąlygos būtų vienos iš geriausių. Mokykloje dirba kvalifikuoti treneriai. Dirbame daug ir atsakingai, nuolat tobuliname savo žinias.');
        $offer4->setLatitude('54.9240091');
        $offer4->setLongitude('23.86884');
        $offer4->setImage('futbolas.jpg');
        $offer4->setActivity($activity2);
        $offer4->setUser($user4);
        $offer4->setPrice(10.0);
        $manager->persist($offer4);

        $offer5 = new Offer();
        $offer5->setMale(true);
        $offer5->setFemale(true);
        $offer5->setAgeFrom(7);
        $offer5->setAgeTo(12);
        $offer5->setAddress('Kaunas');
        $offer5->setName('Kauno sporto mokykla „Viltis"');
        $offer5->setDescription('Kauno sporto mokykla „Viltis" – neformaliojo vaikų švietimo mokykla, veikianti pagal Kauno sporto mokyklos nuostatus.');
        $offer5->setLatitude('54.897066');
        $offer5->setLongitude('23.936196');
        $offer5->setImage('viltis.jpg');
        $offer5->setActivity($activity3);
        $offer5->setUser($user5);
        $offer5->setPrice(10.0);
        $manager->persist($offer5);

        $offer6 = new Offer();
        $offer6->setMale(true);
        $offer6->setFemale(true);
        $offer6->setAgeFrom(10);
        $offer6->setAgeTo(15);
        $offer6->setAddress('Vilnius');
        $offer6->setName('Vilniaus lengvosios atletikos mokykla');
        $offer6->setDescription('Vilniaus lengvosios atletikos mokykla kviečia vaikus ir paauglius išbandyti įvairias lengvosios atletikos rungtis (įvairių distancijų bėgimai, šuoliai į tolį, į aukštį, su kartimi, rutulio stūmimas, disko metimas).');
        $offer6->setLatitude('54.674208');
        $offer6->setLongitude('25.253787');
        $offer6->setImage('vilnius.jpg');
        $offer6->setActivity($activity3);
        $offer6->setUser($user6);
        $offer6->setPrice(10.0);
        $manager->persist($offer6);

        $offer7 = new Offer();
        $offer7->setMale(true);
        $offer7->setFemale(true);
        $offer7->setAgeFrom(8);
        $offer7->setAgeTo(13);
        $offer7->setAddress('Vilnius');
        $offer7->setName('Lauko teniso klubas - Tennis & More');
        $offer7->setDescription('Teniso klubą ,,Tennis & More” įkūrėme 2010 m. Klube veikia teniso mokykla vaikams, T&M akademija suaugusiems. Organizuojame tarpmiestinį komandinį turnyrą ,,T&M Taurė“ ir kitus teniso renginius.');
        $offer7->setLatitude('54.6785579');
        $offer7->setLongitude('25.2830118');
        $offer7->setImage('tennis.png');
        $offer7->setActivity($activity4);
        $offer7->setUser($user7);
        $offer7->setPrice(10.0);
        $manager->persist($offer7);

        $offer8 = new Offer();
        $offer8->setMale(true);
        $offer8->setFemale(true);
        $offer8->setAgeFrom(8);
        $offer8->setAgeTo(12);
        $offer8->setAddress('Kaunas');
        $offer8->setName('G.Sabeckio teniso mokykla');
        $offer8->setDescription('Mokyklos tikslai išugdyti aukšto lygio žaidėjus ne tik Lietuvos, bet ir tarptautinio lygio mąstu, išmokyti teniso paslapčių visus norinčius taisyklingai, techniškai ir gerai žaisti tenisą, pradedant nuo naujokų iki profesionalių žaidėjų.');
        $offer8->setLatitude('54.8986934');
        $offer8->setLongitude('23.9324214');
        $offer8->setImage('sabeckas.jpg');
        $offer8->setActivity($activity4);
        $offer8->setUser($user8);
        $offer8->setPrice(10.0);
        $manager->persist($offer8);

        $offer9 = new Offer();
        $offer9->setMale(true);
        $offer9->setFemale(true);
        $offer9->setAgeFrom(12);
        $offer9->setAgeTo(15);
        $offer9->setAddress('Kaunas');
        $offer9->setName('Kauno plaukimo mokykla');
        $offer9->setDescription('Neformaliojo vaikų švietimo ir formalųjį švietimą papildančio ugdymo mokykla, veikianti pagal Kauno plaukimo mokyklos  nuostatus.');
        $offer9->setLatitude('54.917862');
        $offer9->setLongitude('23.8994529');
        $offer9->setImage('swim.jpg');
        $offer9->setActivity($activity5);
        $offer9->setUser($user8);
        $offer9->setPrice(10.0);
        $manager->persist($offer9);

        $offer10 = new Offer();
        $offer10->setMale(true);
        $offer10->setFemale(true);
        $offer10->setAgeFrom(12);
        $offer10->setAgeTo(16);
        $offer10->setAddress('Kaunas');
        $offer10->setName('"Girstučio" baseinas');
        $offer10->setDescription('Šiandien "Girstučio" baseinas gali didžiuotis būdamas vienas iš didžiausių ir moderniausių sporto kompleksų Lietuvoje.');
        $offer10->setLatitude('54.907028');
        $offer10->setLongitude('23.972795');
        $offer10->setImage('girstutis.jpg');
        $offer10->setActivity($activity5);
        $offer10->setUser($user8);
        $offer10->setPrice(10.0);
        $manager->persist($offer10);

        $manager->flush();
    }
}
