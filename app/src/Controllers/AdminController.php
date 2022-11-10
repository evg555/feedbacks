<?php /** @noinspection PhpUnused */

/** @noinspection PhpIncludeInspection */

namespace src\Controllers;
use Exception;
use src\Services\FeedbackServiceInterface;

/**
 * Class AdminController
 * @package src\Controllers
 */
class AdminController extends BaseControler
{
    private FeedbackServiceInterface $feedBackService;

    public function __construct(FeedbackServiceInterface $feedBackService)
    {
        $this->feedBackService = $feedBackService;
    }

    public function index()
    {
        session_start();
        if (empty($_SESSION['authorized'])){
            header("Location /login");
        }

        if (isset($_GET['logout'])){
            unset($_SESSION['user']);
            unset($_SESSION['authorized']);
            session_destroy();

            header('Location: /login');
        }

        try {
            $this->data['feedbacks'] = $this->feedBackService->get('admin');
            $this->data['user'] = $_SESSION['user'];

            parent::index();
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }

    protected function render()
    {
        include TEMPLATE_DIR . 'admin.php';
    }
}