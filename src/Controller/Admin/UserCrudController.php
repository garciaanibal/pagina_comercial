<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public function __construct(private array $roles, private array $rolesComplete)
    {
    }
    
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

     public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('user')
            ->setEntityLabelInPlural('users')
            ->setSearchFields(['email']);
    }
 
    public function configureFields(string $pageName): iterable
    {
        $email2 = TextField::new('email', 'email');
        $email = TextField::new('email', 'email')->setDisabled(true);
        $pass = TextField::new('password', 'password')->setFormType(PasswordType::class)->setRequired(false)->onlyOnForms()->setPermission('ROLE_SUPER_ADMIN');
        $roles = ChoiceField::new('roles', 'roles')->setChoices($this->roles)->allowMultipleChoices(true);
        $roles2 = ChoiceField::new('roles', 'roles')->onlyOnIndex()->renderAsBadges()->setChoices($this->rolesComplete);

        if (Crud::PAGE_INDEX === $pageName) {
            return [$roles2, $email];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$email, $roles];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$email, $roles, $pass];
        }

        return [$email2, $roles, $pass];
    }
    
}
