<?php

namespace src\Controllers;
use Exception;
use src\Repositories\FeedbackRepository;
use src\Services\Connection;
use src\Services\FeedbackService;

/**
 * Class AdminController
 * @package src\Controllers
 */
class AdminController extends BaseControler
{
    public function __construct()
    {
        $this->feedBackService = new FeedbackService(new FeedbackRepository());
    }

    public function index()
    {
        //Проверяем, что пользователь залогинен
        session_start();
        if (empty($_SESSION['authorized'])){
            header("Location /login");
        }

        //Выход пользователя из панели
        if (isset($_GET['logout'])){
            unset($_SESSION['user']);
            unset($_SESSION['authorized']);
            session_destroy();

            header('Location: /login');
        }

        //Загружаем отзывы в админку
        try {
            $this->data['feedbacks'] = $this->feedBackService->get('admin');
            $this->data['user'] = $_SESSION['user'];

            parent::index();
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * Передаем переменные и рендерим страницу
     */
    protected function render()
    {
        include TEMPLATE_DIR . "/admin.php";
    }
}