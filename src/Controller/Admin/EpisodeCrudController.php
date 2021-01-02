<?php

namespace App\Controller\Admin;

use App\Entity\Episode;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class EpisodeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Episode::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Episode')
            ->setEntityLabelInPlural('Episodes')
            ->setSearchFields(['id', 'number', 'diffusion', 'name', 'titre', 'synopsis', 'resume', 'image'])
            ->setPaginatorPageSize(30)
            ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('saison')->setFormTypeOption('value_type_options', ['multiple' => true]));
    }

    public function configureFields(string $pageName): iterable
    {
        $number = IntegerField::new('number');
        $diffusion = IntegerField::new('diffusion');
        $saison = AssociationField::new('saison');
        $name = TextField::new('name');
        $titre = TextField::new('titre');
        $image = TextField::new('image');
        $synopsis = TextareaField::new('synopsis');
        $resume = TextareaField::new('resume');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $number, $diffusion, $name, $titre, $image, $saison];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $number, $diffusion, $name, $titre, $synopsis, $resume, $image, $saison];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$number, $diffusion, $saison, $name, $titre, $image, $synopsis, $resume];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$number, $diffusion, $saison, $name, $titre, $image, $synopsis, $resume];
        }
    }
}
