<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * @ORM\Table(name="resources")
 * @ORM\Entity(repositoryClass="App\Repository\ResourcesRepository")
 */
class Resources
{

    const UPLOADS = __DIR__.'/../../public/uploads';
    const WEB = '/uploads/';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="integer",options={"default":0})
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity="Resources")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $root;

    /**
     * @ORM\ManyToOne(targetEntity="Resources", inversedBy="children")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Resources", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_active;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_publish;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Template", inversedBy="fields")
     * @ORM\JoinColumn(nullable=true)
     */
    private $template;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;



    private $file;


    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    public function getFile()
    {
        return $this->file;
    }

    /**
     * Manages the copying of the file to the relevant place on the server
     */
    public function upload()
    {

        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // move takes the target directory and target filename as params
        $this->getFile()->move(
            self::UPLOADS,
            $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->filename = $this->getFile()->getClientOriginalName();
        $this->setImage($this->filename);
        // clean up the file property as you won't need it anymore
        $this->setFile(null);
    }

    public function __construct()
    {
        $this->level = 0;
        $this->children = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }
    public function getImagePath()
    {
        return self::WEB . $this->getImage();
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getRoot()
    {
        return $this->root;
    }

    public function setParent(Resources $parent = null)
    {
        $this->parent = $parent;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }

    public function getIsPublish(): ?bool
    {
        return $this->is_publish;
    }

    public function setIsPublish(bool $is_publish): self
    {
        $this->is_publish = $is_publish;

        return $this;
    }

    public function getTemplate(): ?Template
    {
        return $this->template;
    }

    public function setTemplate(Template $template_id): self
    {
        $this->template = $template_id;

        return $this;
    }

    public function __toString()
    {
        return $this->name ?? '';
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function setRoot(?self $root): self
    {
        $this->root = $root;

        return $this;
    }

    /**
     * @return Collection|Resources[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Resources $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(Resources $child): self
    {
        if ($this->children->contains($child)) {
            $this->children->removeElement($child);
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setParentId(Request $request)
    {
      /*  var_dump($request->get('parent_id'));
        die();*/
        $this->parent =  5;
    }
}
