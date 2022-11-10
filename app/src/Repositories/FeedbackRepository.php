<?php

namespace src\Repositories;

use DateTime;
use src\Models\Feedback;

/**
 * Class FeedbackRepository
 * @package src\Repositories
 */
class FeedbackRepository extends Repository implements FeedbackRepositoryInterface
{
    public function getAll(string $type) : array
    {
        $types = ['byDate' => 'created', 'byAuthor' => 'authors.name', 'byEmail' => 'authors.email'];

        if (array_key_exists($type, $types)) {
            $sort = $types[$type];
        } else {
            $sort = 'created';
        }

        $result = $this->db->get('feedbacks', [
            'select' => [
                'id',
                'authors.email',
                'authors.name',
                'text',
                'image',
                'thumb',
                'DATE_FORMAT(feedbacks.created,"%d.%m.%Y") as "created"',
                'changed',
                'accept'
            ],
            'join' => [
                'table' => 'authors',
                'id' => 'author_id'
            ],
            'sort' => $sort,
            'filter' => [
                'accept' => 1
            ]
        ]);

        return $result;
    }

    public function getAllforPanel() : array
    {
        $result = $this->db->get('feedbacks');

        return $result;
    }

    public function add(Feedback $feedback): bool
    {
        $this->db->transactionBegin();

        $this->db->insertOrUpdate('authors', 'email', [
            'name' => $feedback->getAuthor()->getName(),
            'email' => $feedback->getAuthor()->getEmail()
        ]);

        $this->db->insert('feedbacks', [
            'text' => $feedback->getText(),
            'image' => $feedback->getImage(),
            'thumb' => $feedback->getThumb(),
            'author_id' => $this->db->getInsertId()
        ]);

        $this->db->transactionCommit();

        return $this->db->isSuccess();
    }

    public function changeText(Feedback $feedback): bool
    {
        $this->db->update('feedbacks', [
            'id' => $feedback->getId(),
            'text' => $feedback->getText(),
            'changed' => (new DateTime())->format('Y-m-d H:i:s')
        ]);

        return $this->db->isSuccess();
    }

    public function changeStatus(Feedback $feedback): bool
    {
        $this->db->update('feedbacks', [
            'id' => $feedback->getId(),
            'accept' => $feedback->getAccept()
        ]);

        return $this->db->isSuccess();
    }
}