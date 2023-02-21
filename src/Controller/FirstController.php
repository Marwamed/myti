<?php

namespace App\Controller;

use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{

    #[Route('/order/{mavar}', name: 'test.order.route')]
    public function testOrderRoute($mavar) {
        return new Response("
        <html><body>$mavar</body></html>");
    }
    #[Route('/first/marwa', name: 'app_first')]
    public function index(): Response
    {
        // chercher a la base de données vos users
        return $this->render('first/index.html.twig', [
            'name' => 'Ben Mohamed',
            'firstname' => 'Marwa'
        ]);
    }


    #[Route('/sayHello/{name}/{firstname}', name: 'say.hello')]
    public function sayHello(\Symfony\Component\HttpFoundation\Request $request, $name, $firstname): Response
    {

        return $this->render('first/hello.html.twig',[
                                  'nom' => $name,
                                   'prenom'=> $firstname
        ]);

    }
    #[Route(
        'multi/{entier1<\d+>}/{entier2<\d+>}',
        name: 'app_first_multiplication')]
    public function multiplication($entier1, $entier2) {
        $resultat = $entier1 * $entier2;
        return new Response("<h1>$resultat</h1>");
    }
}
