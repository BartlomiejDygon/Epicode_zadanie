<?php

namespace App\Controller;

use App\Entity\JobOffer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobApplicationController extends AbstractController
{
	#[Route('/', name: 'main_page')]
	public function index(): Response
	{
		return $this->render('jobApplication/jobApplication.html.twig');
	}
}
