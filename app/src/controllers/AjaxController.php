<?php

namespace src\controllers;

use Exception;
use src\lib\Helpers\FileHelper;
use src\lib\Services\Validation\AcceptValidation;
use src\lib\Services\Validation\ChangedTextValidation;
use src\lib\Services\Validation\CredentialValidaton;
use src\lib\Services\Validation\FormValidation;
use src\models\Database;

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

        //TODO: Убрать дублирование кода и вынести ошибки через исключения ValidationException
    }

    /*
     * Обработка формы добавления отзыва
     *  @
     */
    private function sendFeedback()
    {
        $validate = FormValidation::validate();

        if ($validate['status'] === 'error') {
            $this->sendError($validate['message']);
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

        $this->response($response,"Ошибка добавления отзыва");
    }

    /*
     * Обработка формы авторизации
     */
    private function sendCredentials()
    {
        $validate = CredentialValidaton::validate();

        if ($validate['status'] === 'error') {
            $this->sendError($validate['message']);
            return;
        }

        $db = Database::getInstance();
        $response = $db->authorize($validate['data']['login'], $validate['data']['pass']);

        $this->response($response,"Неверное имя пользователя или пароль!");
    }

    private function acceptFeedback()
    {
        $validate = AcceptValidation::validate();

        if ($validate['status'] === 'error') {
            $this->sendError($validate['message']);
            return;
        }

        $db = Database::getInstance();
        $response = $db->changeAccept($validate['data']['id'], $validate['data']['accept']);

        $this->response($response,"Ошибка одобрения отзыва");
    }

    /*
     * Сохраняет измененный отчет
     *
     */
    private function saveChangedText()
    {
        $validate = ChangedTextValidation::validate();

        if ($validate['status'] === 'error') {
            $this->sendError($validate['message']);
            return;
        }

        $db = Database::getInstance();
        $response = $db->changeFeedback($validate['data']['id'], $validate['data']['text']);

        $this->response($response,"Ошибка сохранения отзыва");
    }

    /**
     * @param $response
     * @param $errorMessage
     */
    private function response($response, $errorMessage)
    {
        if ($response){
            $result['success'] = true;
            echo json_encode($result);
        } else {
            $this->sendError($errorMessage);
        }
    }

    /**
     * @param string $message
     */
    private function sendError(string $message): void
    {
        $result['success'] = false;
        $result['error'] = $message;

        echo json_encode($result);
    }
}