<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeesController extends AbstractController
{
    /**
     * @Route("/employees", name="employees")
     */
    public function index(): Response
    {
        $name = 'Carlos';

        $people = [
            ['id' => 1, 'name' => 'Carlos', 'email' => 'carlos@correo.com', 'age' => 20, 'city' => 'Benalmádena'],
            ['id' => 4, 'name' => 'Carmen', 'email' => 'carmen@correo.com', 'age' => 15, 'city' => 'Fuengirola'],
            ['id' => 5, 'name' => 'Carmelo', 'email' => 'carmelo@correo.com', 'age' => 17, 'city' => 'Torremolinos'],
            ['id' => 8, 'name' => 'Carolina', 'email' => 'carolina@correo.com', 'age' => 18, 'city' => 'Málaga'],
          ]; 

        return $this->render('employees/index.html.twig', [
            'controller_name' => 'EmployeesController',
            'myname' => $name,
            'employees' => $people
        ]);
    }
}
