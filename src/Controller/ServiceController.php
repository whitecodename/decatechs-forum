<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/service', name: 'service.')]
class ServiceController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ServiceRepository $serviceRepository): Response
    {
        $services = $serviceRepository->findAll();
        $postsCount = [];

        foreach ($services as $service) {
            $postsCount[$service->getId()] = $service->getPosts()->count();
        }

        return $this->render('service/index.html.twig', [
            'services' => $services,
            'postsCount' => $postsCount
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => Requirement::DIGITS])]
    public function show(PostRepository $postRepository): Response
    {

        $posts = $postRepository->findAll();
        $commentsCounts = [];
        foreach ($posts as $post) {
            $commentsCounts[$post->getId()] = $postRepository->countCommentsForPost($post);
        }

        return $this->render('service/show.html.twig', [
            'posts' => $posts,
            'commentsCount' => $commentsCounts
        ]);
    }
}
