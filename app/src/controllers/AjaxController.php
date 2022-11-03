<?php

namespace src\controllers;

use Exception;
use src\lib\Helpers\FileHelper;
use src\lib\Validators\FormValidator;
use src\models\Database ;

/**
 * Class AjaxController
 * @package controllers
 */
class AjaxController
{
    /*
     * Обработка данных из форм
     */
    public function index()
    {
        $action = $_POST['action'] ?? false;

        if (method_exists($this, $action)){
            $this->$action();
        } else {
            throw new Exception("Ошибка отправки формы: не существует метода для обработки формы");
        }
    }

    /*
     * Обработка формы добавления отзыва
     */
    private function sendFeedback()
    {
        $validate = FormValidator::validate();

        if ($validate['status'] === 'error') {
            $result['success'] = false;
            $result['error'] = $validate['message'];

            echo json_encode($result);
            return;
        }

        $image = $thumb = null;

        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            $image = FileHelper::resize($_FILES['file']);

            $_FILES['file']['name'] = str_replace(".", "_thumb.", $_FILES['file']['name']);
            $thumb = FileHelper::resize($_FILES['file'], true);
        }


        $db = Database::getInstance();
        $response = $db->addFeedback(
            $validate['data']['name'],
            $validate['data']['email'],
            $validate['data']['text'],
            $image,
            $thumb
        );

        $result = $this->response($response,"Ошибка добавления отзыва");

        echo json_encode($result);
    }

    /*
     * Обработка формы авторизации
     */
    private function sendCredentials()
    {
        if (isset($_POST['login'])){
            $login = addslashes($_POST['login']);
        } else {
            $errorMessage = "Ошибка отправки формы: не введен логин";
        }

        if (isset($_POST['pass'])){
            $pass = addslashes($_POST['pass']);
        } else {
            $errorMessage = "Ошибка отправки формы: не введен пароль";
        }

        if ($errorMessage){
            $result['success'] = false;
            $result['error'] = $errorMessage;
        }

        $db = Database::getInstance();
        $response = $db->authorize($login, $pass);

        $result = $this->response($response,"Неверное имя пользователя или пароль!");

        echo json_encode($result);
    }



    private function acceptFeedback()
    {
        if (isset($_POST['id']) && is_numeric($_POST['id'])){
            $id = $_POST['id'];
        } else {
            $errorMessage = "Ошибка одобрения отзыва";
        }

        if (isset($_POST['accept']) && is_numeric($_POST['accept'])){
            $accept = $_POST['accept'];
        } else {
            $errorMessage = "Ошибка отправки формы: не задан или неправильный e-mail";
        }

        if ($errorMessage){
            $result['success'] = false;
            $result['error'] = $errorMessage;
        }

        $db = Database::getInstance();
        $response = $db->changeAccept($id, $accept);

        $result = $this->response($response,"Ошибка одобрения отзыва");

        echo json_encode($result);
    }

    /*
     * Сохраняет измененный отчет
     *
     */
    private function saveChangedText()
    {
        if (isset($_POST['text'])){
            $text = addslashes($_POST['text']);
        } else {
            $errorMessage = "Ошибка отправки формы: не введен текст отзыва";
        }

        if (isset($_POST['id']) && is_numeric($_POST['id'])){
            $id = $_POST['id'];
        } else {
            $errorMessage = "Ошибка отправки формы: отсутствует id отзыва";
        }

        if ($errorMessage){
            $result['success'] = false;
            $result['error'] = $errorMessage;
        }

        $db = Database::getInstance();
        $response = $db->changeFeedback($id, $text);

        $result = $this->response($response,"Ошибка сохранения отзыва");

        echo json_encode($result);
    }

    /*
     * Обработка результата запроса к БД
     * @param $response
     * @param $errorMessage
     *
     * @return array
     */
    private function response($response, $errorMessage)
    {
        if ($response){
            $result['success'] = true;
        } else {
            $result['success'] = false;
            $result['error'] = $errorMessage;
        }

        return $result;
    }
}