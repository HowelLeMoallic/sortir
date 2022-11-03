<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Entity\Ville;
use App\Form\FiltresSortiesType;
use App\Form\Model\FiltresSortiesFormModel;


use App\Form\SortieType;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;



class SortieController extends AbstractController
{
    private $tokenStorage;


    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    #[Route('/sortie', name: 'accueil')]
    public function index(SortieRepository $sortieRepository, Request $request): Response
    {
        $user = $this->getUser();

        $filtresSorties = new FiltresSortiesFormModel();

        $form = $this->createForm(FiltresSortiesType::class, $filtresSorties);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $sorties = $sortieRepository->findSortiesByFiltres($filtresSorties, $user);

        }
        else{
            $sorties = $sortieRepository->findAll();

        }

        return $this->render('sortie/index.html.twig', [
            'sorties' => $sorties,
            'formSorties' => $form->createView(),
            'filtresSorties' => $filtresSorties,

        ]);
    }

    #[Route('/sortie/detail/{id}', name: 'detail_event', requirements: ['id' => '\d+'])]
    public function detailSortie(int $id, SortieRepository $sortieRepository){

        $event = $sortieRepository->find($id);
        $form = $this->createForm(SortieType::class, $event);

        return $this->renderForm('sortie/detail.html.twig', [
           'formDetail' => $form,
        ]);
    }

    #[Route('/inscription/{id}', name: 'inscription_participant', requirements: ['id' => '\d+'])]
    public function inscription(int $id, SortieRepository $sortieRepository, ParticipantRepository $participantRepository,
                                    EntityManagerInterface $entityManager)
    {

        $filtres = new FiltresSortiesFormModel();
        $form = $this->createForm(FiltresSortiesType::class, $filtres);

        //Requête pour récupérer toutes les sorties
        $sorties = $sortieRepository->findAll();
        //Requête pour récupérer qu'une sortie en fonction de son id
        $sortie = $sortieRepository->find($id);
        //Récupére l'utilisateur connecter avec sécurité
        $user = $this->tokenStorage->getToken()->getUser();
        if(!empty($user)){
            $userId = $user->getId();
        }
        //Ajout du participant dans la sortie
        $sortie->addParticipantsInscrit($participantRepository->find($userId));

        $entityManager->persist($sortie);
        $entityManager->flush();

        return $this->render('sortie/index.html.twig', [
            'sorties' => $sorties,
            'formSorties'=>$form->createView()
        ]);
    }

}
