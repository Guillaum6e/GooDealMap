<?php

namespace App\Form;

use App\Entity\Announcement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use App\Entity\Category;
use App\Entity\Region;

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
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
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
            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '2000000',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
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
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'choice_label' => 'regionName',
                'attr' => ['class' => 'form-control',],
                'label' => 'Région',
                'label_attr' => ['class' => 'form-label'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Announcement::class,
        ]);
    }
}
