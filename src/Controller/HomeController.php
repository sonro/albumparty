<?php

namespace App\Controller;

use App\Entity\Party;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
		if ($this->getUser()) {
			return $this->userDash();
		}

		return $this->guestHome();

    }

	private function userDash(): Response
	{
		$user = $this->getUser();
		if (!$user->getParty()) {
			return $this->createDashResposnse(['no_party' => true]);
		}
			
		// check if previous album was reviewed
		$context['last_album_reviewed'] = false;

		$context['current_album'] = $user->getParty()->getCurrentAlbum();

		$context['next_album_when'] = '2 days';

		return $this->createDashResposnse($context);
	}

	private function createDashResposnse(array $templateVariables): Response 
	{
		return $this->render('home/dash.html.twig', $templateVariables);
	}

	private function guestHome(): Response
	{
        return $this->render('home/index.html.twig', []);
	}
}
