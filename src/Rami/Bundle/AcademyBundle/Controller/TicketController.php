<?php

namespace Rami\Bundle\AcademyBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Rami\Bundle\AcademyBundle\Entity\Ticket;
use Rami\Bundle\AcademyBundle\Form\Type\TicketType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/ticket', name: 'oro_rami_academy_ticket_')]
class TicketController extends AbstractController
{
    #[Route(path: '/', name: 'index')]
    #[Acl(id: 'oro_rami_academy_ticket_view', type: 'entity', class: Ticket::class, permission: 'VIEW')]
    public function indexAction(): Response
    {
        return $this->render('@RamiAcademy/Ticket/index.html.twig');
    }

    #[Route(path: '/view/{id}', name: 'view', requirements: ['id' => '\\d+'])]
    #[Acl(id: 'oro_rami_academy_ticket_view_item', type: 'entity', class: Ticket::class, permission: 'VIEW')]
    public function viewAction(Ticket $ticket): Response
    {
        return $this->render('@RamiAcademy/Ticket/view.html.twig', [
            'entity' => $ticket,
        ]);
    }

    #[Route(path: '/create', name: 'create')]
    #[Acl(id: 'oro_rami_academy_ticket_create', type: 'entity', class: Ticket::class, permission: 'CREATE')]
    public function createAction(Request $request, ManagerRegistry $registry): Response
    {
        return $this->handleForm($request, new Ticket(), $registry->getManagerForClass(Ticket::class));
    }

    #[Route(path: '/update/{id}', name: 'update', requirements: ['id' => '\\d+'])]
    #[Acl(id: 'oro_rami_academy_ticket_edit', type: 'entity', class: Ticket::class, permission: 'EDIT')]
    public function updateAction(Request $request, Ticket $ticket, ManagerRegistry $registry): Response
    {
        return $this->handleForm($request, $ticket, $registry->getManagerForClass(Ticket::class));
    }

    #[Route(path: '/delete/{id}', name: 'delete', methods: ['DELETE'])]
    #[Acl(id: 'oro_rami_academy_ticket_delete', type: 'entity', class: Ticket::class, permission: 'DELETE')]
    public function deleteAction(Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($ticket);
        $entityManager->flush();

        return new JsonResponse(['successful' => true]);
    }

    private function handleForm(Request $request, Ticket $ticket, ?EntityManagerInterface $entityManager): Response
    {
        if (!$entityManager instanceof EntityManagerInterface) {
            throw $this->createNotFoundException('Entity manager not found for Ticket entity.');
        }

        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ticket);
            $entityManager->flush();

            return $this->redirectToRoute('oro_rami_academy_ticket_view', ['id' => $ticket->getId()]);
        }

        return $this->render('@RamiAcademy/Ticket/update.html.twig', [
            'entity' => $ticket,
            'form' => $form->createView(),
        ]);
    }
}
