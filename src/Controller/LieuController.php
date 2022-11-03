<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\CreationLieuType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LieuController extends AbstractController
{
    #[Route('/lieu/creation', name: 'creation_lieu')]
    public function creationlieu(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lieu = new Lieu();
        $formLieu = $this->createForm(CreationLieuType::class, $lieu);

        $formLieu->handleRequest($request);

        if ($formLieu->isSubmitted() && $formLieu->isValid()){
            $entityManager->persist($lieu);
            $entityManager->flush();
            $this->addFlash('success', 'Votre lieu a bien été enrégistré');
            return $this->redirectToRoute('creation_sortie');
        }

        return $this->renderForm('lieu/index.html.twig', [
            'formLieu' => $formLieu
        ]);
    }
}
