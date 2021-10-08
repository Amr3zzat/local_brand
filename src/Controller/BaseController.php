<?php

declare(strict_types=1);

namespace App\Controller;

use App\Responses\XmlResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    protected function xml($data, int $status = 200, array $headers = [], array $context = []): XmlResponse
    {
        if ($this->container->has('serializer')) {
            $xml = $this->container->get('serializer')->serialize($data, 'xml', $context);

            return new XmlResponse($xml, $status, $headers);
        }

        return new XmlResponse($data, $status, $headers);
    }
}
