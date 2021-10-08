<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ContactsRepository extends ServiceEntityRepository implements ContactsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function findAllPaginated(int $offset = 0, int $limit = null, string $searchKey = null)
    {
        $qb = $this->createQueryBuilder('p');

        $searchTerms = $this->getEntityManager()->getClassMetadata(Contact::class)->getColumnNames();
        foreach ($searchTerms as $term) {
            $qb
                ->orWhere('p.' . $term . ' LIKE :t_' . $term)
                ->setParameter('t_' . $term, '%' . $searchKey . '%');
        }
        $qb
            ->setFirstResult($offset);
        if ($limit !== null && $limit > 0) {
            $qb->setMaxResults($limit);
        }
        return $qb->getQuery()
            ->getResult();
    }
}
