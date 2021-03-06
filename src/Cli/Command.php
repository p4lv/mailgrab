<?php declare(strict_types=1);

namespace PeeHaa\MailGrab\Cli;

use PeeHaa\MailGrab\Cli\Input\Argument;

class Command
{
    private $description;

    private $options;

    public function __construct(string $description, Option ...$options)
    {
        $this->description = $description;
        $this->options     = $options;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function isShortOption(string $key): bool
    {
        foreach ($this->options as $option) {
            if ($option->hasShort() && $option->getShort() === $key) {
                return true;
            }
        }

        return false;
    }

    public function isLongOption(string $key): bool
    {
        foreach ($this->options as $option) {
            if ($option->hasLong() && $option->getLong() === $key) {
                return true;
            }
        }

        return false;
    }

    public function isHelp(Argument ...$arguments): bool
    {
        foreach ($arguments as $argument) {
            if ($argument->isLong() && $argument->getKey() === 'help') {
                return true;
            }

            if (!$argument->isLong() && $argument->getKey() === 'h') {
                return true;
            }
        }

        return false;
    }

    public function isVersion(Argument ...$arguments): bool
    {
        foreach ($arguments as $argument) {
            if ($argument->isLong() && $argument->getKey() === 'version') {
                return true;
            }

            if (!$argument->isLong() && $argument->getKey() === 'v') {
                return true;
            }
        }

        return false;
    }

    public function getConfiguration(Argument ...$arguments): array
    {
        $configuration = [
            'hostname' => 'localhost',
            'ips'      => ['0.0.0.0', '[::]'],
            'port'     => 9000,
            'smtpport' => 9025,
        ];

        foreach ($arguments as $argument) {
            if ($argument->isLong() && $argument->getKey() === 'hostname') {
                $configuration['hostname'] = $argument->getValue();
            }

            if ($argument->isLong() && $argument->getKey() === 'ips') {
                $configuration['ips'] = array_map('trim', explode(',', $argument->getValue()));
            }

            if ($argument->isLong() && $argument->getKey() === 'port') {
                $configuration['port'] = (int) $argument->getValue();
            }

            if ($argument->isLong() && $argument->getKey() === 'smtpport') {
                $configuration['smtpport'] = (int) $argument->getValue();
            }
        }

        return $configuration;
    }
}
