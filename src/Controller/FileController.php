<?php

namespace App\Controller;

use App\Entity\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

#[Route('/file')]
class FileController extends AbstractController
{
	#[Route(path: '/download/{id}', name: 'download_cv')]
	public function download(File $file): Response
	{
		$filePath = $this->getParameter('user_cv_directory') .'/'. $file->getClearName();
		if (!file_exists($filePath)) {
			throw $this->createNotFoundException('Plik nie istnieje.');
		}

		$response = new BinaryFileResponse($filePath);
		$response->headers->set('Content-Type', 'application/pdf');
		$response->headers->set('Content-Disposition', $response->headers->makeDisposition(
			ResponseHeaderBag::DISPOSITION_ATTACHMENT,
			$file->getOriginalName()
		));

		return $response;
	}
}