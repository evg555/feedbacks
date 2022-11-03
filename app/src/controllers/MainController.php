<?php
namespace src\controllers;

use Exception;
use src\models\Database;

/**
 * Class MainController
 * @package src\controllers
 */
class MainController extends BaseControler
{
    public function index()
    {
        try {
            //TODO вынести подключение к БД на уровень приложения
            $db = Database::getInstance();

            $sort = $_GET['sort'] ?? 'byDate';

            $this->data = $db->getAllFeedbacks($sort);

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
        include TEMPLATE_DIR . "/feedbacks.php";
    }
}