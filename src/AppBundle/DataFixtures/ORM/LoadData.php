<?php
/**
 * Created by PhpStorm.
 * trainer: rimas
 * Date: 3/11/16
 * Time: 1:45 AM
 */

namespace AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Offer;
use AppBundle\Entity\Trainer;
use AppBundle\Entity\Activity;
//use Symfony\Component\HttpFoundation\Response;

class LoadData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $trainer1 = new Trainer();
        $trainer1->setFirstName('Aurimas');
        $trainer1->setLastName('Jasilionis');
        $trainer1->setPhone('865778030');
        $trainer1->setEmail('a.jasilionis@saboniocentras.lt');
        $trainer1->setPassword('password');
        $trainer1->setRating(10);

        $trainer2 = new Trainer();
        $trainer2->setFirstName('Darius');
        $trainer2->setLastName('Sirtautas');
        $trainer2->setPhone('868637833');
        $trainer2->setEmail('d.sirtautas@saboniocentras.lt');
        $trainer2->setPassword('password');
        $trainer2->setRating(10);

        $trainer3 = new Trainer();
        $trainer3->setFirstName('Laimis');
        $trainer3->setLastName('Bičkauskas');
        $trainer3->setPhone('865221255');
        $trainer3->setEmail('email@mail.com');
        $trainer3->setPassword('password');
        $trainer3->setRating(10);

        $trainer4 = new Trainer();
        $trainer4->setFirstName('Kazimieras');
        $trainer4->setLastName('Bričkus');
        $trainer4->setPhone('861235851');
        $trainer4->setEmail('email@mail.com');
        $trainer4->setPassword('password');
        $trainer4->setRating(10);

        $trainer5 = new Trainer();
        $trainer5->setFirstName('Donatas');
        $trainer5->setLastName('Januševičius');
        $trainer5->setPhone('860000001');
        $trainer5->setEmail('email@mail.com');
        $trainer5->setPassword('password');
        $trainer5->setRating(10);

        $trainer6 = new Trainer();
        $trainer6->setFirstName('Justas');
        $trainer6->setLastName('Bugailiškis');
        $trainer6->setPhone('861376228');
        $trainer6->setEmail('j.bugailiskis@gmail.com');
        $trainer6->setPassword('password');
        $trainer6->setRating(10);

        $trainer7 = new Trainer();
        $trainer7->setFirstName('Justė');
        $trainer7->setLastName('Kubiliūtė');
        $trainer7->setPhone('860015689');
        $trainer7->setEmail('juste@tennisvilnius.lt');
        $trainer7->setPassword('password');
        $trainer7->setRating(10);

        $trainer8 = new Trainer();
        $trainer8->setFirstName('Eduardas');
        $trainer8->setLastName('Belevičius');
        $trainer8->setPhone('868711391');
        $trainer8->setEmail('email@mail.com');
        $trainer8->setPassword('password');
        $trainer8->setRating(10);

        $activity1 = new Activity();
        $activity1->setName('Basketball');

        $activity2 = new Activity();
        $activity2->setName('Football');

        $activity3 = new Activity();
        $activity3->setName('Athletics');

        $activity4 = new Activity();
        $activity4->setName('Tennis');

        $activity5 = new Activity();
        $activity5->setName('Swimming');

        $offer1 = new Offer();
        $offer1->setChildrenAgeFrom(8);
        $offer1->setChildrenAgeTo(16);
        $offer1->setAddress('Kaunas');
        $offer1->setActivity($activity1);
        $offer1->setTrainer($trainer1);
        $offer1->setPrice(10.0);

        $offer2 = new Offer();
        $offer2->setChildrenAgeFrom(8);
        $offer2->setChildrenAgeTo(13);
        $offer2->setAddress('Kaunas');
        $offer2->setActivity($activity1);
        $offer2->setTrainer($trainer2);
        $offer2->setPrice(10.0);

        $offer3 = new Offer();
        $offer3->setChildrenAgeFrom(10);
        $offer3->setChildrenAgeTo(13);
        $offer3->setAddress('Kaunas');
        $offer3->setActivity($activity2);
        $offer3->setTrainer($trainer3);
        $offer3->setPrice(10.0);

        $offer4 = new Offer();
        $offer4->setChildrenAgeFrom(13);
        $offer4->setChildrenAgeTo(15);
        $offer4->setAddress('Kaunas');
        $offer4->setActivity($activity2);
        $offer4->setTrainer($trainer4);
        $offer4->setPrice(10.0);

        $offer5 = new Offer();
        $offer5->setChildrenAgeFrom(7);
        $offer5->setChildrenAgeTo(12);
        $offer5->setAddress('Kaunas');
        $offer5->setActivity($activity3);
        $offer5->setTrainer($trainer5);
        $offer5->setPrice(10.0);

        $offer6 = new Offer();
        $offer6->setChildrenAgeFrom(10);
        $offer6->setChildrenAgeTo(15);
        $offer6->setAddress('Vilnius');
        $offer6->setActivity($activity3);
        $offer6->setTrainer($trainer6);
        $offer6->setPrice(10.0);

        $offer7 = new Offer();
        $offer7->setChildrenAgeFrom(8);
        $offer7->setChildrenAgeTo(13);
        $offer7->setAddress('Vilnius');
        $offer7->setActivity($activity4);
        $offer7->setTrainer($trainer7);
        $offer7->setPrice(10.0);

        $offer8 = new Offer();
        $offer8->setChildrenAgeFrom(8);
        $offer8->setChildrenAgeTo(12);
        $offer8->setAddress('Kaunas');
        $offer8->setActivity($activity4);
        $offer8->setTrainer($trainer8);
        $offer8->setPrice(10.0);

        $offer9 = new Offer();
        $offer9->setChildrenAgeFrom(12);
        $offer9->setChildrenAgeTo(15);
        $offer9->setAddress('Kaunas');
        $offer9->setActivity($activity5);
        $offer9->setTrainer($trainer8);
        $offer9->setPrice(10.0);

        $offer10 = new Offer();
        $offer10->setChildrenAgeFrom(12);
        $offer10->setChildrenAgeTo(16);
        $offer10->setAddress('Kaunas');
        $offer10->setActivity($activity5);
        $offer10->setTrainer($trainer8);
        $offer10->setPrice(10.0);

        $manager->persist($trainer1);
        $manager->persist($trainer2);
        $manager->persist($trainer3);
        $manager->persist($trainer4);
        $manager->persist($trainer5);
        $manager->persist($trainer6);
        $manager->persist($trainer7);
        $manager->persist($trainer8);

        $manager->persist($activity1);
        $manager->persist($activity2);
        $manager->persist($activity3);
        $manager->persist($activity4);
        $manager->persist($activity5);

        $manager->persist($offer1);
        $manager->persist($offer2);
        $manager->persist($offer3);
        $manager->persist($offer4);
        $manager->persist($offer5);
        $manager->persist($offer6);
        $manager->persist($offer7);
        $manager->persist($offer8);
        $manager->persist($offer9);
        $manager->persist($offer10);
        $manager->flush();


    }
}
