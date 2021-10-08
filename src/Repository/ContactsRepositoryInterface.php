<?php

declare(strict_types=1);


namespace App\Repository;

interface ContactsRepositoryInterface
{
    public function findAllPaginated(int $offset = 0, int $limit = null, string $searchKey = null);

    public function find(int $id);

}
