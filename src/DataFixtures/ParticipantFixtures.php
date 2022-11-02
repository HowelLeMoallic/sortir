<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ParticipantFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new Participant();
        $admin->setPseudo('admin');
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin'));
        $admin->setNom('admin');
        $admin->setPrenom('administrateur');
        $admin->setTelephone('0123456789');
        $admin->setMail('admin@admin.fr');
        $admin->setCampus($this->getReference('rennes'));
        $manager->persist($admin);


        $howel = new Participant();
        $howel->setPseudo('howel');
        $howel->setPassword($this->hasher->hashPassword($howel, 'howel'));
        $howel->setNom('Le Moallic');
        $howel->setPrenom('howel');
        $howel->setTelephone('0101010101');
        $howel->setMail('howel.lemoallic2022@campus-eni.fr');
        $howel->setCampus($this->getReference('rennes'));
        $manager->persist($howel);

        $tanguy = new Participant();
        $tanguy->setPseudo('tanguy');
        $tanguy->setPassword($this->hasher->hashPassword($tanguy, 'tanguy'));
        $tanguy->setNom('Mathurin');
        $tanguy->setPrenom('tanguy');
        $tanguy->setTelephone('0202020202');
        $tanguy->setMail('tanguy.mathurin2022@campus-eni.fr');
        $tanguy->setCampus($this->getReference('rennes'));
        $manager->persist($tanguy);


        $manager->flush();
    }


    public function getDependencies()
    {
        return [CampusFixtures::class];
    }
}
