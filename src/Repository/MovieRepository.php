<?php

namespace App\Repository;

use App\Entity\Movie;
use App\Entity\MovieSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    /**
     * Méthode pour trouver tous les films qui sont visibles.
     */
    public function findAllVisible(MovieSearch $search): Query
    {
        $query = $this->findVisibleQuery();

        /*if ($search->getRechercherNom()) {
            $query = $query
                ->andWhere('m.titre = :rechercherNom')
                ->setParameter('rechercherNom', $search->getRechercherNom());
        }*/

        if ($search->getActors()->count() > 0) {
            $k = 0;
            foreach ($search->getActors() as $actor) {
                ++$k;
                $query = $query
                    ->andWhere(":actor$k MEMBER OF m.actors")
                    ->setParameter("actor$k", $actor);
            }
        }

        if ($search->getGenres()->count() > 0) {
            $i = 0;
            $orX = $query->expr()->orX();

            foreach ($search->getGenres() as $genres) {
                ++$i;
                $orX->add("m.genre = :genres$i");
                $query = $query->setParameter("genres$i", $genres);
            }

            $query->andWhere($orX);
        }

        return $query->getQuery();
    }

    /**
     * Méthode pour trouver les derniers films.
     *
     * @return Movie[]
     */
    public function findLast(): array
    {
        return $this->findVisibleQuery()
            ->setMaxResults(2)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Méthode pour éviter de se répété.
     */
    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('m')
            ->where('m.afficher = false');
    }

    // /**
    //  * @return Movie[] Returns an array of Movie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Movie
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
