<?php

declare(strict_types=1);

namespace LonghornPhp\Magic8Ball;

class Ball
{
    private const QUESTION_PREFIXES = [
        'am',
        'are',
        'is',
        'will',
        'were',
        'was',
        'do',
        'does',
        'did',
        'have',
        'has',
        'can',
        'could',
        'should',
        'may',
    ];

    private const ANSWER_BANK = [
        'As I see it, yes.',
        'Ask again later.',
        'Better not tell you now.',
        'Cannot predict now.',
        'Concentrate and ask again.',
        'Don’t count on it.',
        'It is certain.',
        'It is decidedly so.',
        'Most likely.',
        'My reply is no.',
        'My sources say no.',
        'Outlook not so good.',
        'Outlook good.',
        'Reply hazy, try again.',
        'Signs point to yes.',
        'Very doubtful.',
        'Without a doubt.',
        'Yes.',
        'Yes – definitely.',
        'You may rely on it.',
    ];

    public function ask(?string $question): string
    {
        try {
            return $this->askOrThrow($question);
        } catch (InvalidQuestion $e) {
            return "Error: {$e->getMessage()}";
        }
    }

    public function askOrThrow(?string $question): string
    {
        if (empty($question)) {
            throw new InvalidQuestion('Your question must not be blank.');
        }

        if (substr($question, -1) !== '?') {
            throw new InvalidQuestion('Your question must end in a question mark (?).');
        }

        $firstWord = explode(' ', strtolower($question), 2)[0];
        if (!in_array($firstWord, self::QUESTION_PREFIXES, true)) {
            throw new InvalidQuestion('Your question must be in yes-or-no format.');
        }

        return self::ANSWER_BANK[array_rand(self::ANSWER_BANK)];
    }
}
