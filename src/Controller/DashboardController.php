<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(CustomerRepository $customerRepository): Response
    {
        //wee need to get the data to display
        // Chiffre d'affaire payé : €0.00
        // Paiements en attente : €0.00
        // A facturer : €0.00
        // Total : €0.00
        // Reste à faire : €560,000.00
        // Plafond : €560,000.00

        //get client list
        // $customerRepository->
        $products = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->user_customers();

        //link that data to the twig
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            
        ]);
    }
}
