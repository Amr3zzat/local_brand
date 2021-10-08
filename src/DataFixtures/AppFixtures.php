<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $contact = new Contact();
            $contact
                ->setUserName('emp ' . $i)
                ->setNamePrefix('Mr.')
                ->setFirstName('first' . $i)
                ->setMiddleName('middle' . $i)
                ->setLastName('last' . $i)
                ->setGender('M')
                ->setEmail('emp' . $i . '@company.com')
                ->setBirthTime(new \DateTime())
                ->setBirthdate(new \DateTime())
                ->setAge(random_int(18, 60))
                ->setJoinedAt(new \DateTime())
                ->setAgeInCompany(random_int(1, 100))
                ->setPhone('+2132142124134')
                ->setPlaceName('Dev')
                ->setCountry('Egypt')
                ->setCity('Cairo')
                ->setZip('21321')
                ->setRegion('October');
                $manager->persist($contact);
        }

        $manager->flush();
    }
}
