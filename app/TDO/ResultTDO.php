<?php

namespace Graphicode\Standard\TDO;

use Illuminate\Support\Str;

class ResultTDO
{
    public function __construct(
        protected mixed $data = null,
        protected mixed $code = null
    ) {
    }

    public function data(): mixed 
    {
        return $this->data;
    }

    public function isError(): bool
    {
        return $this->code && $this->data == null
            ? true
            : false;    
    }

    public function errorMessage(): string
    {
        return __('messages.' . Str::lower($this->code->name));
    }

    public function errorCode(): int
    {
        return $this->code->value;
    }
}
