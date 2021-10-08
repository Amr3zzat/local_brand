<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ContactsRepository;
use App\Repository\ContactsRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ListEmployeesAction extends BaseController
{
    private ContactsRepository $contactsRepository;

    public function __construct(ContactsRepositoryInterface $contactsRepository)
    {
        $this->contactsRepository = $contactsRepository;
    }

    public function __invoke(Request $request): Response
    {

        $outputType = $request->get('output_type', 'json');
        $startIndex = (int)$request->get('offset', 0);
        $length = $request->get('length');
        $searchKey = $request->get('search');
        $contacts = $this->contactsRepository->findAllPaginated($startIndex, (int)$length, $searchKey);

        if ($outputType === 'xml') {
            return $this->xml(['data' => $contacts]);
        }
        return $this->json(['data' => $contacts]);
    }
}
