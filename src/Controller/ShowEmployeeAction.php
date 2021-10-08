<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ContactsRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use App\Entity\Contact;

class ShowEmployeeAction extends BaseController
{

    private ContactsRepositoryInterface $contactsRepository;

    public function __construct(ContactsRepositoryInterface $contactsRepository)
    {
        $this->contactsRepository = $contactsRepository;
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Returns the employee contacts",
     *     @OA\JsonContent(ref=@Model(type=Contact::class)),
     *     @OA\XmlContent(ref=@Model(type=Contact::class))
     * )
     * @OA\Parameter(
     *     name="output_type",
     *     in="query",
     *     description="Output Types [xml, json]",
     *     @OA\Schema(type="string")
     * )
     */
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
