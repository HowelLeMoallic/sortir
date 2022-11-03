<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Form\FiltresSortiesType;
use App\Form\Model\FiltresSortiesFormModel;


use App\Form\SortieType;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use App\Repository\VilleRepository;
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
        $form = $this->createForm(InfoSortieType::class, $event);

        $participants = $event->getParticipantsInscrits();

        return $this->renderForm('sortie/detail.html.twig', [
           'formDetail' => $form,
            'participants' => $participants
        ]);
    }

    #[Route('/inscription/{id}', name: 'inscription_participant', requirements: ['id' => '\d+'])]
    public function inscription(int $id, SortieRepository $sortieRepository, ParticipantRepository $participantRepository,
                                    EntityManagerInterface $entityManager)
    {


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
        $this->addFlash('success', 'Vous êtes bien inscrit à l\'activité '.$sortie->getNom());
        return $this->redirectToRoute('accueil');
    }

    #[Route('/desinscription/{id}', name: 'desinscription_participant', requirements: ['id' => '\d+'])]
    public function desinscription(int $id, SortieRepository $sortieRepository, ParticipantRepository $participantRepository,
                                        EntityManagerInterface $entityManager)
    {

        $sortie = $sortieRepository->find($id);

        $user=$this->tokenStorage->getToken()->getUser();
        if (!empty($user)){
            $userID = $user->getId();
        }

        $participant = $participantRepository->find($userID);
        $sortie->removeParticipantsInscrit($participant);

        $entityManager->persist($sortie);
        $entityManager->flush();

        $this->addFlash('success', 'Vous êtes bien désinscrit à l\'activité '.$sortie->getNom());

        return $this->redirectToRoute('accueil');

    }

    #[Route('/sortie/creation', name: 'creation_sortie')]
    public function creation(Request $request, EntityManagerInterface $entityManager, VilleRepository $villeRepository, EtatRepository $etatRepository)
    {
        $sortie = new Sortie();
        //Récupéré l'utilisateur en cours
        $user = $this->tokenStorage->getToken()->getUser();
        //Modifie l'utilisateur
        $sortie->setOrganisateur($user);


        //Requête pour récupérer les villes et les envoyés au twig
        $villes = $villeRepository->findAll();

        $form = $this->createForm(CreationSortieType::class, $sortie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //En fonction du bouton clické
            if($form->get('Publier')->isClicked()){
                //Recherche l'état en fonction de son libelle
                $etat = $etatRepository->findOneBy(['libelle' => 'Ouvert']);
                $this->addFlash('success','Votre saisie a bien été publiée');
            }
            else{
                //Recherche l'état en fonction de son libelle
                $etat = $etatRepository->findOneBy(['libelle' => 'En création']);
                $this->addFlash('success','Votre saisie a bien été enregistrée');
            }
            //Modifie l'état
            $sortie->setEtat($etat);

            $entityManager->persist($sortie);
            $entityManager->flush();

        }

        return $this->render('sortie/creation.html.twig',[
            'formCreation' => $form->createView(),
            'villes' => $villes,
        ]);
    }

    #[Route('/sortie/annuler/{id}', name: 'annuler_sortie', requirements: ['id' => '\d+'])]
    public function AnnulerSortie(int $id, SortieRepository $sortieRepository, Request $request, EntityManagerInterface $entityManager, EtatRepository $etatRepository)
    {
        $sortie = $sortieRepository->find($id);

        $description = $sortie->getInfosSortie();

        $formMotif = $this->createForm(AnnulerSortieType::class, $sortie);

        $formMotif->handleRequest($request);




        if ($formMotif->isSubmitted() && $formMotif->isValid()) {
            $sortie->setInfosSortie($description . ' ANNULEE ' . $sortie->getInfosSortie());
            $etat = $etatRepository->findOneBy(['libelle' => 'Annulé']);
            $sortie->setEtat($etat);


            $entityManager->persist($sortie);
            $entityManager->flush();

            return $this->redirectToRoute('accueil');
        }





        return $this->render('sortie/annuler.html.twig', [
            'sortie' => $sortie,
            'formMotif' => $formMotif->createView(),

        ]);

    }

}
