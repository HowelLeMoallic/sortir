<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantController extends AbstractController
{
    #[Route('/profilUser', name: 'profil_connecte')]
    public function index(): Response
    {
        return $this->render('participant/profilConnecter.html.twig', [
            'controller_name' => 'ParticipantController',
        ]);
    }
}
