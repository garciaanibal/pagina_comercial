<?php

namespace App\Entity;

use App\Repository\ProyectoImagenRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Attribute as Vich;
use Vich\UploaderBundle\Entity\File;

#[ORM\Entity(repositoryClass: ProyectoImagenRepository::class)]
#[Vich\Uploadable]
class ProyectoImagen
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagenNombre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descripcion = null;

    #[Vich\UploadableField(mapping: 'proyectos_galeria', fileNameProperty: 'imagenNombre')]
    private ?File $imagenFile = null;

    #[ORM\ManyToOne(inversedBy: 'imagenes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Proyecto $proyecto = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImagenNombre(): ?string
    {
        return $this->imagenNombre;
    }

    public function setImagenNombre(?string $imagenNombre): static
    {
        $this->imagenNombre = $imagenNombre;

        return $this;
    }

    public function setImagenFile(?File $imagenFile = null): void
    {
        $this->imagenFile = $imagenFile;
        if (null !== $imagenFile) {
            $this->updatedAt = new \DateTime();
        }
    }
    
    public function getImagenFile(): ?File 
    { 
        return $this->imagenFile; 
    }
    
    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of proyecto
     */ 
    public function getProyecto()
    {
        return $this->proyecto;
    }

    /**
     * Set the value of proyecto
     *
     * @return  self
     */ 
    public function setProyecto($proyecto)
    {
        $this->proyecto = $proyecto;

        return $this;
    }
    
}
    