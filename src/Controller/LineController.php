<?php

namespace App\Controller;

use App\Entity\Line;
use App\Form\LineType;
use App\Entity\Billing;
use App\Repository\LineRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/line")
 */
class LineController extends AbstractController
{
    /**
     * @Route("/", name="line_index", methods={"GET"})
     */
    public function index(LineRepository $lineRepository): Response
    {
        return $this->render('line/index.html.twig', [
            'lines' => $lineRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id_billing}", name="line_new", methods={"GET","POST"})
     */
    public function new(Request $request, int $billing_id): Response
    {
        $line = new Line();
        $form = $this->createForm(LineType::class, $line);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $bill = $this->getDoctrine()->getRepository(Billing::class)->findOneBy([
                'id' => $billing_id
            ]);
            $entityManager->persist($bill);
            $entityManager->persist($line);
            $entityManager->flush();

            return $this->redirectToRoute('line_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('line/new.html.twig', [
            'line' => $line,
            'form' => $form
        ]);
    }

    /**
     * @Route("/{id}", name="line_show", methods={"GET"})
     */
    public function show(Line $line): Response
    {
        return $this->render('line/show.html.twig', [
            'line' => $line,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="line_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Line $line): Response
    {
        $form = $this->createForm(LineType::class, $line);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('line_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('line/edit.html.twig', [
            'line' => $line,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/{billing_id}", name="line_delete", methods={"GET"})
     */
    public function delete(Line $line, int $billing_id): Response
    {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($line);
            $entityManager->flush();

            $billing = $this->getDoctrine()->getRepository(Billing::class)->findOneBy([
                'id' => $billing_id
            ]);

            //remove line from billing
            $billing->removeLineList($line);

            //substract price from billing
            $billing->setPrice($billing->getPrice() - ($line->getPrice() * $line->getQuantity()));
            $this->getDoctrine()->getManager()->flush();


        return $this->redirectToRoute('billing_edit', ['id' => $billing_id  ], Response::HTTP_SEE_OTHER);
    }
}
