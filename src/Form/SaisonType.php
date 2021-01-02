<?php

namespace App\Form;

use App\Entity\Saison;
use App\Entity\Serie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SaisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', TextType::class, array(
                'row_attr' => ['class' => 'form-group']
            ))
            ->add('image', TextType::class, array(
                'row_attr' => ['class' => 'form-group'],
                'required' => false
            ))
            ->add('serie', EntityType::class, array(
                'row_attr' => ['class' => 'form-group'],
                'class' => Serie::class,
                'choice_label' => 'name',
            ))
            ->add('color', ChoiceType::class, array(
                'row_attr' => ['class' => 'form-group'],
                'choices' => Saison::$_list_colors,
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
            'data_class' => Saison::class,
        ]);
    }
}
