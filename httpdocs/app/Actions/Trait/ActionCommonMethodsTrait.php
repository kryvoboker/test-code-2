<?php

declare(strict_types = 1);

namespace App\Actions\Trait;

use ArgumentCountError;

trait ActionCommonMethodsTrait
{
    /**
     * @param int $need_args_num
     * @param int $total_args
     *
     * @return void
     */
    protected function resolveCountArgsError(int $need_args_num, int $total_args) : void
    {
        throw new ArgumentCountError(
            __('default.error_count_args', [
                'expected' => $need_args_num,
                'got'      => $total_args
            ])
        );
    }
}
