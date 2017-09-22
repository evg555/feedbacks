<?php

namespace app\controllers;


use app\models\Database;

class AjaxController
{
    //Параметры сохранения изображений
    private $_resolution_width = 320;
    private $_resolution_height = 240;
    private $_resolution_thimb_width = 60;
    private $_resolution_thumb_height = 60;

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

        if (isset($_FILES['file'])){
            if ($_FILES['file']['error']){
                $errorMessage = "Ошибка загрузки файла";
            }

            //Валидация формата загруженного файла
            $formats = [
                "image/jpeg",
                "image/png",
                "image/gif"
            ];

            if (!in_array($_FILES['file']['type'],$formats)){
                $errorMessage = "Ошибка отправки формы: некорректный формат изображения";
            }

            $image = $this->resize($_FILES['file'],$this->_resolution_width,$this->_resolution_height);

            $_FILES['file']['name'] = str_replace(".","_thumb.",$_FILES['file']['name']);
            $thumb = $this->resize($_FILES['file'],$this->_resolution_thimb_width,$this->_resolution_thumb_height);

        }

        if ($errorMessage){
            $result['success'] = false;
            $result['error'] = $errorMessage;
        } else {
            $db = Database::getInstance();
            $response = $db->addFeedback($name,$email,$text, $image,$thumb);

            $result = $this->response($response,"Ошибка добавления отзыва! Обратитесь в техническую поддержку!");
        }

        echo json_encode($result);
    }

    /*
     * Обработка формы авторизации
     */
    private function sendCredentials(){
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

    /*
     * Обрезает загружаемое изображение
     * @param array $file
     * @param int $width,$height
     * @return string
     */
    private function resize($file,$width,$height){
        //Создаем новый файл в зависимости от типа
        switch ($file['type']){
            case 'image/jpeg':
                $source = imagecreatefromjpeg ($file['tmp_name']);
                break;
            case 'image/png':
                $source = imagecreatefrompng ($file['tmp_name']);
                break;
            case 'image/gif':
                $source = imagecreatefromgif ($file['tmp_name']);
                break;

        }

        //Проверяем ширину и высоту, нужно ли обрезание
        $w_src = imagesx($source);
        $h_src = imagesy($source);

        if ($w_src > $width || $h_src > $height) {
            //Уменьшаем пропорционально ширине или высоте
            if ($w_src > $h_src){
                $ratio = $w_src/$width;
                $w_dest = $width;
                $h_dest = round($h_src/$ratio);
            } else {
                $ratio = $h_src/$height;
                $w_dest = round($w_src/$ratio);
                $h_dest = $height;
            }

            $dest = imagecreatetruecolor($w_dest, $h_dest);

            imagecopyresampled($dest, $source, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);
            imagejpeg($dest, TEMPLATE_DIR . "/files/" . $file['name']);
            imagedestroy($dest);
            imagedestroy($source);
        } else {
            imagejpeg($source, TEMPLATE_DIR . "/files/" . $file['name']);
            imagedestroy($source);
        }

        return $file['name'];
    }

    private function acceptFeedback(){
        if (isset($_POST['id']) && is_numeric($_POST['id'])){
            $id = $_POST['id'];
        } else {
            $errorMessage = "Ошибка одобрения отзыва. Обратитесь в техническую поддержку!";
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

        $result = $this->response($response,"Ошибка одобрения отзыва. Обратитесь в техническую поддержку!");

        echo json_encode($result);
    }

    /*
     * Сохраняет измененный отчет
     *
     */
    private function saveChangedText(){
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

        $result = $this->response($response,"Ошибка сохранения отзыва. Обратитесь в техническую поддержку!");

        echo json_encode($result);
    }

    /*
     * Обработка результата запроса к БД
     * @param boolean $response
     * @param string  $errorMessage
     * return array
     */
    private function response($response, $errorMessage){
        if ($response){
            $result['success'] = true;
        } else {
            $result['success'] = false;
            $result['error'] = $errorMessage;
        }

        return $result;
    }
}