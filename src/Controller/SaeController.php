<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\AC;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Projet;
use App\Entity\ProjetAC;
use App\Form\RegistrationFormType;
use App\Form\AjoutProjetForm;
use App\Form\AjoutProjetACForm;
use App\Form\AjoutCommentaire;
use App\Form\ACFormType;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;


// php bin/console make:migration
// php bin/console doctrine:migrations:migrate

class SaeController extends AbstractController{
    
    
    public function index(EntityManagerInterface $entityManager): Response
    {
        $acs = $entityManager->getRepository(AC::class)->createQueryBuilder('ac')
            // ->orderBy('ac.competence', 'ASC')
            ->orderBy('CASE ac.competence 
                        WHEN \'Comprendre\' THEN 1 
                        WHEN \'Concevoir\' THEN 2 
                        WHEN \'Exprimer\' THEN 3 
                        WHEN \'Developper\' THEN 4 
                        WHEN \'Entreprendre\' THEN 5 
                        ELSE 6 
                    END')
            ->getQuery()
            ->getResult();
        
        return $this->render('index.html.twig', [
            'acs' => $acs,
        ]);
    }

    public function home(): Response {
        return $this->render("homepage.html.twig", []);
    }

    public function error(): Response {
        return $this->render("error.html.twig", []);
    }

    public function professeur(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response {
        $repository = $doctrine->getManager()->getRepository(User::class);
        
        $projetrepo = $doctrine->getManager()->getRepository(Projet::class);
        
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

        // $projet = new Projet();
        // $form = $this->createFormBuilder($projet)
        //     ->add('commentaire', TextType::class, ['label' => false])
        //     ->getForm();
    
        // $form->handleRequest($request);
    
        // if ($form->isSubmitted() && $form->isValid()) {
        //     $comment = $form->get('commentaire')->getData();
        //     $projet->setCommentaire($comment);
    
        //     $entityManager->persist($projet);
        //     $entityManager->flush();
    
        //     // Redirect to the same page to avoid resubmission of the form when refreshing the page
        //     return $this->redirectToRoute('professeur');
        // }


    
        // $projet = $doctrine->getManager()->getRepository(Projet::class);

        // $form = $this->createForm(AjoutCommentaire::class, $projet);
        // $form->handleRequest($request);

        // return $this->render("professeur.html.twig", ['formComment' => $form->createView(),"etudiants" => $etudiantsData]);

        $forms = array();
        foreach ($etudiantsData as $etudiant) {
            foreach ($etudiant['projets'] as $projet) {
                $form = $this->createForm(AjoutCommentaire::class, $projet, array(
                    'action' => $this->generateUrl('add_comment', array('id' => $projet->getId())),
                    'method' => 'POST',
                ));
                $forms[] = array(
                    'projet' => $projet,
                    'form' => $form->createView(),
                );
            }
        }
    
        return $this->render("professeur.html.twig", array(
            'forms' => $forms,
            "etudiants" => $etudiantsData
        ));
    
        
    }

    public function admin(Request $request,ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response {
        $userRepository = $doctrine->getManager()->getRepository(User::class);
        $projetrepo = $doctrine->getManager()->getRepository(Projet::class);

        $eleves = $userRepository->createQueryBuilder('u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%ROLE_ELEVE%')
            ->getQuery()
            ->getResult();

            $elevesData = array_map(function($eleve) use ($projetrepo){
                return array(
                    'nom' => $eleve->getNom(),
                    'prenom' => $eleve->getPrenom(),
                    'projets' => $projetrepo->createQueryBuilder('p')
                    ->select('COUNT(p.id)')
                    ->where('p.id_user = :user')
                    ->setParameter('user', $eleve->getId())
                    ->getQuery()
                    ->getSingleScalarResult(),
                    'photo' => $eleve->getPhoto(),
                );
            }, $eleves);
        
            $ac = new AC();
            $form = $this->createForm(ACFormType::class, $ac);
            $form->handleRequest($request);
    
            $em = $doctrine->getManager();
            $repository=$em->getRepository(AC::class);
            
            $acs = [];

            if ($form->isSubmitted() && $form->isValid()) {
    
                $ac->setLabel($ac->getLabel());
                $ac->setCompetence($ac->getCompetence());
                $ac->setDescription($ac->getDescription());
                $ac->setNiveau($ac->getNiveau());
    
                $entityManager->persist($ac);
                $entityManager->flush();
            }
    
            $acs =  $repository->findAll();


        $professeurs = $userRepository->createQueryBuilder('u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%ROLE_PROF%')
            ->getQuery()
            ->getResult();

            $professeursData = array_map(function($professeur){
                return array(
                    'nom' => $professeur->getNom(),
                    'prenom' => $professeur->getPrenom(),
                    'photo' => $professeur->getPhoto(),
                );
            }, $professeurs);
        

        $admins = $userRepository->createQueryBuilder('u')
        ->where('u.roles LIKE :roles')
        ->setParameter('roles', '%ROLE_ADMIN%')
        ->getQuery()
        ->getResult();

        $adminsData = array_map(function($admin){
            return array(
                'nom' => $admin->getNom(),
                'prenom' => $admin->getPrenom(),
                'photo' => $admin->getPhoto(),
            );
        }, $admins);

        $users = $userRepository->createQueryBuilder('u')
        ->where('u.roles = :roles')
        ->setParameter('roles', '["ROLE_USER"]')
        ->getQuery()
        ->getResult();

        $usersData = array_map(function($user){
            return array(
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
                'email' => $user->getEmail(),
            );
        }, $users);

        $url = $request->getUri();


        return $this->render("admin.html.twig", ['eleves' => $elevesData, 'professeurs' => $professeursData,'users' => $usersData, 'admins' => $adminsData, 'formAC' => $form->createView(), 'url' => $url]);
    }

    public function profile(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager, Security $security): Response
    {
        $projet = new Projet();
        $form = $this->createForm(AjoutProjetForm::class, $projet);
        $form->handleRequest($request);

        $em = $doctrine->getManager();
        $repository=$em->getRepository(Projet::class);

        $projets = [];

        if ($form->isSubmitted() && $form->isValid()) {

            // $projet->setIdUser($this->getUser());
            $projet->setIdUser($security->getUser());

            $projet->setNom($projet->getNom());
            $projet->setDescription($projet->getDescription());


            $projetImage = $form->get('image')->getData();
            if ($projetImage) {
                $originalFilename = pathinfo($projetImage->getClientOriginalName(), PATHINFO_FILENAME);
                
                $newFilename = $originalFilename.'.'.$projetImage->guessExtension();
                
                try {
                    $projetImage->move(
                        $this->getParameter('projets_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                
                $projet->setImage($newFilename);
            }

            $projet->setDate($projet->getDate());

            $entityManager->persist($projet);
            $entityManager->flush();
        }

        $acChoices = $doctrine->getManager()->getRepository(AC::class)->findAll();
        
        $ajoutACForms = [];
        $newprojetAC = new ProjetAC();

        for ($i = 0; $i < 3; $i++) {
            $ajoutACForms[$i] = $this->createForm(AjoutProjetACForm::class, new ProjetAC(), [
                'ac_choices' => $acChoices,
                'label' => false,
            ])->createView();
        }


        // for ($i = 0; $i < 3; $i++) {
        //     $newprojetAC = new ProjetAC();

        //     $ajoutACForm = $this->createForm(AjoutProjetACForm::class, $newprojetAC, [
        //         'ac_choices' => $acChoices,
        //         'label' => false,
        //     ]);
        //     $ajoutACForm->handleRequest($request);
        //     $ajoutACForms[] = $ajoutACForm->createView();
        
        //     if ($ajoutACForm->isSubmitted() && $ajoutACForm->isValid()) {
        //         $projetAC = $ajoutACForm->getData();
        //         // print_r($projetAC->getLabel());
                
        //         if (!empty($projetAC->getLabel())) {
        //             $newprojetAC->setLabel($projetAC->getLabel());
        //             $newprojetAC->setProjet($projet);
        //             $newprojetAC->setCommentaire($projetAC->getCommentaire());
        //             // $newprojetAC->setName($projetAC->getProjectName());
        //             $newprojetAC->setNote($projetAC->getNote());
    
        //             // print_r($newprojetAC);
                    
        //             $entityManager->persist($newprojetAC);
        //             $entityManager->flush();                      
        //         }
        //     } 
        // }
        
        // $newprojetAC = new ProjetAC();

        // $ajoutACForm = $this->createForm(AjoutProjetACForm::class, $newprojetAC, [
        //     'ac_choices' => $acChoices,
        //     'label' => false,
        // ]);
        // $ajoutACForm->handleRequest($request);
        // $ajoutACFormView = $ajoutACForm->createView();
    
        // if ($ajoutACForm->isSubmitted() && $ajoutACForm->isValid()) {
        //     $entityManager->persist($projet);
        //     $entityManager->flush();

        //     $projetAC = $ajoutACForm->getData();
        //     // print_r($projetAC);
            
        //     if (!empty($projetAC->getLabel())) {
        //         $newprojetAC->setLabel($projetAC->getLabel());
        //         $newprojetAC->setProjet($projet);
        //         print_r($newprojetAC);
        //         $newprojetAC->setCommentaire($projetAC->getCommentaire());
        //         // $newprojetAC->setName($projetAC->getProjectName());
        //         $newprojetAC->setNote($projetAC->getNote());

        //         // print_r($newprojetAC);
                
        //         $entityManager->persist($newprojetAC);
        //         $entityManager->flush();                      
        //     }
        // } 


        // $ajoutACForms = [];

        // // Handle the first form
        // $ajoutACForm1 = $this->createForm(AjoutProjetACForm::class, null, [
        //     'ac_choices' => $acChoices,
        //     'label' => false,
        // ]);
        // $ajoutACForm1->handleRequest($request);
        // $ajoutACForms[] = $ajoutACForm1->createView();
        
        // if ($ajoutACForm1->isSubmitted() && $ajoutACForm1->isValid()) {
        //     $projetAC = $ajoutACForm1->getData();
            
        //     $newprojetAC1 = new ProjetAC();

        //     if (!empty($projetAC->getLabel())) {
        //         $newprojetAC1->setLabel($projetAC->getLabel());
        //         $newprojetAC1->setProjet($projet);
        //         $newprojetAC1->setCommentaire($projetAC->getCommentaire());
        //         $newprojetAC1->setNote($projetAC->getNote());
                
        //         $entityManager->persist($newprojetAC1);
        //     }
        // }
        
        // // Handle the second form
        // $ajoutACForm2 = $this->createForm(AjoutProjetACForm::class, null, [
        //     'ac_choices' => $acChoices,
        //     'label' => false,
        // ]);
        // $ajoutACForm2->handleRequest($request);
        // $ajoutACForms[] = $ajoutACForm2->createView();
        
        // if ($ajoutACForm2->isSubmitted() && $ajoutACForm2->isValid()) {
        //     $projetAC2 = $ajoutACForm2->getData();
        //     $newprojetAC2 = new ProjetAC();
            
        //     if (!empty($projetAC2->getLabel())) {
        //         $newprojetAC2->setLabel($projetAC2->getLabel());
        //         $newprojetAC2->setProjet($projet);
        //         $newprojetAC2->setCommentaire($projetAC2->getCommentaire());
        //         $newprojetAC2->setNote($projetAC2->getNote());
                
        //         $entityManager->persist($newprojetAC2);
        //     }
        // }
        
        // // Handle the third form
        // $ajoutACForm3 = $this->createForm(AjoutProjetACForm::class, null, [
        //     'ac_choices' => $acChoices,
        //     'label' => false,
        // ]);
        // $ajoutACForm3->handleRequest($request);
        // $ajoutACForms[] = $ajoutACForm3->createView();
        
        // if ($ajoutACForm3->isSubmitted() && $ajoutACForm3->isValid()) {
        //     $projetAC3 = $ajoutACForm3->getData();
        //     $newprojetAC3 = new ProjetAC();
        //     if (!empty($projetAC3->getLabel())) {
        //         $newprojetAC3->setLabel($projetAC3->getLabel());
        //         $newprojetAC3->setProjet($projet);
        //         $newprojetAC3->setCommentaire($projetAC3->getCommentaire());
        //         $newprojetAC3->setNote($projetAC3->getNote());
                
        //         $entityManager->persist($newprojetAC3);
                
        //     }
        // }
        // $entityManager->flush();


        $projets =  $repository->findBy(
            array('id_user' => ($this->getUser())->getId()));

        return $this->render('profile.html.twig', [
            'ajoutForm' => $form->createView(), 
            'projets' => $projets,
            'ajoutACForms' => $ajoutACForms,
        ]);
    }

}

?>

