<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\ArticleRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
public function index(RequestStack $requestStack, ArticleRepository $articleRepository)
{
    $session = $requestStack->getSession();

    $nb = $session->get('nb_visites', 0);
    $session->set('nb_visites', $nb + 1);

    $articles = $articleRepository->findLastPublished(3);

    return $this->render('accueil/index.html.twig', [
        'visites' => $nb,
        'articles' => $articles
    ]);
}
#[Route('/send-email', name: 'send_email')]
public function sendEmail(MailerInterface $mailer): Response
{
    $email = (new Email())
        ->from('test@example.com')
        ->to('you@example.com')
        ->subject('Test TP4')
        ->text('Hello from Symfony')
        ->html('<p>Hello from Symfony</p>');

    $mailer->send($email);

    return new Response("Email envoyé");
}
    #[Route('/bonjour/{prenom}', name: 'app_bonjour')]
    public function bonjour(string $prenom): Response
    {
        return new Response("<h1>Bonjour $prenom ! Bienvenue sur Symfony 7.4</h1>");
    }
    #[Route('/profil/{id}', name: 'app_profil', requirements: ['id' => '\d+'], defaults: ['id' => 1])]
    public function profil(int $id): Response
    {
        return new Response("<h1>Profil de l'utilisateur n°$id</h1>");
    }
    
}
