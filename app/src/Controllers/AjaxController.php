<?php

namespace src\Controllers;

use Exception;
use src\DTO\FeedbackDTO;
use src\Exceptions\NotFoundException;
use src\Exceptions\ValidationException;
use src\Services\FeedbackServiceInterface;
use src\Services\UserServiceInterface;
use src\Services\Validation\AcceptValidation;
use src\Services\Validation\ChangedTextValidation;
use src\Services\Validation\CredentialValidaton;
use src\Services\Validation\FormValidation;

/**
 * Class AjaxController
 * @package Controllers
 */
class AjaxController extends BaseControler
{
    private FeedbackServiceInterface $feedbackService;
    private UserServiceInterface $userService;

    public function __construct(FeedbackServiceInterface $feedbackService, UserServiceInterface $userService)
    {
        $this->feedbackService = $feedbackService;
        $this->userService = $userService;
    }

    public function index()
    {
        $action = $_POST['action'] ?? false;

        $result = true;
        $message = '';

        try {
            if (method_exists($this, $action)){
                $this->$action();
            } else {
                throw new NotFoundException('Ошибка отправки формы: не существует метода для обработки формы');
            }
        } catch (Exception $exception) {
            $result = false;
            $message = $exception->getMessage();
        }

        $this->response($result, $message);

        parent::index();
    }

    /**
     * @throws ValidationException
     */
    private function sendFeedback()
    {
        $data = FormValidation::validate();
        $dto = FeedbackDTO::fromRequest($data);

        $this->feedbackService->create($dto);
    }

    /**
     * @throws ValidationException
     */
    private function sendCredentials()
    {
        $data = CredentialValidaton::validate();

        $this->userService->sendCredentials($data['login'], $data['pass']);
    }

    /**
     * @throws ValidationException
     */
    private function acceptFeedback()
    {
        $data = AcceptValidation::validate();

        $this->feedbackService->approve($data['id'], (bool) $data['accept']);
    }

    /**
     * @throws ValidationException
     */
    private function saveChangedText()
    {
        $data = ChangedTextValidation::validate();

        $this->feedbackService->saveChangedText($data['id'], $data['text']);
    }

    /**
     * @param bool $isSuccess
     * @param string $errorMessage
     */
    private function response(bool $isSuccess, string $errorMessage = '')
    {
        if ($isSuccess){
            $result['success'] = true;
            $this->data = $result;
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

        $this->data = $result;
    }

    protected function render()
    {
        echo json_encode($this->data);
    }
}