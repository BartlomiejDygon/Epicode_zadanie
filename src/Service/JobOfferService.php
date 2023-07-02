<?php

	namespace App\Service;
	use App\Entity\File;
	use App\Repository\JobOfferRepository;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\File\Exception\FileException;
	use Symfony\Component\String\Slugger\SluggerInterface;

	class JobOfferService extends AbstractController
	{
		public function __construct(
			private readonly JobOfferRepository $jobOfferRepository
		) {
		}
		public function getData($filters) {
			$data = $this->jobOfferRepository->getDataByFilters($filters);
//			dd($data);
			return $data;
		}

	}