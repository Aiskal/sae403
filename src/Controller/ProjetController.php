<?php
namespace App\Controller;

use App\Entity\Projet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjetController extends AbstractController
{

     /**
 * @Route("/projet/{id}", name="delete_project")
 * @Method({"DELETE"})
 */
    
    public function delete(Request $request, EntityManagerInterface $entityManager, Projet $projet): Response
    {
        // Remove the project entity from the EntityManager
        $entityManager->remove($projet);
        $entityManager->flush();
        
        // Redirect to a confirmation page or back to the projects list
        return $this->redirectToRoute('profile');
    }
}

?>
