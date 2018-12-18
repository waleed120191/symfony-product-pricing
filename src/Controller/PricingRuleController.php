<?php

namespace App\Controller;

use App\Entity\PricingRule;
use App\Form\PricingRuleType;
use App\Repository\PricingRuleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pricing/rule")
 */
class PricingRuleController extends AbstractController
{
    /**
     * @Route("/", name="pricing_rule_index", methods={"GET"})
     */
    public function index(PricingRuleRepository $pricingRuleRepository): Response
    {
        return $this->render('pricing_rule/index.html.twig', ['pricing_rules' => $pricingRuleRepository->findAll()]);
    }

    /**
     * @Route("/new", name="pricing_rule_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $pricingRule = new PricingRule();
        $form = $this->createForm(PricingRuleType::class, $pricingRule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pricingRule);
            $entityManager->flush();

            return $this->redirectToRoute('pricing_rule_index');
        }

        return $this->render('pricing_rule/new.html.twig', [
            'pricing_rule' => $pricingRule,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pricing_rule_show", methods={"GET"})
     */
    public function show(PricingRule $pricingRule): Response
    {
        return $this->render('pricing_rule/show.html.twig', ['pricing_rule' => $pricingRule]);
    }

    /**
     * @Route("/{id}/edit", name="pricing_rule_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PricingRule $pricingRule): Response
    {
        $form = $this->createForm(PricingRuleType::class, $pricingRule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pricing_rule_index', ['id' => $pricingRule->getId()]);
        }

        return $this->render('pricing_rule/edit.html.twig', [
            'pricing_rule' => $pricingRule,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pricing_rule_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PricingRule $pricingRule): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pricingRule->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pricingRule);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pricing_rule_index');
    }
}
