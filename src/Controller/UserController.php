<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\User;
use App\Form\EditUserType;
use App\Form\FileType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\FileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
	public function __construct(
		private readonly UserRepository $userRepository,
		private readonly FileService $fileService
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
			$user->setFile($this->fileService->setFile($form->get('file')->getData(), new File()));
			$this->userRepository->save($user,true);

			return $this->redirectToRoute('app_login');
		}

		return $this->render('user/register.html.twig', [
			'form' => $form->createView(),
		]);
	}

	#[Route('/edit', name: 'user_edit')]
	public function addFile(Request $request): Response
	{
		$user = $this->getUser();

		if (!$user) {
			throw $this->createAccessDeniedException('You are not allowed to access this section');
		}

		$form = $this->createForm(EditUserType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$file = $user->getFile();

			if ( $file ) {
				$this->fileService->removeFile($user->getFile());
			}
			$user->setFile($this->fileService->setFile($form->get('file')->getData(), $user->getFile()));

			$this->userRepository->save($user,true);

			return $this->redirectToRoute('main_page');
		}

		return $this->render('user/edit.html.twig', [
			'form' => $form->createView(),
		]);
	}
}