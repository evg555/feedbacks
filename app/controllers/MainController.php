<?php
namespace app\controllers;

use app\models\Database;

class MainController extends BaseControler
{
    public function index()
    {
        try {
            $db = Database::getInstance();

            if (isset($_GET['sort'])){
                $this->_data = $db->getAllFeedbacks($_GET['sort']);
            } else {
                $this->_data = $db->getAllFeedbacks();
            }

            parent::index();
        } catch (\Exception $e){
            echo $e->getMessage();
        }
    }

    protected function render($data){
        include TEMPLATE_DIR . "/feedbacks.php";
    }

}