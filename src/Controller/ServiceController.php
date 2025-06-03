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

final class ServiceController extends AbstractController
{
    #[Route('/', name: 'app_service')]
    public function index(ServiceRepository $sr): Response
    {
        return $this->render('service/index.html.twig', [
            'services' => $sr->findAll(),
        ]);
    }
    #[Route('/service', name: 'app_service_add_one', methods: ["POST"])]
    public function add_one(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $manager = $managerRegistry->getManager();
        $r = $request;
        $s = new Service();
        $s->setNom($r->get("nom"));
        $s->setDescription($r->get("description"));
        $s->setPrix($r->get("prix"));
        $s->setImage("");
        $manager->persist($s);
        $manager->flush();
        return $this->render('service/show.html.twig', [
            'service' => $s,
        ]);
    }

    #[Route('/service/add', name: 'app_service_add_one_form')]
    public function formAddOne(): Response
    {


        return $this->render('service/add.html.twig');
    }

    #[Route('/service/{id}', name: 'app_service_show_one', methods: ["GET"])]
    public function show_one(int $id, ServiceRepository $sr): Response
    {
        return $this->render('service/show.html.twig', [
            'service' => $sr->find($id),
        ]);
    }



}
