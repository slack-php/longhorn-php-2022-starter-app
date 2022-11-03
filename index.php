<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use LonghornPhp\Magic8Ball\Ball;
use LonghornPhp\Magic8Ball\InvalidQuestion;
use Psr\Log\LogLevel;
use SlackPhp\Framework\App;
use SlackPhp\Framework\Context;
use SlackPhp\Framework\StderrLogger;

Dotenv::createUnsafeImmutable(__DIR__)->load();

$ball = new Ball();

App::new()
    ->withLogger(new StderrLogger(LogLevel::DEBUG))
    ->command('8ball', function (Context $ctx) use ($ball) {
        try {
            $question = $ctx->payload()->get('text');
            $answer = $ball->askOrThrow($question);
            $ctx->ack($answer);
        } catch (InvalidQuestion $e) {
            $ctx->ack($e->getMessage());
        }
    })
    ->run();
