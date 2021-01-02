<?php

namespace App\Controller\Admin;

use App\Entity\Film;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class FilmCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Film::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Film')
            ->setEntityLabelInPlural('Film')
            ->setSearchFields(['id', 'name', 'slug', 'synopsis']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('serie'));
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $slug = TextField::new('slug');
        $synopsis = TextareaField::new('synopsis');
        $serie = AssociationField::new('serie');
        $sortie = DateField::new('sortie');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $sortie, $serie];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $slug, $synopsis, $sortie, $serie];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $slug, $synopsis, $serie, $sortie];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $slug, $synopsis, $serie, $sortie];
        }
    }
}
