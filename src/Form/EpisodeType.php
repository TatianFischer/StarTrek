<?php

namespace App\Form;

use App\Entity\Saison;
use App\Entity\Serie;
use App\Entity\Episode;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EpisodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $serie = $options['serie'];

        $builder
            ->add('saison', EntityType::class, array(
                'row_attr' => ['class' => 'form-group'],
                'class' => Saison::class,
                'query_builder' => function(EntityRepository $er) use ($serie){
                    return $er->createQueryBuilder('s')
                        ->where('s.serie = :serie')
                        ->setParameter('serie', $serie);
                },
                'choice_label' => 'number',
            ))
            ->add('number', IntegerType::class, array(
                'row_attr' => ['class' => 'form-group']
            ))
            ->add('diffusion', IntegerType::class, array(
                'row_attr' => ['class' => 'form-group']
            ))
            ->add('name', TextType::class, array(
                'row_attr' => ['class' => 'form-group col-3']
            ))
            ->add('titre', TextType::class, array(
                'row_attr' => ['class' => 'form-group col-3']
            ))
            ->add('image', TextType::class, array(
                'row_attr' => ['class' => 'form-group col-3'],
                'required' => false
            ))
            ->add('synopsis', TextareaType::class, array(
                'row_attr' => ['class' => 'form-group textarea-row col-all'],
                'required'   => false,
                'empty_data' => null,
            ))
            ->add('resume', TextareaType::class, array(
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
            'data_class' => Episode::class,
            'serie' => Serie::class
        ]);
    }
}
