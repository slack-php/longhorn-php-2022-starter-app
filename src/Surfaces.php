<?php

declare(strict_types=1);

namespace LonghornPhp\Magic8Ball;

use SlackPhp\BlockKit\Surfaces\AppHome;
use SlackPhp\BlockKit\Surfaces\Modal;

class Surfaces
{
    public static function askModal(): Modal
    {
        return Modal::new()
            ->title('Magic 8-Ball')
            ->callbackId('8ball-modal-ask')
            ->tap(function (Modal $modal) {
                $modal->newInput('question-form')
                    ->label('What is your question?')
                    ->newTextInput('question');
            })
            ->notifyOnClose(true)
            ->submit('Submit');
    }

    public static function answerModal(string $question, string $answer): Modal
    {
        return Modal::new()
            ->title('Magic 8-Ball')
            ->callbackId('8ball-modal-answer')
            ->encodePrivateMetadata(compact('question'))
            ->text("> {$question}\n{$answer}")
            ->tap(function (Modal $modal) {
                $modal->newActions('actions')
                    ->newButton('8ball-try-again')
                    ->text('Try Again');
            });
    }

    public static function chooseModal(): Modal
    {
        return Modal::new()
            ->title('Magic 8-Ball')
            ->callbackId('8ball-modal-ask')
            ->tap(function (Modal $modal) {
                $modal->newInput('question-form')
                    ->label('What is your question?')
                    ->newSelectMenu('choices')
                    ->forExternalOptions()
                    ->placeholder('Will I...?')
                    ->minQueryLength(0);
            })
            ->submit('Submit');
    }

    public static function appHome(string $user): AppHome
    {
        return AppHome::new()
            ->text(":wave: Hello, {$user}!")
            ->tap(function (AppHome $msg) {
                $msg->newActions('actions')
                    ->newButton('ask-question')
                    ->text('Ask a Question');
            });
    }
}
