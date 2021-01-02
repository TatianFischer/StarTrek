<?php

namespace App\Form;

use App\Entity\Serie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SerieType extends AbstractType
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
            ->add('code', TextType::class, array(
                'row_attr' => ['class' => 'form-group']
            ))
            ->add('police', ChoiceType::class, array(
                'row_attr' => ['class' => 'form-group'],
                'choices' => Serie::$_list_polices,
                'required'   => false,
                'empty_data' => null,
            ))
            ->add('synopsis', TextareaType::class, array(
                'row_attr' => ['class' => 'form-group textarea-row col-all'],
                'required'   => false,
                'empty_data' => null,
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
            'data_class' => Serie::class,
        ]);
    }
}
