<?php

namespace App\Service;
use App\Entity\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserService extends AbstractController
{
	public function __construct(
		private readonly SluggerInterface $slugger
	) {
	}
	public function setFile($file) {
		$fileToSave = new File();
		$fileToSave->setSize($file->getSize());
		$fileToSave->setOriginalName($file->getClientOriginalName());
		$originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
		$safeFilename = $this->slugger->slug($originalFilename);
		$newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
		try {
			$file->move(
				$this->getParameter('user_cv_directory'),
				$newFilename
			);
			$fileToSave->setClearName($newFilename);
		} catch (FileException $e) {
				// ... handle exception if something happens during file upload
		}

		return $fileToSave;
	}

}