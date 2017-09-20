<?php

namespace app\controllers;


use app\models\Database;

class AjaxController
{
    /*
     * Обработка данных из форм
     */
    public function index(){
        $action = isset($_POST['action']) ? $_POST['action'] : false;

        if (method_exists($this, $action)){
            $this->$action();
        } else {
            throw new \Exception("Ошибка отправки формы: не существует метода для обработки формы. Обратитесь в техническую поддержку ");
        }
    }

    /*
     * Обработка формы добавления отзыва
     */
    private function sendFeedback(){
        if (isset($_POST['name'])){
            $name = addslashes($_POST['name']);
        } else {
            $errorMessage = "Ошибка отправки формы: не задано имя";
        }

        if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $email = $_POST['email'];
        } else {
            $errorMessage = "Ошибка отправки формы: не задан или неправильный e-mail";
        }

        if (isset($_POST['text'])){
            $text = addslashes($_POST['text']);
        } else {
            $errorMessage = "Ошибка отправки формы: не задано текст отзыва";
        }

        if ($errorMessage){
            $result['success'] = false;
            $result['error'] = $errorMessage;
        }

        $db = Database::getInstance();
        $response = $db->addFeedback($name,$email,$text, null);

        if ($response){
            $result['success'] = true;
        } else {
            $result['success'] = false;
            $result['error'] = "Ошибка добавления отзыва! Обратитесь в техническую поддержку!";
        }

        echo json_encode($result);
    }

    private function sendCredentials(){

    }
}