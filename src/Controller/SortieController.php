<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\FiltresSortiesType;
use App\Form\Model\FiltresSortiesFormModel;
use App\Form\SortieType;
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

    #[Route('/sortie/detail/{id}', name: 'detail_event')]
    public function detailSortie(int $id, SortieRepository $sortieRepository){

        $event = $sortieRepository->find($id);
        $form = $this->createForm(SortieType::class, $event);

        return $this->renderForm('sortie/detail.html.twig', [
           'formDetail' => $form,
        ]);
    }

}
