<?php
namespace src\Controllers;

use Exception;
use src\Repositories\FeedbackRepository;
use src\Services\Connection;
use src\Services\FeedbackService;

/**
 * Class MainController
 * @package src\Controllers
 */
class MainController extends BaseControler
{
    public function __construct()
    {
        $this->feedbackService = new FeedbackService(new FeedbackRepository());
    }

    public function index()
    {
        try {
            $this->data = $this->feedbackService->get();

            parent::index();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Передаем переменные и рендерим страницу
     */
    protected function render()
    {
        include TEMPLATE_DIR . "/feedbacks.php";
    }
}