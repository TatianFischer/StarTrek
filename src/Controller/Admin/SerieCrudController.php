<?php

namespace App\Controller\Admin;

use App\Entity\Serie;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SerieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Serie::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Serie')
            ->setEntityLabelInPlural('Serie')
            ->setDefaultSort(['isFilm' => 'ASC', 'debut' => 'ASC'])
            ->setSearchFields(['id', 'name', 'slug', 'synopsis', 'police', 'code']);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $slug = TextField::new('slug');
        $synopsis = TextareaField::new('synopsis');
        $police = TextField::new('police');
        $code = TextField::new('code');
        $isFilm = Field::new('isFilm');
        $debut = DateField::new('debut');
        $end = DateField::new('end');
        $id = IntegerField::new('id', 'ID');
        $saisons = AssociationField::new('saisons');
        $films = AssociationField::new('films');
        $personnages = AssociationField::new('personnages');
        $recurringPersonnages = AssociationField::new('recurringPersonnages');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $police, $code, $isFilm, $debut, $end];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $slug, $synopsis, $police, $code, $isFilm, $debut, $end, $saisons, $films, $personnages, $recurringPersonnages];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $slug, $synopsis, $police, $code, $isFilm, $debut, $end];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $slug, $synopsis, $police, $code, $isFilm, $debut, $end];
        }
    }
}
