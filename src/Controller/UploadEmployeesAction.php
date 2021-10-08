<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ContactsRepositoryInterface;
use App\Services\FileUploaderInterface;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UploadEmployeesAction extends AbstractController
{

    private FileUploaderInterface $fileUploader;

    private ContactsRepositoryInterface $contactsRepository;

    public function __construct(FileUploaderInterface $fileUploader, ContactsRepositoryInterface $contactsRepository)
    {
        $this->fileUploader = $fileUploader;
        $this->contactsRepository = $contactsRepository;
    }


    public function __invoke(Request $request)
    {
        $file = $request->files->get('data');
        $path = $this->fileUploader->upload($file);
        $reader = new Csv();
        $spreadsheet = $reader->load($path);
        $rows = $spreadsheet->getActiveSheet()->toArray();
        unset($rows[0]);
        $this->contactsRepository->bulkInsert($rows);
        return $this->json('');

    }
}
