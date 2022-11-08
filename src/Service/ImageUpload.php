<?php

namespace App\Service;

use App\Controller\SecurityController;
use App\Entity\Participant;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageUpload
{
    private $targetDirectory;
    private $slugger;
   // private $security;

    public function __construct($targetDirectory, SluggerInterface $slugger, private Security $security)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
        //$this->security = $security;
    }

    public function upload(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
        //Récupère le chemin complet de la photo
        $image = $this->getTargetDirectory().'/'.$this->security->getUser()->getPhoto();

        try {
            //Si une image déjà existante
            if ($this->security->getUser()->getPhoto()){
                $this->security->getUser()->setPhoto(''); //ici pour vider le nom de mon fichier dans mon entité
                unlink($image); //ici je supprime le fichier
            }
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}