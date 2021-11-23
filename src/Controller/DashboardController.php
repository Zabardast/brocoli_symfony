<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Billing;
use App\Entity\Project;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;
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
        $cap = 0;
        $pea = 0;
        $edi = 0;

        //get client list
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'id' => $this->getUser()->getId()
        ]);
        

        foreach($user->getCustomers() as $customer)
        {
            // dd($customer);
            $billings = $this->getDoctrine()->getRepository(Billing::class)->findBillingByCustomerId($customer->getId(), true);
            // dd($billings);
            foreach($billings as $bill)
            {
                // dd($bill->getBilingStatus());
                if($bill->getBilingStatus() == 'payed')
                {
                    // dd($bill);
                    $cap += $bill->getPrice();
                }

                if($bill->getBilingStatus() == 'sent')
                {
                    $pea += $bill->getPrice();
                }

                if($bill->getBilingStatus() == 'edited')
                {
                    $edi += $bill->getPrice();
                }

            }
            
            //user info
            $user = $this->getUser();
            // dd($user);
        }
        
        //link that data to the twig
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'CApayed' => $cap,
            'ExpPayement' => $pea,
            'editer' => $edi,
            'turne_over' => $user->getTurneOver()
        ]);
    }
}
