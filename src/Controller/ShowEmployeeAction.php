<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ContactsRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShowEmployeeAction extends BaseController
{

    private ContactsRepositoryInterface $contactsRepository;

    public function __construct(ContactsRepositoryInterface $contactsRepository)
    {
        $this->contactsRepository = $contactsRepository;
    }


    public function __invoke(Request $request, int $id): Response
    {

        $contact = $this->contactsRepository->find($id);
        $outputType = $request->get('output_type', 'json');
        if ($outputType === 'xml') {
            return $this->xml(['data' => $contact]);
        }
        return $this->json(['data' => $contact]);
    }

}
