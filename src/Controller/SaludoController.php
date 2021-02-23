<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SaludoController extends AbstractController {

    /**
     * @Route("/hola", name="hola")
     */
    public function index(): Response {
        $name = "Carlos";

        return new Response('<html><body>Hola, '.$name.'</body></html>');
    }

    /**
     * @Route("/adios", name="adios")
     */
    public function otra(): Response {
        $name = "Carlos";

        return new Response('<html><body>Hola, '.$name.'</body></html>');
    }

    /**
     * @Route("/employees/edit/{id}", name="employees_edit", requirements={"id"="\d+"})
     */
    public function edit(int $id = 1): Response {
        
        // $user->addCoche($coche)
        
        return new Response("<html><body>Editando empleado: $id </body></html>");
    }

     /**  
    * @Route("/employees/list", name="employees_list")
    */
   
    public function orderList(Request $request): Response {

        $orderBy = $request->query->get("orderby", "name"); 
        $page = $request->query->get("page", 1);

        $people = [
            ['name' => 'Carlos', 'email' => 'carlos@correo.com', 'age' => 20, 'city' => 'Benalmádena'],
            ['name' => 'Carmen', 'email' => 'carmen@correo.com', 'age' => 15, 'city' => 'Fuengirola'],
            ['name' => 'Carmelo', 'email' => 'carmelo@correo.com', 'age' => 17, 'city' => 'Torremolinos'],
            ['name' => 'Carolina', 'email' => 'carolina@correo.com', 'age' => 18, 'city' => 'Málaga'],
          ]; 

        return new JsonResponse($people);
    }
}