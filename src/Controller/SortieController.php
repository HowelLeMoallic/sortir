<?php

namespace App\Controller;

use App\Form\FiltresSortiesType;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    #[Route('/sortie', name: 'accueil')]
    public function index(SortieRepository $sortieRepository): Response
    {
        $sorties = $sortieRepository->findAll();
        $form = $this->createForm(FiltresSortiesType::class);


        return $this->render('sortie/index.html.twig', [
            'sorties' => $sorties,
            'formSorties'=>$form->createView()
        ]);
    }
}
