<?php

namespace App\Entity;

use App\Repository\ProyectoRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Entity\File;
use Vich\UploaderBundle\Mapping\Attribute as Vich;

#[ORM\Entity(repositoryClass: ProyectoRepository::class)]
#[Vich\Uploadable]
class Proyecto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descripcionBreve = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $portadaNombre = null;

    // Campo virtual para VichUploader (no se guarda en BD)
    #[Vich\UploadableField(mapping: 'proyectos_portada', fileNameProperty: 'portadaNombre')]
    private ?File $portadaFile = null;

    #[ORM\OneToMany(mappedBy: 'proyecto', targetEntity: ProyectoImagen::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $imagenes;
    
    public function __construct()
    {
        $this->imagenes = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function setPortadaFile(?File $portadaFile = null): void
    {
        $this->portadaFile = $portadaFile;
        // Usamos DateTime porque TimestampableEntity usa DateTime (no DateTimeImmutable)
        if (null !== $portadaFile) {
            $this->updatedAt = new \DateTime();
        }
    }

    public function getPortadaFile(): ?File 
    { 
        return $this->portadaFile; 
    }

    public function getDescripcionBreve(): ?string
    {
        return $this->descripcionBreve;
    }

    public function setDescripcionBreve(string $descripcionBreve): static
    {
        $this->descripcionBreve = $descripcionBreve;

        return $this;
    }

    public function getPortadaNombre(): ?string
    {
        return $this->portadaNombre;
    }

    public function setPortadaNombre(?string $portadaNombre): static
    {
        $this->portadaNombre = $portadaNombre;

        return $this;
    }

     public function addImagen(ProyectoImagen $imagen): static
    {
        if (!$this->imagenes->contains($imagen)) {
            $this->imagenes->add($imagen);
            $imagen->setProyecto($this);
        }
        return $this;
    }
    public function removeImagen(ProyectoImagen $imagen): static
    {
        if ($this->imagenes->removeElement($imagen)) {
            if ($imagen->getProyecto() === $this) {
                $imagen->setProyecto(null);
            }
        }
        return $this;
    }
}
