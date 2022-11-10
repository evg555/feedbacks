<?php /** @noinspection PhpUnused */

namespace src\Controllers;

/**
 * Class LoginController
 * @package src\Controllers
 */
class LoginController extends BaseControler
{
    /** @noinspection PhpUnused */
    public function index()
    {
        session_start();
        if ($_SESSION['authorized']){
            header("Location: /admin");
        }

        parent::index();
    }

    /**
     * @noinspection PhpUnused
     */
    protected function render()
    {
        /** @noinspection PhpIncludeInspection */
        include TEMPLATE_DIR . "login.php";
    }
}