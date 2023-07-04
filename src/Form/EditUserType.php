<?php

	namespace App\Form;

	use App\Entity\User;
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\Extension\Core\Type\EmailType;
	use Symfony\Component\Form\Extension\Core\Type\FileType;
	use Symfony\Component\Form\Extension\Core\Type\PasswordType;
	use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
	use Symfony\Component\Form\Extension\Core\Type\TelType;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Symfony\Component\Validator\Constraints\File;

	class EditUserType extends AbstractType
	{
		public function buildForm(FormBuilderInterface $builder, array $options): void
		{
			$builder
				->add('email',EmailType::class, [
					'label' => 'Email',
					'required' => 'required'
				])
				->add('firstName', TextType::class, [
					'label' => 'Imię',
					'required' => 'required',
				])
				->add('lastName', TextType::class, [
					'label' => 'Nazwisko',
					'required' => 'required',
				])
				->add('phone', TelType::class, [
					'label' => 'Telefon',
					'required' => 'required',
				])
				->add('address', TextType::class, [
					'label' => 'Adres',
					'required' => 'required',
				])
				->add('file', FileType::class, [
					'label' => 'CV',
					'mapped' => false,
					'constraints' => [
						new File([
							'mimeTypes' => ['application/pdf'],
							'mimeTypesMessage' => 'Proszę przesłać plik w formacie PDF.',
						]),
					],
				]) ;
		}

		public function configureOptions(OptionsResolver $resolver): void
		{
			$resolver->setDefaults([
				'data_class' => User::class,
			]);
		}
	}
