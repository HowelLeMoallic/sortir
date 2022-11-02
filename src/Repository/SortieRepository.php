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

    public function findSortiesByFiltres(FiltresSortiesFormModel $filtres): array
    {
        $qb = $this->createQueryBuilder('s');
        $qb->addSelect('s');

        if ($filtres->getCampus()) {
            $qb->andWhere('s.campus = :campus')
                ->setParameter('campus', $filtres->getCampus());
        }

        if ($filtres->getRecherche()) {
            $qb->andWhere('s.nom like %:nom%')
                ->setParameter('nom', $filtres->getRecherche());
        }

        if ($filtres->getDateDebut()) {
            $qb->andWhere('s.dateHeureDebut >= :debut')
                ->setParameter('debut', $filtres->getDateDebut());
        }

        if ($filtres->getDateFin()) {
            $qb->andWhere('s.dateHeureDebut <= :fin')
                ->setParameter('fin', $filtres->getDateFin());
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
