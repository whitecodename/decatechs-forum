<?php

namespace App\Controller;

use AllowDynamicProperties;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AllowDynamicProperties] #[Route('/comment', name: 'comment.')]
class CommentController extends AbstractController
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return new Response('Comment');
    }

    #[Route('/{post_id}', name: 'show', requirements: ['post_id' => Requirement::DIGITS])]
    public function show(int $post_id, PostRepository $postRepository, CommentRepository $commentRepository, ServiceRepository $serviceRepository): Response
    {
        $post = $postRepository->find($post_id);
        $comments = $commentRepository->findBy(['post' => $post]);
        $services = $serviceRepository->findAll();
        $commentsCount = $postRepository->countCommentsForPost($post_id);

        $postsCount = [];

        foreach ($services as $service) {
            $postsCount[$service->getId()] = $service->getPosts()->count();
        }

        return $this->render('comment/show.html.twig', [
            'post' => $post,
            'comments' => $comments,
            'services' => $services,
            'postsCount' => $postsCount,
            'commentsCount' => $commentsCount
        ]);
    }

    #[Route('/create/{post_id}', name: 'create')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function create(int $post_id, Request $request, PostRepository $postRepository, EntityManagerInterface $em): Response
    {
        $post = $postRepository->find($post_id);

        $comment = new Comment();
        $comment->setPost($post);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $user = $this->security->getUser();
            $comment->setOwner($user);

            $em->persist($comment);
            $em->flush();

            $this->addFlash('success', 'Comment created !');
            return $this->redirectToRoute('comment.show', [
                'post_id' => $post_id
            ]);
        }

        return $this->render('comment/create.html.twig', [
            'form' => $form
        ]);
    }
}
