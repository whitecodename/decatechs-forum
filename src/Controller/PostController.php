<?php

namespace App\Controller;

use AllowDynamicProperties;
use App\Entity\Post;
use App\Form\PostType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AllowDynamicProperties] #[Route('/post', name: 'post.')]
class PostController extends AbstractController
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => Requirement::DIGITS])]
    public function show(int $post_id, CommentRepository $commentRepository, PostRepository $postRepository): Response
    {
        $comments = $commentRepository->findBy(['post' => $post_id]);
        $post = $postRepository->find($post_id);
        $commentsCount = $postRepository->countCommentsForPost($post);

        return $this->render('post/index.html.twig', [
            'post' => $post_id,
            'comments' => $comments,
            'commentsCount' =>$commentsCount
        ]);
    }

    #[Route('/create', name: 'create')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $user = $this->security->getUser();
            $post->setOwner($user);

            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'Post added !');
            return $this->redirectToRoute('forum.show', ['service_id' => $post->getService()->getId()]);
        }

        return $this->render('post/create.html.twig', [
            'form' => $form
        ]);
    }
}
