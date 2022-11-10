<?php /** @noinspection ALL */

namespace src\Controllers;

use Exception;
use src\DTO\FeedbackDTO;
use src\Exceptions\DatabaseException;
use src\Exceptions\FileCreateException;
use src\Exceptions\NotFoundException;
use src\Exceptions\ServiceException;
use src\Exceptions\ValidationException;
use src\Repositories\FeedbackRepository;
use src\Repositories\UserRepository;
use src\Services\FeedbackService;
use src\Services\UserService;
use src\Services\Validation\AcceptValidation;
use src\Services\Validation\ChangedTextValidation;
use src\Services\Validation\CredentialValidaton;
use src\Services\Validation\FormValidation;

/**
 * Class AjaxController
 * @package Controllers
 */
class AjaxController
{
    private FeedbackService $feedbackService;
    private UserService $userService;

    public function __construct()
    {
        $this->feedbackService = new FeedbackService(new FeedbackRepository());
        $this->userService = new UserService(new UserRepository());
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

        static::response($result, $message);
    }

    /**
     * @throws ServiceException
     * @throws ValidationException
     * @throws DatabaseException
     * @throws FileCreateException
     */
    private function sendFeedback()
    {
        $data = FormValidation::validate();
        $dto = FeedbackDTO::fromRequest($data);

        $this->feedbackService->create($dto);
    }

    /**
     * @throws ServiceException
     * @throws ValidationException
     */
    private function sendCredentials()
    {
        $data = CredentialValidaton::validate();

        $this->userService->sendCredentials($data['login'], $data['pass']);
    }

    /**
     * @throws ServiceException
     * @throws ValidationException
     */
    private function acceptFeedback()
    {
        $data = AcceptValidation::validate();

        $this->feedbackService->approve($data['id'], (bool) $data['accept']);
    }

    /**
     * @throws ServiceException
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
    private static function response(bool $isSuccess, string $errorMessage = '')
    {
        if ($isSuccess){
            $result['success'] = true;
            echo json_encode($result);
        } else {
            static::sendError($errorMessage);
        }
    }

    /**
     * @param string $message
     */
    private static function sendError(string $message): void
    {
        $result['success'] = false;
        $result['error'] = $message;

        echo json_encode($result);
    }
}