<?php

namespace App\Controller;

use App\Form\FiltresSortiesType;
use App\Form\Model\FiltresSortiesFormModel;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    #[Route('/sortie', name: 'accueil')]
    public function index(SortieRepository $sortieRepository, Request $request): Response
    {
        $filtres = new FiltresSortiesFormModel();
        $form = $this->createForm(FiltresSortiesType::class, $filtres);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $sorties = $sortieRepository->findSortiesByFiltres($filtres);

        }
        else{
            $sorties = $sortieRepository->findAll();

        }


        return $this->render('sortie/index.html.twig', [
            'sorties' => $sorties,
            'formSorties'=>$form->createView()
        ]);
    }
}
