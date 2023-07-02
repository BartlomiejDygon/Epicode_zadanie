<?php

	namespace App\Controller;

	use App\Service\JobOfferService;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing\Annotation\Route;

	#[Route('/api/job_offers')]
	class JobOfferApiController extends AbstractController
	{

		public function __construct(
			private readonly JobOfferService $jobOfferService
		) {
		}
		#[Route(path: '/get_data', name: 'job_offers_get_data', methods: 'POST')]
		public function getMostPopularSubpages(Request $request): Response
		{
			$filters = json_decode($request->getContent(), true);
			$result = $this->jobOfferService->getData($filters);

			return $this->json($result, Response::HTTP_OK);
		}
	}