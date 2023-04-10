<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Projet;
use App\Form\RegistrationFormType;
use App\Form\AjoutCommentaire;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class CommentController extends AbstractController{

    // public function addComment(ManagerRegistry $doctrine, Request $request, Projet $projet, $id, EntityManagerInterface $entityManager): Response
    // {
    //     // $projet = $doctrine->getManager()->getRepository(Projet::class)->find($id);
    
    //     $form = $this->createFormBuilder($projet)
    //         ->add('commentaire', TextType::class, ['label' => false])
    //         ->getForm();
        
    //     $form->handleRequest($request);
    
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         // dump($form->getData());
    //         $comment = $form->get('commentaire')->getData();
    //         $projet->setCommentaire($comment);
                
    //         $entityManager->persist($projet);
    //         $entityManager->flush();
    
    //         // die('form submitted');
    //         return $this->redirectToRoute('professeur');
    //     }
    
    //     return $this->redirectToRoute('professeur');
    // }

    public function addComment(ManagerRegistry $doctrine, Request $request, Projet $projet, EntityManagerInterface $entityManager, int $id): Response
{
    $projet = $doctrine->getManager()->getRepository(Projet::class)->find($id);

    if (!$projet) {
        throw $this->createNotFoundException('Le projet n\'existe pas.');
    }

    $projet->setCommentaire($request->request->get('commentaire'));

    $entityManager->persist($projet);
    $entityManager->flush();

    return $this->redirectToRoute('professeur');
}

    

    public function updateComment(ManagerRegistry $doctrine,Request $request, Projet $projet): Response
    {
        $form = $this->createFormBuilder($projet)
            ->add('commentaire', TextareaType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('projet_details', ['id' => $projet->getId()]);
        }

        $etudiants = $repository->createQueryBuilder('u')
        ->where('u.roles LIKE :roles')
        ->setParameter('roles', '%ROLE_ELEVE%')
        ->getQuery()
        ->getResult();

        $etudiantsData = array_map(function($etudiant) use ($projetrepo){
            return array(
                'nom' => $etudiant->getNom(),
                'prenom' => $etudiant->getPrenom(),
                'projets' => $projetrepo->findBy(array('id_user' => ($etudiant->getId())))
            );
        }, $etudiants);

        return $this->render('professeur.html.twig', [
            'form' => $form->createView(),
            "etudiants" => $etudiantsData
        ]);
    }
}

?>