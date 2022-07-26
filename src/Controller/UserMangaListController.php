<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserMangaListRepository;
use App\service\UserMangaListUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/manga/list')]
class UserMangaListController extends AbstractController
{
    #[Route('/{id}', name: 'app_user_manga_list_index', methods: ['GET'])]
    public function index(UserMangaListRepository $userMangaListRepository, User $user): Response
    {
        return $this->render('user_manga_list/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/new', name: 'app_user_manga_list_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        User $user,
        UserMangaListUtils $userMangaListUtils,
        ): Response {
            $userId = $user->getId();
            $data = array_map('trim', $request->request->all());
            if (!empty($data)) {
                $userMangaListUtils->addUserMangaList($data, $user);
                return $this->redirectToRoute('app_user_manga_list_index', ['id' => $userId]);
            }

        return $this->renderForm('user_manga_list/new.html.twig', [
        ]);
    }
}
