<?php /** @noinspection PhpIncludeInspection */

namespace src\Controllers;

use Exception;
use src\Repositories\FeedbackRepository;
use src\Services\FeedbackService;

/**
 * Class MainController
 * @package src\Controllers
 */
class MainController extends BaseControler
{
    private FeedbackService $feedbackService;

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

    protected function render()
    {
        include TEMPLATE_DIR . 'feedbacks.php';
    }
}