<?php

namespace App\Controller\Admin;

use App\Entity\Saison;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class SaisonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Saison::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Saison')
            ->setEntityLabelInPlural('Saison')
            ->setSearchFields(['id', 'number', 'image', 'color']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('serie'));
    }

    public function configureFields(string $pageName): iterable
    {
        $number = IntegerField::new('number');
        $image = TextField::new('image');
        $color = ChoiceField::new('color')->setChoices(Saison::$_list_colors);
        $serie = AssociationField::new('serie');
        $episodes = AssociationField::new('episodes');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $number, $image, $color, $serie, $episodes];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $number, $image, $color, $serie, $episodes];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$number, $image, $color, $serie, $episodes];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$number, $image, $color, $serie, $episodes];
        }
    }
}
