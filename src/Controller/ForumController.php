<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/forum', name: 'forum.')]
class ForumController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ServiceRepository $serviceRepository, PostRepository $postRepository): Response
    {
        $services = $serviceRepository->findAll();
        $posts = $postRepository->findAll();

        $postsCount = [];

        foreach ($services as $service) {
            $postsCount[$service->getId()] = $service->getPosts()->count();
        }

        return $this->render('forum/index.html.twig', [
            'services' => $services,
            'posts' => $posts,
            'postsCount' => $postsCount
        ]);
    }

    #[Route('/{service_id}', name: 'show')]
    public function show(int $service_id, ServiceRepository $serviceRepository, PostRepository $postRepository): Response
    {
        $service = $serviceRepository->find($service_id);
        $services = $serviceRepository->findAll();
        $posts = $postRepository->findBy(['service' => $service]);

        $allPosts = $postRepository->findAll();

        $commentsCounts = [];

        foreach ($allPosts as $post) {
            $commentsCounts[$post->getId()] = $postRepository->countCommentsForPost($post->getId());
        }

        $postsCount = [];

        foreach ($services as $s) {
            $postsCount[$s->getId()] = $s->getPosts()->count();
        }

        return $this->render('forum/show.html.twig', [
            'service' => $service,
            'services' => $services,
            'activeServiceId' => $service_id,
            'posts' => $posts,
            'postsCount' => $postsCount,
            'commentsCount' => $commentsCounts
        ]);
    }
}
