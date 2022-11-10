<?php

namespace src\Services;

use src\DTO\FeedbackDTO;
use src\Exceptions\DatabaseException;
use src\Exceptions\ServiceException;
use src\Helpers\UUID;
use src\Models\Author;
use src\Models\Feedback;
use src\Repositories\FeedbackRepositoryInterface;

/**
 * Class FeedbackService
 * @package src\Services
 */
class FeedbackService implements FeedbackServiceInterface
{
    public function __construct(FeedbackRepositoryInterface $feedbackRepository)
    {
        $this->repository = $feedbackRepository;
    }

    /**
     * @param FeedbackDTO $dto
     *
     * @throws ServiceException|DatabaseException
     */
    public function create(FeedbackDTO $dto)
    {
        $images = FileService::resizeImage();

        $image = $thumb = '';

        if (!empty($images)) {
            extract($images);
        }

        $author = new Author();
        $author->setName($dto->name);
        $author->setEmail($dto->email);

        $feedback = new Feedback();
        $feedback->setId(UUID::create('feedbacks'));
        $feedback->setText($dto->text);
        $feedback->setImage($image);
        $feedback->setThumb($thumb);
        $feedback->setAuthor($author);

        $result = $this->repository->add($feedback);

        if (!$result) {
            throw new ServiceException('Ошибка добавления отзыва');
        }
    }

    /**
     * @param int $id
     * @param string $text
     *
     * @throws ServiceException
     */
    public function saveChangedText(int $id, string $text)
    {
        $feedback = new Feedback();
        $feedback->setId($id);
        $feedback->setText($text);

        $result = $this->repository->changeText($feedback);

        if (!$result) {
            throw new ServiceException('Ошибка сохранения отзыва');
        }
    }

    /**
     * @param int $id
     * @param bool $accept
     *
     * @throws ServiceException
     */
    public function approve(int $id, bool $accept)
    {
        $feedback = new Feedback();
        $feedback->setId($id);
        $feedback->setAccept($accept);

        $result = $this->repository->changeStatus($feedback);

        if (!$result) {
            throw new ServiceException('Ошибка одобрения отзыва');
        }
    }

    public function get(string $mode = '') : array
    {
        if ($mode === 'admin') {
            return $this->repository->getAllforPanel();
        }

        $sort = $_GET['sort'] ?? 'byDate';
        return $this->repository->getAll($sort);
    }
}