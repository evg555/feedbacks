<?php

use src\Repositories\FeedbackRepository;
use src\Repositories\FeedbackRepositoryInterface;
use src\Repositories\UserRepository;
use src\Repositories\UserRepositoryInterface;
use src\Services\FeedbackService;
use src\Services\FeedbackServiceInterface;
use src\Services\UserService;
use src\Services\UserServiceInterface;
use src\Stores\MySql\MySqlStore;
use src\Stores\StoreInterface;

const MYSQL_HOST = 'mysql';
const MYSQL_PORT = 3306;
const MYSQL_LOGIN = 'feedback';
const MYSQL_PASS = 'feedback_test';
const MYSQL_DB ='feedbacks';

const TEMPLATE_DIR = 'templates/';

const BINDINGS = [
    StoreInterface::class => MySqlStore::class,
    FeedbackRepositoryInterface::class => FeedbackRepository::class,
    UserRepositoryInterface::class => UserRepository::class,
    FeedbackServiceInterface::class => FeedbackService::class,
    UserServiceInterface::class => UserService::class,
];
