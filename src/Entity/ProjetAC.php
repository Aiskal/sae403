<?php

namespace App\Entity;

use App\Repository\ProjetACRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjetACRepository::class)]
class ProjetAC
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    // #[ORM\ManyToOne]
    // #[ORM\JoinColumn(name: 'label_id',nullable: false)]
    // public ?AC $label = null;

    // #[ORM\ManyToOne]
    // #[ORM\JoinColumn(name: 'projet_id',nullable: false)]
    // public ?Projet $projet = null;



    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'label_id', referencedColumnName: 'id',nullable: false)]
    public ?AC $label = null;

    #[ORM\ManyToOne(cascade:["persist"])]
    #[ORM\JoinColumn(name: 'projet_id', referencedColumnName: 'id', nullable: false)]
    public ?Projet $projet = null;

    // #[ORM\ManyToOne]
    // #[ORM\JoinColumn(name: 'label_id',nullable: false)]
    // public ?int $label = null;

    // #[ORM\ManyToOne]
    // #[ORM\JoinColumn(name: 'projet_id',nullable: false)]
    // public ?int $projet = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    public ?string $commentaire = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    public ?int $note = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?AC
    {
        return $this->label;
    }

    public function setLabel(?AC $label): self
    {
        $this->label = $label;

        return $this;
    }

    // public function getAC(): ?AC
    // {
    //     return $this->label;
    // }

    // public function setAC(?AC $ac): self
    // {
    //     $this->label = $ac;

    //     return $this;
    // }


    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): self
    {
        $this->projet = $projet;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }


    

}
