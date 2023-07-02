<?php

namespace App\Controller;

use App\Entity\JobOffer;
use App\Form\JobOfferType;
use App\Repository\JobOfferRepository;
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

	#[Route('/list', name: 'job_offer_list')]
	public function list(Request $request): Response
	{
		if (!$this->isGranted('ROLE_ADMIN')) {
			throw $this->createAccessDeniedException('You are not allowed to access this section');
		}

		$jobOffers = $this->jobOfferRepository->findAll();

		return $this->render('jobOffer/list.html.twig', [
			'jobOffers' => $jobOffers,
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