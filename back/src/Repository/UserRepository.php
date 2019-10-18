<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return User|null Returns an array of User objects
     */
    public function findByEmail($value): User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
        ;
    }

    /**
     * @return Query 
     */
    public function findAllCandidats(UserSearch $search) : Query {
        $query = $this->getQuery()
            ->andWhere('u.roles LIKE :role')
            ->setParameter('role', '%ROLE_USER%');
        if ( null !== $search->getCp() && (strlen($search->getCp()) > 0)) { 
            $query = $query
                        ->andWhere('u.cp LIKE :cp')
                        ->setParameter('cp', $search->getCp().'%');
        }
        if ( null !== $search->getNom() && (strlen($search->getNom()) > 0)) { 
            $query = $query
                        ->andWhere('u.nom LIKE :nom')
                        ->setParameter('nom', '%'.$search->getNom().'%');
        }
        return $query->getQuery();
    }

    private function getQuery(): QueryBuilder {
        return $this->createQueryBuilder('u');
    }

    /**
     * @return User[] <tableau des candidats>
     */
    public function findLatest() : array {
        return $this->getQuery()
            ->andWhere('u.roles LIKE :role')
            ->setParameter('role', '%ROLE_USER%')
            ->orderBy('u.date_creation', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }
}
