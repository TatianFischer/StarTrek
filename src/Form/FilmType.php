<?php

namespace App\Form;

use App\Entity\Film;
use App\Entity\Serie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'row_attr' => ['class' => 'form-group']
            ))
            ->add('slug', TextType::class, array(
                'row_attr' => ['class' => 'form-group']
            ))
            ->add('synopsis', TextareaType::class, array(
                'row_attr' => ['class' => 'form-group textarea-row col-all'],
                'required' => false,
                'empty_data' => null
            ))
            ->add('serie', EntityType::class, array(
                'row_attr' => ['class' => 'form-group'],
                'class' => Serie::class,
                'choice_label' => 'name',
            ))
            ->add('edit', SubmitType::class, array(
                'attr' => ['class' => 'btn btn--inverse'],
                'row_attr' => ['class' => 'form-group']
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
        ]);
    }
}
