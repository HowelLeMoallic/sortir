<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use App\Service\ImageUpload;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;
use Faker\ORM\Doctrine\Populator;

class ParticipantFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UserPasswordHasherInterface $hasher, private ImageUpload $imageUpload)
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
        $admin->setCampus($this->getReference('campus2'));
        $admin->setPhoto('ludoGandalf.jpg');
        $this->addReference('user0', $admin);
        $manager->persist($admin);


        $howel = new Participant();
        $howel->setPseudo('Wewel');
        $howel->setPassword($this->hasher->hashPassword($howel, 'howel'));
        $howel->setNom('Le Moallic');
        $howel->setPrenom('Howel');
        $howel->setTelephone('0101010101');
        $howel->setMail('howel.lemoallic2022@campus-eni.fr');
        $howel->setCampus($this->getReference('campus2'));
        $howel->setPhoto('user.jpg');
        $this->addReference('user1', $howel);
        $manager->persist($howel);

        $tanguy = new Participant();
        $tanguy->setPseudo('AlsoTanguy');
        $tanguy->setPassword($this->hasher->hashPassword($tanguy, 'tanguy'));
        $tanguy->setNom('Mathurin');
        $tanguy->setPrenom('Tanguy');
        $tanguy->setTelephone('0202020202');
        $tanguy->setMail('tanguy.mathurin2022@campus-eni.fr');
        $tanguy->setCampus($this->getReference('campus2'));
        $this->addReference('user2', $tanguy);
        $manager->persist($tanguy);



        $faker = Factory::create('fr_FR');

        for ($i = 3; $i < 25; $i++) {
            $participant = new Participant();
            $participant->setPseudo($faker->userName());
            $participant->setPassword($this->hasher->hashPassword($participant, $faker->password()));
            $participant->setNom($faker->lastName());
            $participant->setPrenom($faker->firstName());
            $participant->setTelephone($faker->phoneNumber());
            $participant->setMail($faker->email());
            $participant->setCampus($this->getReference('campus'.rand(0,3)));
            $this->addReference('user'.$i, $participant);
            $manager->persist($participant);
        }


        $manager->flush();
    }


    public function getDependencies()
    {
        return [CampusFixtures::class];
    }
}
