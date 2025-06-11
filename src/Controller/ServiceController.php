<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

final class ServiceController extends AbstractController
{
    #[Route('/', name: 'app_service')]
    public function index(ServiceRepository $sr): Response
    {
        return $this->render('service/index.html.twig', [
            'services' => $sr->findAll(),
        ]);
    }


    #[Route('/service/add', name: 'app_service_add_one_form')]
    public function formAddOne(Request $request,ManagerRegistry $em): Response
    {

        $em = $em->getManager();
        $s = new Service();
        $s->setNom("nom");
        $s->setDescription("description");
        $s->setPrix(0);
        $s->setImage("");

        $form = $this->createFormBuilder($s)
            ->add("nom", TextType::class)
            ->add("description", TextareaType::class)
            ->add("prix", IntegerType::class)
            ->add('save', SubmitType::class, ['label' => 'Ajouter'])
            ->getForm();

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($s);
                $em->flush();
                return $this->redirectToRoute('app_service');
            }

        return $this->render('service/add.html.twig',[
            'form'=> $form
        ]);
    }

    #[Route('/service/{id}', name: 'app_service_show_one', methods: ["GET"])]
    public function show_one(int $id, ServiceRepository $sr): Response
    {
        return $this->render('service/show.html.twig', [
            'service' => $sr->find($id),
        ]);
    }

    #[Route('/service/{id}', name: 'app_delete_one', methods: ["DELETE"])]
    public function delete_one(Service $service, ManagerRegistry  $mr): Response
    {
        $em = $mr->getManager();
        $em->remove($service);
        $em->flush();

        return new Response('success');
    }

    #[Route('/service/edit/{id}', name: 'app_edit_service')]
    public function edit_one(Request $request, Service $service, ManagerRegistry  $mr): Response
    {
        $em = $mr->getManager();
        $form = $this->createFormBuilder($service)
            ->add("nom", TextType::class)
            ->add("description", TextareaType::class)
            ->add("prix", IntegerType::class)
            ->add('save', SubmitType::class, ['label' => 'Ajouter'])
            ->getForm();

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($service);
                $em->flush();
                return $this->redirectToRoute('app_service');
            }  

        return $this->render('service/add.html.twig',[
            'form'=> $form
        ]);

    }

    
}
