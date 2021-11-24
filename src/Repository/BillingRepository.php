<?php

namespace App\Repository;

use App\Entity\Billing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Billing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Billing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Billing[]    findAll()
 * @method Billing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BillingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Billing::class);
    }


    public function findBillingByCustomerId(int $c_id, bool $only_payed = false)
    {
        $qd = $this->createQueryBuilder('b')
            ->where('b.customer_id = :customer_id' )
            ->setParameter('customer_id', $c_id);

        if($only_payed)
        {
            dd("only_payed is on");
            $qd->andWhere('b.biling_status = :payed');
            $qd->setParameter('payed', "payed");
        }

        $query = $qd->getQuery();

        return $query->execute();
    }

    public function findLastBillingId()
    {
        // $qd = $this->getDoctrine()->getManager()->createQuery(
        //     'SELECT b FROM Billing:class'
        // );

        dd($qd->getResult());
        $query = $qd->getQuery();
        return $query->execute();
    }

    // /**
    //  * @return Billing[] Returns an array of Billing objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Billing
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
