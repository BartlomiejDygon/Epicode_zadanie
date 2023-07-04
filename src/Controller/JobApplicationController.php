<?php

namespace App\Controller;

use App\Entity\JobApplication;
use App\Entity\JobOffer;
use App\Repository\JobApplicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobApplicationController extends AbstractController
{

	public function __construct(
		private readonly JobApplicationRepository $jobApplicationRepository,
	)
	{
	}
	#[Route('/', name: 'main_page')]
	public function index(): Response
	{
		return $this->render('jobApplication/jobApplication.html.twig');
	}

	#[Route('/job_application/apply/{id}', name: 'job_application_new')]
	public function apply(JobOffer $jobOffer): Response
	{
		$user = $this->getUser();

		if (!$user) {
			throw $this->createAccessDeniedException('You are not allowed to access this section');
		}

//		dd($user->getFile());
		if (!$user->getFile()) {
			$this->addFlash('error', 'Dodaj CV');
			return $this->redirectToRoute('user_edit');
		}

		$jobApplication = new JobApplication($jobOffer, $user);

		$this->jobApplicationRepository->save($jobApplication, true);

		$this->addFlash('success', 'Aplikacja zostala złożona');

		return $this->redirectToRoute('job_offer_show',['id' => $jobOffer->getId()]);
	}

	#[Route('/job_application/show/{id}', name: 'job_application_show')]
	public function show(JobApplication $jobApplication): Response
	{
		if (!$this->isGranted('ROLE_ADMIN')) {
			throw $this->createAccessDeniedException('You are not allowed to access this section');
		}

		$jobApplication->setIsRead(true);
		$this->jobApplicationRepository->save($jobApplication,true);

		return $this->render('jobApplication/show.html.twig', [
			'jobApplication' => $jobApplication,
		]);	}
}
