<?php

namespace App\Repository;

use App\Entity\JobOffer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JobOffer>
 *
 * @method JobOffer|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobOffer|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobOffer[]    findAll()
 * @method JobOffer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobOfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobOffer::class);
    }

    public function save(JobOffer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(JobOffer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


	public function getDataByFilters($filters)
    {
        $qb =  $this->createQueryBuilder('j')
	        ->select('j.id as id, j.title as title, j.description as description, j.createdAt as createdAt');

		if($filters['days'] > 0 ) {
			$qb->andWhere($qb->expr()->gte('j.createdAt', ':days'))
				->setParameter('days', new \DateTime("-".$filters['days']." days"));
		}

		if ($filters['sortBy']  === 'desc') {
			$qb->addOrderBy('j.createdAt', 'DESC');
		}else{
			$qb->addOrderBy('j.createdAt', 'ASC');

		}

		return $qb->getQuery()->getResult();

    }

//    public function findOneBySomeField($value): ?JobOffer
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
