<?php

namespace Rami\Bundle\AcademyBundle\Form\Type;

use Oro\Bundle\UserBundle\Entity\User;
use Rami\Bundle\AcademyBundle\Entity\Ticket;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject', TextType::class, [
                'label' => 'rami.academy.ticket.subject.label',
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'rami.academy.ticket.description.label',
                'required' => false,
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'rami.academy.ticket.status.label',
                'choices' => [
                    'New' => Ticket::STATUS_NEW,
                    'In progress' => Ticket::STATUS_IN_PROGRESS,
                    'Resolved' => Ticket::STATUS_RESOLVED,
                    'Closed' => Ticket::STATUS_CLOSED,
                ],
                'constraints' => [
                    new Choice([
                        'choices' => [
                            Ticket::STATUS_NEW,
                            Ticket::STATUS_IN_PROGRESS,
                            Ticket::STATUS_RESOLVED,
                            Ticket::STATUS_CLOSED,
                        ],
                    ]),
                ],
            ])
            ->add('priority', ChoiceType::class, [
                'label' => 'rami.academy.ticket.priority.label',
                'choices' => [
                    'Low' => Ticket::PRIORITY_LOW,
                    'Medium' => Ticket::PRIORITY_MEDIUM,
                    'High' => Ticket::PRIORITY_HIGH,
                    'Urgent' => Ticket::PRIORITY_URGENT,
                ],
                'constraints' => [
                    new Choice([
                        'choices' => [
                            Ticket::PRIORITY_LOW,
                            Ticket::PRIORITY_MEDIUM,
                            Ticket::PRIORITY_HIGH,
                            Ticket::PRIORITY_URGENT,
                        ],
                    ]),
                ],
            ])
            ->add('assignedTo', EntityType::class, [
                'label' => 'rami.academy.ticket.assigned_to.label',
                'class' => User::class,
                'choice_label' => 'fullName',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
