<?php

namespace App\Controller\Admin;

use App\Entity\Tecnologia;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TecnologiaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tecnologia::class;
    }

  public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nombre', 'Nombre de la Tecnología'),
            ColorField::new('colorHex', 'Color de Marca')
                ->setHelp('Selecciona el color que se verá al pasar el mouse.'),
        ];
    }
}
