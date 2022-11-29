<?php

namespace App\Form;

use App\Entity\Announcement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormGooDealType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                //'required' => true, // default is true
                'attr' => [
                    'placeholder' => 'Titre de vote GooDeal',
                    'class' => 'form-control',
                ],
                'label' => 'Titre',
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Ajoute une desription',
                    'class' => 'form-control',
                ],
                'label' => 'Description',
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'placeholder' => "Adresse de l'événement",
                    'class' => 'form-control',
                ],
                'label' => 'Adresse',
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'Evénements' => 0,
                    'Hébergements' => 1,
                    'Restaurations' => 2,
                ],
                'attr' => ['class' => 'form-control',],
                'label' => 'Categorie',
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add('dateStart', DateTimeType::class, [
                'attr' => ['class' => 'form-control',],
                'label' => 'Date de début',
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add('dateEnd', DateTimeType::class, [
                //'required' => true, // default is true
                'attr' => ['class' => 'form-control',],
                'label' => 'Date de début',
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add('image', FileType::class, [
                'constraints' => [
                    new File([
                        'maxSize' => '2000000',
                        'mimeTypes' => [
                            'application/jpg',
                            'application/jpeg',
                            'application/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ])
                ],
                'attr' => ['class' => 'form-control',],
                'label' => 'Image',
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'placeholder' => "Ville de l'événement",
                    'class' => 'form-control',
                ],
                'label' => 'Ville',
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add('zipcode', IntegerType::class, [
                'attr' => [
                    'placeholder' => 'Code postal de la ville',
                    'class' => 'form-control',
                ],
                'label' => 'Code postal',
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add('region', TextType::class)
            ->add('author', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Announcement::class,
        ]);
    }
}
