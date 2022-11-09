<?php

namespace App\Repository;

use App\Entity\Sortie;
use App\Form\Model\FiltresSortiesFormModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
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
        $qb->addSelect('sortie')
            ->leftJoin('sortie.campus', 'campus')
            ->addSelect('campus')
            ->leftJoin('sortie.etat', 'etat')
            ->addSelect('etat')
            ->leftJoin('sortie.organisateur', 'organisateur')
            ->addSelect('organisateur')
            ->leftJoin('sortie.participantsInscrits', 'participantsInscrits')
            ->addSelect('participantsInscrits')
            ->orderBy('sortie.dateHeureDebut', 'ASC');
        if ($filtres->getCampus()) {
            $qb->andWhere('campus.nom = :campus')
                ->setParameter('campus', $filtres->getCampus()->getNom())
                ->andWhere('etat.libelle != :historise')
                ->setParameter('historise', 'Historisé');
        }
        if ($filtres->getRecherche()) {
            $qb->andWhere('sortie.nom LIKE :nom')
                ->setParameter('nom', '%'.$filtres->getRecherche().'%')
                ->andWhere('etat.libelle != :historise')
                ->setParameter('historise', 'Historisé');
        }if ($filtres->getDateDebut()) {
            $qb->andWhere('sortie.dateHeureDebut >= :debut')
                ->setParameter('debut', $filtres->getDateDebut())
                ->andWhere('etat.libelle != :historise')
                ->setParameter('historise', 'Historisé');
        }
        if ($filtres->getDateFin()) {
            $qb->andWhere('sortie.dateHeureDebut <= :fin')
                ->setParameter('fin', $filtres->getDateFin())
                ->andWhere('etat.libelle != :historise')
                ->setParameter('historise', 'Historisé');
        }
        if ($filtres->getOrganisateur()) {
            $qb->andWhere('sortie.organisateur = :user')
                ->setParameter('user', $user)
                ->andWhere('etat.libelle != :historise')
                ->setParameter('historise', 'Historisé');

        }elseif ($filtres->getInscrit()) {
            $qb->andWhere(':user MEMBER OF sortie.participantsInscrits')
                ->setParameter('user', $user)
                ->andWhere('etat.libelle != :historise')
                ->setParameter('historise', 'Historisé')
                ->andWhere('etat.libelle != :enCreation')
                ->setParameter('enCreation', 'En création');

        }elseif ($filtres->getNonInscrit()) {
            $qb->andWhere(':user NOT MEMBER sortie.participantsInscrits')
                ->setParameter('user', $user)
                ->andWhere('etat.libelle != :historise')
                ->setParameter('historise', 'Historisé')
                ->andWhere('etat.libelle != :enCreation')
                ->setParameter('enCreation', 'En création');

        }elseif ($filtres->getSortiesPassees()) {
            $qb->andWhere('etat.libelle = :terminer')
                ->setParameter('terminer', 'Terminé');
        }else{
            //Implémentation de la requête principal
            $qb->andWhere('etat.libelle != :historise')
                ->setParameter('historise', 'Historisé')
                ->andWhere('etat.libelle != :enCreation')
                ->setParameter('enCreation', 'En création');

            //Bidouillage pour ajouter (`organisateur_id` = $user.id AND `etat_id` = 'En création')
            $orModule = $qb->expr()->andX();
            $orModule->add($qb->expr()->eq('organisateur.pseudo', ':user'));
            $orModule->add($qb->expr()->eq('etat.libelle', ':enCreation'));

            $qb->orWhere($orModule)
                ->setParameter('user', $user->getPseudo())
                ->setParameter('enCreation', 'En création');
        }
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
