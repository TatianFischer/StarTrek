<?php

namespace App\Controller\Admin;

use App\Entity\Personnage;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PersonnageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Personnage::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Personnage')
            ->setEntityLabelInPlural('Personnages')
            ->setSearchFields(['id', 'name', 'actor', 'series.name', 'recurring.name'])
            ->setDefaultSort(['name' => 'ASC'])
            ->setPaginatorPageSize(30)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $actor = TextField::new('actor');
        $series = AssociationField::new('series')->formatValue(function ($value, Personnage $entity){
            if(null === $series = $entity->getSeries()){
                return null;
            }
            $str = $series[0];
            for ($i = 1; $i < $value; $i++) {
                $str = $str . ", " . $series[$i];
            }
            return $str;
        });
        $recurring = AssociationField::new('recurring')->formatValue(function ($value, Personnage $entity){
            if(null === $series = $entity->getRecurring()){
                return null;
            }
            $str = $series[0];
            for ($i = 1; $i < $value; $i++) {
                $str = $str . ", " . $series[$i];
            }
            return $str;
        });
        /*$series = ArrayField::new('series');
        $recurring = ArrayField::new('recurring');*/
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $actor, $series, $recurring];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $actor, $series, $recurring];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $actor, $series, $recurring];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $actor, $series, $recurring];
        }
    }

    public function configureFilters(Filters $filters): Filters
    {
        $filters = parent::configureFilters($filters);

        return $filters
            ->add('series')
        ;
    }
}
