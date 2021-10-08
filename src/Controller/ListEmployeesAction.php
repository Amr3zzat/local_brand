<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ContactsRepository;
use App\Repository\ContactsRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use App\Entity\Contact;

class ListEmployeesAction extends BaseController
{
    private ContactsRepository $contactsRepository;

    public function __construct(ContactsRepositoryInterface $contactsRepository)
    {
        $this->contactsRepository = $contactsRepository;
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Returns the employee contacts",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Contact::class))
     *     ),
     *      @OA\XmlContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Contact::class))
     *     )
     * )
     * @OA\Parameter(
     *     name="output_type",
     *     in="query",
     *     description="Output Types [xml, json]",
     *     @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *     name="offset",
     *     in="query",
     *     description="Start Index default 0",
     *     @OA\Schema(type="integer")
     * )
     * @OA\Parameter(
     *     name="length",
     *     in="query",
     *     description="results length default unlimted",
     *     @OA\Schema(type="integer")
     * )
     * @OA\Parameter(
     *     name="search",
     *     in="query",
     *     description="Search Key to filter results",
     *     @OA\Schema(type="string")
     * )
     */
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
