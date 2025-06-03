<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for($i=0;$i<5;$i++)
        {
            $service = new Service();
            $service->setNom("Service : ".$i);
            $service->setDescription(str_repeat("Service : ".$i."\n", 10));
            $service->setImage("");
            $service->setPrix($i*50);

            $manager->persist($service);
        }

        for($i=0;$i<20;$i++)
        {
            $contact = new Contact();
            $contact->setNom("Nom : ".$i);
            $contact->setPrenom("Prénom : ".$i);
            $contact->setTelephone(str_repeat("00.", 5));
            $contact->setMail("test$i@test.com");
            $contact->setContenu(str_repeat("Spam : ".$i."\n", 10));

            $manager->persist($contact);
        }

        $manager->flush();
    }
}
