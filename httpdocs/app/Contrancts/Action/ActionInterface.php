<?php

declare(strict_types = 1);

namespace App\Contrancts\Action;

interface ActionInterface
{
    /**
     * @return mixed
     */
    public function handle() : mixed;

    /**
     * @param ...$args
     *
     * @return mixed
     */
    public static function run(...$args) : mixed;
}
