<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Ton email *',
                'attr' => [
                    'class' => 'input-register',
                ],
                'label_attr' => [
                    'class' => 'label-register',
                ],
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Ton prénom *',
                'attr' => [
                    'class' => 'input-register',
                ],
                'label_attr' => [
                    'class' => 'label-register',
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Ton nom *',
                'attr' => [
                    'class' => 'input-register',
                ],
                'label_attr' => [
                    'class' => 'label-register',
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'Ton adresse *',
                'attr' => [
                    'class' => 'input-register',
                ],
                'label_attr' => [
                    'class' => 'label-register',
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'Ta ville *',
                'attr' => [
                    'class' => 'input-register',
                ],
                'label_attr' => [
                    'class' => 'label-register',
                ],
            ])
            ->add('zipcode', TextType::class, [
                'label' => 'Ton code postal *',
                'attr' => [
                    'class' => 'input-register',
                ],
                'label_attr' => [
                    'class' => 'label-register',
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'J\'accepte les conditions d\'utilisation *',
                'label_attr' => [
                    'class' => 'agree-terms',
                ],
                'attr' => [
                    'class' => 'agree-input',
                ],
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez accepter les conditions d\'utilisation',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Ton mot de passe',
                'attr' => [
                    'class' => 'input-register',
                    'autocomplete' => 'new-password'
                ],
                'label_attr' => [
                    'class' => 'label-register',
                ],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entre un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Ton mot de passe a besoin de {{ limit }} caractères minimum',
                        // max length allowed by Symfony for security reasons
                        'max' => 25,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
