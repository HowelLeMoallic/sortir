<?php

namespace App\Controller;

use App\Form\ParticipantType;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantController extends AbstractController
{
    #[Route('/profilUser', name: 'profil_connecte')]
    public function profil(Request $request,
                           EntityManagerInterface $em, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ParticipantType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $form->get('plainPassword')->getData()));

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Profil modifié avec succès.');
            return $this->redirectToRoute('accueil');
        }

        // Pour que la vue puisse afficher le formulaire, on doit lui envoyer le formulaire généré, avec $form->createView()
        return $this->render('participant/profil.html.twig', [
            'formProfil' => $form->createView()
        ]);


    }
}
