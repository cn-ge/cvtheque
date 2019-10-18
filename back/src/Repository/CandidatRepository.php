<?php

namespace App\Repository;

use App\Entity\Candidat;
use App\Entity\CandidatSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Candidat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Candidat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Candidat[]    findAll()
 * @method Candidat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Candidat::class);
    }

    /**
     * @return Query 
     */
    public function findAllCandidats(CandidatSearch $search) : Query {
        $query = $this->getQuery();
        if ( null !== $search->getCp() && (strlen($search->getCp()) > 0)) { 
            $query = $query
                        ->andWhere('c.cp LIKE :cp')
                        ->setParameter('cp', $search->getCp().'%');
        }
        if ( null !== $search->getNom() && (strlen($search->getNom()) > 0)) { 
            $query = $query
                        ->andWhere('c.nom LIKE :nom')
                        ->setParameter('nom', '%'.$search->getNom().'%');
        }
        return $query->getQuery();
    }


    /**
     * @return Candidat[] <tableau des candidats>
     */
    public function findAllByNom($value) : array {
        return $this->getQuery()
            ->andWhere('c.nom = :nom')
            ->setParameter('nom', $value)
            ->orderBy('c.prenom', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Candidat <Candidat>
     */
    public function findByEmail($value) : array {
        return $this->getQuery()
            ->andWhere('c.email = :email')
            ->setParameter('email', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }
    /**
     * @return Candidat[] <tableau des candidats>
     */
    public function findLatest() : array {
        return $this->getQuery()
            ->orderBy('c.date_creation', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Candidat <candidat>
     */
    private function findById($id): Candidat {
        return $this->getQuery()
            ->andWhere('c.id =:id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return Candidat <candidat>
     */
    private function findByName($nom): Candidat {
        return $this->getQuery()
            ->andWhere('c.nom =:nom')
            ->setParameter('nom', $nom)
            ->getQuery()
            ->getOneOrNullResult();
    }

    private function getQuery(): QueryBuilder {
        return $this->createQueryBuilder('c');
    }

}
