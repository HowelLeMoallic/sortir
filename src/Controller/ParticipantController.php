<?php

namespace App\Controller;

use App\Form\ParticipantType;
use App\Repository\ParticipantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantController extends AbstractController
{
    #[Route('/profilUser/{id}', name: 'profil_connecte')]
    public function profil(ParticipantRepository $participantRepository, int $id): Response
    {
        $user = $participantRepository->find($id);
        $form = $this->createForm(ParticipantType::class, $user);

        //$form->handleRequest($request);

        return $this->renderForm('participant/profil.html.twig', [
            'formProfil' => $form,
        ]);

    }
}
