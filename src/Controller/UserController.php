<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
	public function __construct(
		private readonly UserRepository $userRepository,
		private readonly UserService $userService
	)
	{
	}

	#[Route('/register', name: 'user_add')]
	public function addUser(Request $request, UserPasswordHasherInterface $passwordHasher): Response
	{
		$user = new User();
		$form = $this->createForm(UserType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$hashedPassword = $passwordHasher->hashPassword(
				$user,
				$user->getPassword()
			);
			$user->setPassword($hashedPassword);
			$user->setFile($this->userService->setFile($form->get('file')->getData()));
			$this->userRepository->save($user,true);

			return $this->redirectToRoute('app_login');
		}

		return $this->render('user/register.html.twig', [
			'form' => $form->createView(),
		]);
	}
}