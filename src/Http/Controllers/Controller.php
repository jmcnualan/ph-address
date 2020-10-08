<?php

namespace Dmn\PhAddress\Http\Controllers;

class Controller
{
    protected function getPerPage(): int
    {
        return request()->get(
            'per_page',
            config('ph_address.default_per_page')
        );
    }
}
