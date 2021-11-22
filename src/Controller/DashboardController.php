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

        //get client list
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'id' => $this->getUser()->getId()
        ]);
        // dd($customers);

        foreach($user->getCustomers() as $customer)
        {
            // $projects->add($customer->getProjects());
            // array_push($projects, $customer->getProjects());
        }
        // dd($customer->getProjects());
        // dd($projects);
        // dd(sizeof($projects));
        // if(count($projects) > 0)
        {
            // foreach($projects as $project)
            {
                // maybe try to get the real object or an entity with wich you could get this data?
                // array_push($billings, $project->getBilling());
            }
            // dd($projects);
        }


        //link that data to the twig
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            // 'CApayed' => 
        ]);
    }
}
