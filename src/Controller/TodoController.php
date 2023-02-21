<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route("/todo")]
class TodoController extends AbstractController
{
    /**
     * @Route("/", name="app_todo")
     */

    public function index(Request $request): Response
    {
        $session = $request->getSession();
        // afficher notre tableau de todo
        // sinon je l'initialise puis j'affiche
        if (!$session->has('todos')) {
            $todos = [
                'achat' => 'acheter un clé USB',
                'cours' => 'Finaliser mon cours',
                'correction' => 'corriger mon examens'
            ];
            $session->set('todos', $todos);
            $this->addFlash('info', "La liste des todos viens d'être initialisée");
        }
        // si j'ai mon tableau de todo dans ma session je ne le fait que l'afficher
        return $this->render('todo/index.html.twig');
    }
   #[Route(
       '/add/{name?test}/{content?test}',
        name: 'todo.add'
   )]
    public function addTodo(Request $request, $name, $content): RedirectResponse {
        $session = $request->getSession();
        // verfier si j'ai mon tableau todo dans la session
       if ($session->has('todos')) {
         //si oui
           // verifier si on a deja todos avec le meme name
           $todos = $session->get('todos');
           if (isset($todos[$name])) {
               // si oui afficher un erreur

               $this->addFlash('error', "Le todo d'id $name existe déja dans la liste");
           } else {
               // si non on l'ajouter  et on affiche un message de succés
               $todos[$name] = $content;
               $this->addFlash('success', "Le todo d'id $name a été ajoutée avec succés");
               $session->set('todos', $todos);
           }
       } else {
           //si non
           // afficher une erreur et on va redirger vers le controlleur l'index
           $this->addFlash('error', "La liste des todos n'est pas encore initialisée");
       }
        return $this->redirectToRoute('app_todo');

    }
    #[Route('/update/{name}/{content}', name: 'todo.update')]
    public function updateTodo(Request $request, $name, $content): RedirectResponse {
        $session = $request->getSession();
        // verfier si j'ai mon tableau todo dans la session
        if ($session->has('todos')) {
            //si oui
            // verifier si on a deja todos avec le meme name
            $todos = $session->get('todos');
            if (!isset($todos[$name])) {
                // si oui afficher un erreur

                $this->addFlash('error', "Le todo d'id $name n'existe pas dans la liste");
            } else {
                // si non on l'ajouter  et on affiche un message de succés
                $todos[$name] = $content;
                $this->addFlash('success', "Le todo d'id $name a été modifié avec succés");
                $session->set('todos', $todos);
            }
        } else {
            //si non
            // afficher une erreur et on va redirger vers le controlleur l'index
            $this->addFlash('error', "La liste des todos n'est pas encore initialisée");
        }
        return $this->redirectToRoute('app_todo');

    }
    #[Route('/delete/{name}', name: 'todo.delete')]
    public function deleteTodo(Request $request, $name): RedirectResponse {
        $session = $request->getSession();
        // verfier si j'ai mon tableau todo dans la session
        if ($session->has('todos')) {
            //si oui
            // verifier si on a deja todos avec le meme name
            $todos = $session->get('todos');
            if (!isset($todos[$name])) {
                // si oui afficher un erreur

                $this->addFlash('error', "Le todo d'id $name n'existe pas dans la liste");
            } else {
                // si non on l'ajouter  et on affiche un message de succés
                unset($todos[$name]);
                $this->addFlash('success', "Le todo d'id $name a été supprimé avec succés");
                $session->set('todos', $todos);
            }
        } else {
            //si non
            // afficher une erreur et on va redirger vers le controlleur l'index
            $this->addFlash('error', "La liste des todos n'est pas encore initialisée");
        }
        return $this->redirectToRoute('app_todo');

    }
    #[Route('/reset', name: 'todo.reset')]
    public function resetTodo(Request $request): RedirectResponse {
        $session = $request->getSession();
        $session->remove('todos');
        return $this->redirectToRoute('app_todo');

    }
}
