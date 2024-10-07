<?php

namespace App\TDO;

use App\Exceptions\TDOValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TDO
{
    /**
     * Initialize new TDO instance.
     */
    // public function __construct(
        protected $data;
    // ) {
    // }

    public function make($request)
    {

        $this->data = $request->validated();
        return $this;
    }


    /**
     * Access data values as proparty.
     */
    public function __get($name): mixed
    {
        return $this->data[$name] ?? null;
    }

    /**
     * GEt TDO as array
     */
    public function toArray(bool $asSnake = false): array
    {
        return $this->all($asSnake = false);
    }

    /**
     * Get all data as array.
     */
    public function all(bool $asSnake = false): array
    {
        if ($asSnake) {
            return $this->asSnake();
        }

        return $this->data;
    }

    public function get(string $key, ?callable $callback = null): mixed
    {
        $value = $this->only($key);

        if (!$value) {
            return null;
        }

        if ($callback) {
            return $callback($value);
        }

        return $value;
    }

    public function only($keys)
    {

        return data_get($this->data, $keys);
    }

    /**
     * Check key is exist.
     */
    public function has(string $key)
    {
        return isset($this->data[$key]);
    }

    /**
     * Transform data keys to camel case.
     */
    public function asSnake()
    {
        return collect($this->data)->reduce(function ($data, $value, $key) {
            $data[Str::snake($key)] = $value;
            return $data;
        }, []);
    }

    /**
     * Check on data in TDO.
     *
     * @param array $rules Array of validation rules.
     * @throws ?
     * @return array Return the validation data if not has an eexception
     */
    public function check(array $rules): array
    {
        // ? data to validate.
        $data = $this->data;

        // ? create custom validator opject
        $validator = Validator::make($data, $rules);

        //  ! throw an exception if has validation errror.
        if ($validator->fails()) {
            throw new TDOValidationException(
                message: "TDO Validation Error: " . $validator->errors()->first()
            );
        }

        //  * Return validated data from validatior.
        return  $validator->validated();
    }
}
