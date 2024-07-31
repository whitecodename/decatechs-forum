<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ServiceRepository $serviceRepository, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        $services = $serviceRepository->findAll();

        return $this->render('home/index.html.twig', [
            'services' => $services
        ]);
    }
}
