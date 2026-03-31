<?php

namespace Rami\Bundle\AcademyBundle\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\AccountBundle\Entity\Account;
use Oro\Bundle\ContactBundle\Entity\Contact;
use Oro\Bundle\EntityConfigBundle\Metadata\Attribute\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Attribute\ConfigField;
use Oro\Bundle\OrganizationBundle\Entity\BusinessUnit;
use Oro\Bundle\OrganizationBundle\Entity\Organization;
use Oro\Bundle\UserBundle\Entity\User;

#[ORM\Entity]
#[ORM\Table(name: 'rami_academy_ticket')]
#[ORM\HasLifecycleCallbacks]
#[Config(defaultValues: [
    'entity' => [
        'label' => 'rami.academy.ticket.entity_label',
        'plural_label' => 'rami.academy.ticket.entity_plural_label',
        'description' => 'rami.academy.ticket.entity_description',
        'icon' => 'fa-ticket',
    ],
    'ownership' => [
        'owner_type' => 'BUSINESS_UNIT',
        'owner_field_name' => 'owner',
        'owner_column_name' => 'owner_id',
        'organization_field_name' => 'organization',
        'organization_column_name' => 'organization_id',
    ],
    'security' => [
        'type' => 'ACL',
    ],
    'search' => [
        'searchable' => true,
    ],
])]
class Ticket
{
    public const STATUS_NEW = 'new';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_RESOLVED = 'resolved';
    public const STATUS_CLOSED = 'closed';

    public const PRIORITY_LOW = 'low';
    public const PRIORITY_MEDIUM = 'medium';
    public const PRIORITY_HIGH = 'high';
    public const PRIORITY_URGENT = 'urgent';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[ConfigField(defaultValues: [
        'entity' => [
            'label' => 'rami.academy.ticket.subject.label',
            'description' => 'rami.academy.ticket.subject.description',
        ],
        'search' => [
            'searchable' => true,
        ],
    ])]
    private ?string $subject = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[ConfigField(defaultValues: [
        'entity' => [
            'label' => 'rami.academy.ticket.description.label',
            'description' => 'rami.academy.ticket.description.description',
        ],
        'search' => [
            'searchable' => true,
        ],
    ])]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 32)]
    #[ConfigField(defaultValues: [
        'entity' => [
            'label' => 'rami.academy.ticket.status.label',
            'description' => 'rami.academy.ticket.status.description',
        ],
        'search' => [
            'searchable' => true,
        ],
    ])]
    private string $status = self::STATUS_NEW;

    #[ORM\Column(type: 'string', length: 32)]
    #[ConfigField(defaultValues: [
        'entity' => [
            'label' => 'rami.academy.ticket.priority.label',
            'description' => 'rami.academy.ticket.priority.description',
        ],
        'search' => [
            'searchable' => true,
        ],
    ])]
    private string $priority = self::PRIORITY_MEDIUM;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    #[ConfigField(defaultValues: [
        'entity' => [
            'label' => 'rami.academy.ticket.created_at.label',
            'description' => 'rami.academy.ticket.created_at.description',
        ],
    ])]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(targetEntity: BusinessUnit::class)]
    #[ORM\JoinColumn(name: 'owner_id', referencedColumnName: 'id', onDelete: 'SET NULL', nullable: true)]
    #[ConfigField(defaultValues: [
        'entity' => [
            'label' => 'rami.academy.ticket.owner.label',
            'description' => 'rami.academy.ticket.owner.description',
        ],
    ])]
    private ?BusinessUnit $owner = null;

    #[ORM\ManyToOne(targetEntity: Organization::class)]
    #[ORM\JoinColumn(name: 'organization_id', referencedColumnName: 'id', onDelete: 'SET NULL', nullable: true)]
    #[ConfigField(defaultValues: [
        'entity' => [
            'label' => 'rami.academy.ticket.organization.label',
            'description' => 'rami.academy.ticket.organization.description',
        ],
    ])]
    private ?Organization $organization = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'assigned_to_id', referencedColumnName: 'id', onDelete: 'SET NULL', nullable: true)]
    #[ConfigField(defaultValues: [
        'entity' => [
            'label' => 'rami.academy.ticket.assigned_to.label',
            'description' => 'rami.academy.ticket.assigned_to.description',
        ],
    ])]
    private ?User $assignedTo = null;

    #[ORM\ManyToOne(targetEntity: Contact::class)]
    #[ORM\JoinColumn(name: 'contact_id', referencedColumnName: 'id', onDelete: 'SET NULL', nullable: true)]
    #[ConfigField(defaultValues: [
        'entity' => [
            'label' => 'rami.academy.ticket.contact.label',
            'description' => 'rami.academy.ticket.contact.description',
        ],
    ])]
    private ?Contact $contact = null;

    #[ORM\ManyToOne(targetEntity: Account::class)]
    #[ORM\JoinColumn(name: 'account_id', referencedColumnName: 'id', onDelete: 'SET NULL', nullable: true)]
    #[ConfigField(defaultValues: [
        'entity' => [
            'label' => 'rami.academy.ticket.account.label',
            'description' => 'rami.academy.ticket.account.description',
        ],
    ])]
    private ?Account $account = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPriority(): string
    {
        return $this->priority;
    }

    public function setPriority(string $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getOwner(): ?BusinessUnit
    {
        return $this->owner;
    }

    public function setOwner(?BusinessUnit $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    public function setOrganization(?Organization $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    public function getAssignedTo(): ?User
    {
        return $this->assignedTo;
    }

    public function setAssignedTo(?User $assignedTo): self
    {
        $this->assignedTo = $assignedTo;

        return $this;
    }


    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        if (null === $this->createdAt) {
            $this->createdAt = new DateTimeImmutable();
        }
    }
}
