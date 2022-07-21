<?php

namespace App\Controller;

use App\service\MangaUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(Request $request, MangaUtils $mangaUtils): Response
    {
        $data = array_map('trim', $request->request->all());
        if (!empty($data)) {
        $mangaUtils->addManga($data);
        }
        
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
