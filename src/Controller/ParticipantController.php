<?php

namespace App\Controller;

use App\Form\ParticipantType;
use App\Repository\ParticipantRepository;
use App\Service\ImageUpload;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\isEmpty;

class ParticipantController extends AbstractController
{
    #[Route('/profilUser', name: 'profil_connecte')]
    public function profil(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $userPasswordHasher, ImageUpload $imageUpload): Response
    {
        //Récupération de l'utilisateur
        $user = $this->getUser();
        //Création du formulaire
        $form = $this->createForm(ParticipantType::class, $user);
        //récupère les infos saisies et modifie l'objet user
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            /** @var UploadedFile $brochureFile */
            $imageProfil = $form->get('image')->getData();
            if ($imageProfil) {
                $image = $imageUpload->upload($imageProfil);
                $user->setPhoto($image);
            }

            if (!isEmpty($user->getPassword()))
            {
                // encode the plain password
                $user->setPassword($userPasswordHasher->hashPassword($user, $form->get('plainPassword')->getData()));
            }

            //Ajout dans la bdd
            $em->persist($user);
            $em->flush();

            //Message de success
            $this->addFlash('success', 'Profil modifié avec succès.');
            return $this->redirectToRoute('accueil');
        }

        // Pour que la vue puisse afficher le formulaire, on doit lui envoyer le formulaire généré, avec $form->createView()
        return $this->render('participant/profil.html.twig', [
            'formProfil' => $form->createView(),
            'participant' => $user
        ]);

    }

    #[Route('/profilOrganisateur/{id}', name: 'profil_organisateur', requirements: ['id' => '\d+'])]
    public function profilOrganisateur(int $id, ParticipantRepository $participantRepository): Response
    {
        $user = $participantRepository->find($id);


        return $this->render('participant/profilOrganisateur.html.twig',[
            'organisateur' => $user,

        ]);

    }

}
