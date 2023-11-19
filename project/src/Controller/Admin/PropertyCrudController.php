<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class PropertyCrudController extends AbstractCrudController
{
    public function __construct(private readonly RequestStack      $requestStack,
                                private readonly AdminUrlGenerator $adminUrlGenerator)
    {
    }

    public static function getEntityFqcn(): string
    {
        return Property::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Свойство')
            ->setPageTitle('new', 'Новое свойство')
            ->setPageTitle('edit', fn(Property $property) => sprintf('Редактировать свойство: " %s "', $property->getTitle()))
            ->setEntityLabelInPlural('Свойства');
    }

    public function configureActions(Actions $actions): Actions
    {
        $returnToGroup = Action::new('return to group', 'Группа')
            ->displayIf(fn(Property $property) => $property->getPropertyGroup())
            ->displayAsLink()
            ->linkToCrudAction('returnToGroup');

        $memberList = Action::new('member list', 'Список группы')
            ->displayIf(fn(Property $property) => $property->getPropertyGroup()->getProperties()->count() > 1)
            ->displayAsLink()
            ->linkToCrudAction('getMemberList');

        return parent::configureActions($actions)
            ->add(Crud::PAGE_INDEX, $returnToGroup)
            ->add(Crud::PAGE_INDEX, $memberList);
    }

    private function getEntity(AdminContext $context): Property
    {
        return $context->getEntity()->getInstance();
    }

    public function getMemberList(AdminContext $context): RedirectResponse
    {
        $currentProperty = $this->getEntity($context);
        $idCollection = $currentProperty->getPropertyGroup()->getProperties()->map(fn(Property $property) => $property->getId())->toArray();

        $url = $this->adminUrlGenerator->unsetAll()
            ->setController(PropertyCrudController::class)
            ->setAction(Crud::PAGE_INDEX)
            ->set('entity_id', implode(',', $idCollection))
            ->generateUrl();

        return $this->redirect($url);
    }

    public function returnToGroup(AdminContext $context): RedirectResponse
    {
        $property = $this->getEntity($context);
        $groupId = $property->getPropertyGroup()->getId();

        $url = $this->adminUrlGenerator->unsetAll()
            ->setController(PropertyGroupCrudController::class)
            ->setAction(Crud::PAGE_INDEX)
            ->setEntityId($groupId)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Название')
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
            ,
            FormField::addRow(),
            SlugField::new('slug', 'Идентификатор')
                ->setTargetFieldName('title')
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
            ,
            FormField::addRow(),
            AssociationField::new('propertyGroup', 'Группа')
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
                ->setFormTypeOptions([
                    'mapped' => true
                ])
            ,
            FormField::addRow(),
            IntegerField::new('position', 'Позиция в группе')
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
            ,
        ];
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        if ($this->requestStack->getCurrentRequest()->query->has('entity_id')) {
            $stringifyId = $this->requestStack->getCurrentRequest()->query->get('entity_id');

            return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters)
                ->where('entity.id IN (:val)')
                ->setParameter('val', explode(',', $stringifyId));
        }
        return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
    }
}
