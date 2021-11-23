<?php

namespace App\Controller;

use App\Entity\Line;
use App\Form\LineType;
use App\Entity\Billing;
use App\Form\BillingType;
use App\Repository\BillingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/billing")
 */
class BillingController extends AbstractController
{
    /**
     * @Route("/", name="billing_index", methods={"GET"})
     */
    public function index(BillingRepository $billingRepository): Response
    {
        return $this->render('billing/index.html.twig', [
            'billings' => $billingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="billing_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $billing = new Billing();
        $form = $this->createForm(BillingType::class, $billing);
        $form->handleRequest($request);

        $line = new Line();
        $lineForm = $this->createForm(LineType::class, $line);
        $lineForm->handleRequest($request);

        $lines = $billing->getLineList();
        
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $entityManager = $this->getDoctrine()->getManager();
            $billing->setCustomerName($billing->getProject()->getName());
            $billing->setCustomerId($billing->getProject()->getCustomer()->getId());
            $entityManager->persist($billing);
            $entityManager->flush();

            return $this->redirectToRoute('billing_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('billing/new.html.twig', [
            'billing' => $billing,
            'form' => $form,
            'lineform' => $lineForm,
            'lines' => $lines
        ]);
    }

    /**
     * @Route("/{id}", name="billing_show", methods={"GET"})
     */
    public function show(Billing $billing): Response
    {
        return $this->render('billing/show.html.twig', [
            'billing' => $billing,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="billing_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Billing $billing): Response
    {
        $form = $this->createForm(BillingType::class, $billing);
        $form->handleRequest($request);

        $line = new Line();
        $lineForm = $this->createForm(LineType::class, $line);
        $lineForm->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('billing_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($lineForm->isSubmitted() && $lineForm->isValid()) 
        {
            $entityManager = $this->getDoctrine()->getManager();
            $billing->addLineList($line);
            $billing->setPrice($billing->getPrice() + ($line->getPrice() * $line->getQuantity()));
            $entityManager->persist($billing);
            $entityManager->flush();
        }

        $lines = $billing->getLineList();

        return $this->renderForm('billing/edit.html.twig', [
            'billing' => $billing,
            'form' => $form,
            'lineform' => $lineForm,
            'lines' => $lines,
            'user' => $user
        ]);
    }

    /**
     * @Route("/{id}", name="billing_delete", methods={"POST"})
     */
    public function delete(Request $request, Billing $billing): Response
    {
        if ($this->isCsrfTokenValid('delete'.$billing->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($billing);
            $entityManager->flush();
        }

        return $this->redirectToRoute('billing_index', [], Response::HTTP_SEE_OTHER);
    }
}
