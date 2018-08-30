<?php
// src/AppBundle/DataFixtures/AppFixtures.php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Bottle;
use AppBundle\Entity\Historical;
use AppBundle\Entity\Perfum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
// create 20 perfum! Bam!
        for ($i = 0; $i < 200; $i++) {
            $perfum = new Perfum();
            $perfum->setname('parfum '.$i);
            $perfum->setQuantity(rand(500,5000));

            $manager->persist($perfum);
        }

        $manager->flush();

        //bottle
        for ($i = 0; $i < 1; $i++) {
            $bottle = new Bottle();
            $bottle->setThirtyMl('25');
            $bottle->setFiftyMl('56');
            $bottle->setHundredMl('35');

            $manager->persist($bottle);
        }

        //historical
        for ($i = 0; $i < 200; $i++) {
            $historical = new Historical();
            $historical->setAction('historique test'.$i);
            $historical->setDate(new \DateTime('now'));

            $manager->persist($historical);
        }

        $manager->flush();
    }
}
