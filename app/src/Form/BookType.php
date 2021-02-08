<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Tag;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['new']) {
            $builder->add('name', TextType::class, [
                'label' => 'Nom'
            ]);
        }

        $builder
            ->add('publicationDate', CheckboxType::class, [
                'label' => 'Publier ce livre ?',
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('averagePrice', IntegerType::class, [
                'label' => 'Prix moyen',
                'required' => false
            ])
            ->add('tags', CollectionType::class, [
                'entry_type' => TagType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
            ])
            ->add('creator', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email'
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                'image_uri' => true
            ])
        ;

        $builder->get('publicationDate')
            ->addModelTransformer(new CallbackTransformer(
                // Datetime to boolean
                function ($publicationDateToBoolean) {
                    // transform the array to a string
                    return $publicationDateToBoolean ? true : false;
                },
                // Boolean to Datetime
                function ($publicationDateToDatetime) {
                    // transform the string back to an array
                    return $publicationDateToDatetime ? new \DateTime() : null;
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            'new' => false
        ]);
    }
}
