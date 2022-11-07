<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\AnnulerSortieType;
use App\Form\CreationSortieType;
use App\Form\FiltresSortiesType;
use App\Form\InfoSortieType;
use App\Form\Model\FiltresSortiesFormModel;

use App\Repository\EtatRepository;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use App\Repository\VilleRepository;
use App\Service\EtatUpdate;
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
    public function index(SortieRepository $sortieRepository, Request $request, EtatUpdate $etatUpdate, EtatRepository $etatRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $filtresSorties = new FiltresSortiesFormModel();
        //Problème de requête en plus
        $filtresSorties->setCampus($user->getCampus());

        $form = $this->createForm(FiltresSortiesType::class, $filtresSorties);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $sorties = $sortieRepository->findSortiesByFiltres($filtresSorties, $user);
        }
        else{
            $sorties = $sortieRepository->findSortiesByFiltres($filtresSorties, $user);
        }




        $etatUpdate->CheckedDate($sorties);

        return $this->render('sortie/index.html.twig', [
            'sorties' => $sorties,
            'formSorties' => $form->createView(),
            'filtresSorties' => $filtresSorties,

        ]);
    }

    #[Route('/sortie/detail/{id}', name: 'detail_event', requirements: ['id' => '\d+'])]
    public function detailSortie(int $id, SortieRepository $sortieRepository){

        $event = $sortieRepository->find($id);

        $nbPlacesRestantes = $event->getNbInscriptionMax() - $event->getParticipantsInscrits()->count();



        $participants = $event->getParticipantsInscrits();

        return $this->render('sortie/detail.html.twig', [
            'event' => $event,
            'participants' => $participants,
            'nbPlacesRestantes' => $nbPlacesRestantes,

        ]);
    }

    #[Route('/inscription/{id}', name: 'inscription_participant', requirements: ['id' => '\d+'])]
    public function inscription(int $id, SortieRepository $sortieRepository, ParticipantRepository $participantRepository,
                                    EntityManagerInterface $entityManager)
    {


        //Requête pour récupérer qu'une sortie en fonction de son id
        $sortie = $sortieRepository->find($id);
        //Verif date limite d'inscription $$ nb Inscrit
        if($sortie->getDateLimiteInscription() > new \DateTime() && $sortie->getParticipantsInscrits()->count() < $sortie->getNbInscriptionMax()){

            //Récupére l'utilisateur connecter avec sécurité
            $user = $this->getUser();
            if(!empty($user)){
                $userId = $user->getId();
            }
            //Ajout du participant dans la sortie
            $sortie->addParticipantsInscrit($participantRepository->find($userId));

            $entityManager->persist($sortie);
            $entityManager->flush();
            $this->addFlash('success', 'Vous êtes bien inscrit à l\'activité '.$sortie->getNom());

        }
        else{

            $this->addFlash('error', 'Vous ne pouvez pas vous inscrire à cette activité car la date limite d\'inscription est dépassée');
        }

        return $this->redirectToRoute('accueil');
    }

    #[Route('/desinscription/{id}', name: 'desinscription_participant', requirements: ['id' => '\d+'])]
    public function desinscription(int $id, SortieRepository $sortieRepository, ParticipantRepository $participantRepository,
                                        EntityManagerInterface $entityManager)
    {

        $sortie = $sortieRepository->find($id);
        //Verif date limite inscription
        if($sortie->getDateLimiteInscription() > new \DateTime()){
            $user=$this->getUser();

            if (!empty($user)){
                $userID = $user->getId();
            }

            $participant = $participantRepository->find($userID);
            //Supprime le participant de la liste de participants à la sortie
            $sortie->removeParticipantsInscrit($participant);

            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('success', 'Vous êtes bien désinscrit à l\'activité '.$sortie->getNom());
        }
        else{
            $this->addFlash('error', 'Vous ne pouvez pas vous désinscrire à cette activité car la date limite d\'inscription est dépassée');
        }


        return $this->redirectToRoute('accueil');

    }

    #[Route('/sortie/creation', name: 'creation_sortie')]
    public function creation(Request $request, EntityManagerInterface $entityManager, VilleRepository $villeRepository, EtatRepository $etatRepository)
    {
        $sortie = new Sortie();
        //Récupéré l'utilisateur en cours
        $user = $this->getUser();

        //Requête pour récupérer les villes et les envoyés au twig
        $villes = $villeRepository->findAll();

        $form = $this->createForm(CreationSortieType::class, $sortie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if($sortie->getDateHeureDebut() >= $sortie->getDateLimiteInscription()){
                //En fonction du bouton clické
                if($form->get('Publier')->isClicked()){
                    //Modifie l'utilisateur
                    $sortie->setOrganisateur($user);
                    //Recherche l'état en fonction de son libelle
                    $etat = $etatRepository->findOneBy(['libelle' => 'Ouvert']);
                    $this->addFlash('success','Votre saisie a bien été publiée');

                    //Modifie l'état
                    $sortie->setEtat($etat);

                    $entityManager->persist($sortie);
                    $entityManager->flush();

                    return $this->redirectToRoute('accueil');
                }
                else if($form->get('Enregistrer')->isClicked()){
                    //Modifie l'utilisateur
                    $sortie->setOrganisateur($user);
                    //Recherche l'état en fonction de son libelle
                    $etat = $etatRepository->findOneBy(['libelle' => 'En création']);
                    $this->addFlash('success','Votre saisie a bien été enregistrée');
                    //Modifie l'état
                    $sortie->setEtat($etat);

                    $entityManager->persist($sortie);
                    $entityManager->flush();

                    return $this->redirectToRoute('accueil');
                }
            }else{
                $this->addFlash('error', 'La date de début de sortie doit être supérieure à la date de limite d\'inscription');
            }

        }

        return $this->render('sortie/creation.html.twig',[
            'formCreation' => $form->createView(),
            'villes' => $villes,
        ]);
    }

    #[Route('/sortie/modification/{id}', name: 'modification_sortie')]
    public function modifierSortie(SortieRepository $sortieRepository, int $id, Request $request, VilleRepository $villeRepository,
                                    EtatRepository $etatRepository, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        $sortie = $sortieRepository->find($id);
        $etat = $etatRepository->findOneBy(['libelle' => 'En création']);

        //Requête pour récupérer les villes et les envoyés au twig
        $villes = $villeRepository->findAll();

        $formSortie = $this->createForm(CreationSortieType::class, $sortie);
        $formSortie->handleRequest($request);

        if($user === $sortie->getOrganisateur() && $etat === $sortie->getEtat() ){

            if($formSortie->isSubmitted() && $formSortie->isValid()){

                //En fonction du bouton clické
                if($formSortie->get('Publier')->isClicked()){

                    //Recherche l'état en fonction de son libelle
                    $etat = $etatRepository->findOneBy(['libelle' => 'Ouvert']);

                    //Modifie l'état
                    $sortie->setEtat($etat);

                    $entityManager->persist($sortie);
                    $entityManager->flush();

                    $this->addFlash('success','Votre saisie a bien été publiée');
                    return $this->redirectToRoute('accueil');
                } else if($formSortie->get('Enregistrer')->isClicked()){

                    //Recherche l'état en fonction de son libelle
                    $etat = $etatRepository->findOneBy(['libelle' => 'En création']);

                    //Modifie l'état
                    $sortie->setEtat($etat);

                    $entityManager->persist($sortie);
                    $entityManager->flush();

                    $this->addFlash('success','Votre saisie a bien été enregistrée');
                    return $this->redirectToRoute('accueil');
                // if ($formSortie->get('Supprimer')->isClicked())
                } else{

                    $entityManager->remove($sortie);
                    $entityManager->flush();

                    $this->addFlash('success','Votre saisie a bien été supprimée');
                    return $this->redirectToRoute('accueil');
                }
            }

            return $this->render('sortie/modification.html.twig', [
                'formSortie' => $formSortie->createView(),
                'villes' => $villes
            ]);

        }else{
            $this->addFlash('success','Vous ne pouvez pas modifier la sortie');
            return $this->redirectToRoute('accueil');
        }
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
