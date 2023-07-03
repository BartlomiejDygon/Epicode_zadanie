<?php

namespace App\Service;
use App\Repository\JobOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JobOfferService extends AbstractController
{
	public function __construct(
		private readonly JobOfferRepository $jobOfferRepository
	) {
	}
	public function getData($filters) {
		$data = $this->jobOfferRepository->getDataByFilters($filters);

		return $data;
	}
}