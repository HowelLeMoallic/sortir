<?php

namespace App\Repository;

use App\Entity\Sortie;
use App\Form\Model\FiltresSortiesFormModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Sortie>
 *
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function save(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findSortiesByFiltres(FiltresSortiesFormModel $filtres, UserInterface $user): array
    {
        $qb = $this->createQueryBuilder('sortie');
        $qb->addSelect('sortie');


        if ($filtres->getCampus()) {
            $qb->leftJoin('sortie.campus', 'campus')
                ->addSelect('campus')
                ->andWhere('campus.nom = :campus')
                ->setParameter('campus', $filtres->getCampus()->getNom());
        }

        if ($filtres->getRecherche()) {
            $qb->andWhere('sortie.nom LIKE :nom')
                ->setParameter('nom', '%'.$filtres->getRecherche().'%');
        }

        if ($filtres->getDateDebut()) {
            $qb->andWhere('sortie.dateHeureDebut >= :debut')
                ->setParameter('debut', $filtres->getDateDebut());
        }

        if ($filtres->getDateFin()) {
            $qb->andWhere('sortie.dateLimiteInscription <= :fin')
                ->setParameter('fin', $filtres->getDateFin());
        }

        if ($filtres->getOrganisateur()) {
            $qb->andWhere('sortie.organisateur = :user')
                ->setParameter('user', $user);

        }

        if ($filtres->getInscrit()) {
            $qb->andWhere(':user MEMBER OF sortie.participantsInscrits')
                ->setParameter('user', $user);


        }

        if ($filtres->getNonInscrit()) {
            $qb->andWhere(':user NOT MEMBER sortie.participantsInscrits')
                ->setParameter('user', $user);
        }

        if ($filtres->getSortiesPassees()) {
            $qb->leftJoin('sortie.etat', 'etat')
                ->addSelect('etat')
                ->andWhere('etat.libelle = :terminer')
                ->setParameter('terminer', 'Terminé');

        }


        return $qb->getQuery()->getResult();
    }

    public function findSortiesByEtat(UserInterface $user)
    {

        $qb = $this->createQueryBuilder('sorties');

        //Création de la requête principal
        $qb->addSelect('sorties')
            ->leftJoin('sorties.etat', 'etat')
            ->addSelect('etat')
            ->orWhere('etat.libelle =:ouvert')
            ->setParameter('ouvert', 'Ouvert')
            ->orWhere('etat.libelle =:enCours')
            ->setParameter('enCours', 'En cours')
            ->orWhere('etat.libelle =:ferme')
            ->setParameter('ferme', 'Fermé')
            ->orWhere('etat.libelle =:termine')
            ->setParameter('termine', 'Terminé')
            ->orWhere('etat.libelle =:annule')
            ->setParameter('annule', 'Annulé')
            ->leftJoin('sorties.organisateur', 'organisateur')
            ->addSelect('organisateur');


            //Bidouillage pour ajouter (`organisateur_id` = $user.id AND `etat_id` = 'En création')
            $orModule = $qb->expr()->orx();
            $orModule->add($qb->expr()->eq('organisateur.pseudo', ':user'));
            $orModule->add($qb->expr()->eq('etat.libelle', ':enCreation'));

            $qb->orWhere($orModule)
                ->setParameter('user', $user)
                ->setParameter('enCreation', 'En création');

        return $qb->getQuery()->getResult();

    }
    
//    /**
//     * @return Sortie[] Returns an array of Sortie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sortie
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
