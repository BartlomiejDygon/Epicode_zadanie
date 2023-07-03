<?php

namespace App\Controller;

use App\Entity\JobOffer;
use App\Form\JobOfferType;
use App\Repository\JobOfferRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/job_offer')]
class JobOfferController extends AbstractController
{
	public function __construct(
		private readonly JobOfferRepository $jobOfferRepository,
	)
	{
	}

	#[Route('/show/{id}', name: 'job_offer_show')]
	public function show(JobOffer $jobOffer)
	{
		if ($this->isGranted('ROLE_ADMIN')) {

			return $this->render('jobOffer/admin_show.html.twig', [
				'jobOffer' => $jobOffer,
			]);
		}

		$user = $this->getUser();
		$hasApply = false;

		if( $user ){
			$applications = $user->getJobApplications();

			foreach ($applications as $application) {
				if ($application->getJobOffer() === $jobOffer) {
					$hasApply = true;
					break;
				}
			}
		}

		return $this->render('jobOffer/user_show.html.twig', [
			'jobOffer' => $jobOffer,
			'hasApply' =>$hasApply
		]);
	}

	#[Route('/list', name: 'job_offer_list')]
	public function list(Request $request): Response
	{
		if (!$this->isGranted('ROLE_ADMIN')) {
			throw $this->createAccessDeniedException('You are not allowed to access this section');
		}

		$qb = $this->jobOfferRepository->orderByNewApplication();
		$adapter = new QueryAdapter($qb);
		$pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
			$adapter,
			$request->query->get('page', 1),
			5
		);

		return $this->render('jobOffer/list.html.twig', [
			'pager' => $pagerfanta,
		]);
	}

	#[Route('/add', name: 'job_offer_add')]
	public function add(Request $request): Response
	{
		if (!$this->isGranted('ROLE_ADMIN')) {
			throw $this->createAccessDeniedException('You are not allowed to access this section');
		}
		$jobOffer = new JobOffer();
		$form = $this->createForm(JobOfferType::class, $jobOffer);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$this->jobOfferRepository->save($jobOffer,true);
			return $this->redirectToRoute('job_offer_list');
		}

		return $this->render('jobOffer/form.html.twig', [
			'form' => $form->createView(),
			'type' => 'add'

		]);
	}

	#[Route('/edit/{id}', name: 'job_offer_edit')]
	public function edit(JobOffer $jobOffer, Request $request): Response
	{
		if (!$this->isGranted('ROLE_ADMIN')) {
			throw $this->createAccessDeniedException('You are not allowed to access this section');
		}

		$form = $this->createForm(JobOfferType::class, $jobOffer);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$this->jobOfferRepository->save($jobOffer,true);
			return $this->redirectToRoute('job_offer_list');
		}

		return $this->render('jobOffer/form.html.twig', [
			'form' => $form->createView(),
			'type' => 'edit'
		]);
	}

	#[Route('/remove/{id}', name: 'job_offer_remove')]
	public function remove(JobOffer $jobOffer)
	{
		if (!$this->isGranted('ROLE_ADMIN')) {
			throw $this->createAccessDeniedException('You are not allowed to access this section');
		}

			$this->jobOfferRepository->remove($jobOffer,true);

			return $this->redirectToRoute('job_offer_list');
	}


}