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

    public function bulkInsert(array $items)
    {
        $batchSize = 20;

        foreach ($items as $i => $item) {
            $contact = new Contact();
            $index = 1;
            $contact
                ->setNamePrefix($item[$index++])
                ->setFirstName($item[$index++])
                ->setMiddleName($item[$index++])
                ->setLastName($item[$index++])
                ->setGender($item[$index++])
                ->setEmail($item[$index++]);
            try {
                $birthTime = new \DateTime($item[$index++]);

            } catch (\Exception $e) {
                continue;
            }

            $contact
                ->setBirthTime($birthTime);
            try {
                $birthDate = new \DateTime($item[$index++]);

            } catch (\Exception $e) {
                continue;
            }
            $contact->setBirthdate($birthDate)
                ->setAge((float)$item[$index++]);
            try {
                $joinDate = new \DateTime($item[$index++]);

            } catch (\Exception $e) {
                continue;
            }
            $contact->setJoinedAt($joinDate)
                ->setAgeInCompany((float)$item[$index++])
                ->setPhone($item[$index++])
                ->setPlaceName($item[$index++])
                ->setCountry($item[$index++])
                ->setCity($item[$index++])
                ->setZip((string)$item[$index++])
                ->setRegion($item[$index])
                ->setUserName($item[$index++]);
            $this->getEntityManager()->persist($contact);


            // flush everything to the database every 20 inserts
            if (($i % $batchSize) === 0) {
                $this->getEntityManager()->flush();
                $this->getEntityManager()->clear();
            }
        }

        // flush the remaining objects
        $this->getEntityManager()->flush();
        $this->getEntityManager()->clear();
    }
}
