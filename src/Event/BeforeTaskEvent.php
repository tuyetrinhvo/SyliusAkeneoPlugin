<?php

declare(strict_types=1);

namespace Synolia\SyliusAkeneoPlugin\Event;

class BeforeTaskEvent extends AbstractTaskEvent
{
    public const NAME = 'akeneo.before.task';
}
