<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Commande::class);
    }


    public function getNbVisitors($visit)
    {
        $query = $this->createQueryBuilder('t')
            ->select('t.nb_tickets')
            ->where('t.date_visit = :date')
            ->setParameter('date', $visit)
            ->getQuery();
        $result = $query->getResult();

        $nbTotal = 0;

        foreach ($result as $nb) {
            $nbTotal += $nb['nb_tickets'];
        } var_dump ($nbTotal);
        return ($nbTotal);

    }



/*    public function findNumberTicketByDate($visit)
    {
        return $this->createQueryBuilder('n')
            ->select('n.nb_tickets')
            ->andWhere('n.date_visit = :visit')
            ->setParameter('visit' , $visit)
            ->getQuery()
            ->getResult();
    }


    public function findOneBySomeField($value): ?Commande
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
