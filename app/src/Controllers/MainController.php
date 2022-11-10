<?php /** @noinspection PhpIncludeInspection */

namespace src\Controllers;

use Exception;
use src\Services\FeedbackServiceInterface;

/**
 * Class MainController
 * @package src\Controllers
 */
class MainController extends BaseControler
{
    private FeedbackServiceInterface $feedbackService;

    public function __construct(FeedbackServiceInterface $feedbackService)
    {
        $this->feedbackService = $feedbackService;
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

    protected function render()
    {
        include TEMPLATE_DIR . 'feedbacks.php';
    }
}