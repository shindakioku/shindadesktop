<?php

namespace App\Services\Response;

class ResponseApi implements ResponseContract
{
    /**
     * @var array
     */
    protected $errors = [
        'system' => [
            'system' => 500,
            'validation_error' => 12,
        ],
        'user' => [
            'incorrect_login' => 61,
            'incorrect_password' => 72,
            'favorite' => [
                'incorrect_entity_name' => 91,
                'incorrect_entity' => 93,
                'incorrect_user_id' => 13,
            ],
        ],
        'anime' => [
            'incorrect_name' => 51,
            'incorrect_id' => 52,
            'soundtracks' => [
                'incorrect_name' => 51,
                'incorrect_id' => 52,
            ],
        ],
        'company' => [
            'incorrect_name' => 51,
            'incorrect_id' => 52,
        ],
        'music' => [
            'incorrect_name' => 51,
            'incorrect_id' => 52,
        ],
        'group' => [
            'incorrect_name' => 51,
            'incorrect_id' => 52,
        ],
    ];

    /**
     * @var array
     */
    protected $data = [
        'error' => false,
    ];

    /**
     * @return ResponseContract
     */
    public function changeStatus(): ResponseContract
    {
        $this->data['error'] = true;

        return $this;
    }

    /**
     * @param string $key
     * @param $data
     * @return ResponseContract
     */
    public function add(string $key, $data): ResponseContract
    {
        $this->data[$key] = $data;

        return $this;
    }

    /**
     * @param string $errorCode
     * @return array
     */
    public function response(string $errorCode = ''): array
    {
        if (0 != strlen($errorCode)) {
            stristr($errorCode, '.') ? $this->addErrorInfoMulti($errorCode) : $this->addErrorInfoSingle($errorCode);
        }

        return $this->data;
    }

    /**
     * @param string $errorCode
     */
    private function addErrorInfoSingle(string $errorCode): void
    {
        $this->data['status'] = $this->errors[$errorCode];
    }

    /**
     * @param string $errorCode
     * @return int|null
     */
    private function addErrorInfoMulti(string $errorCode): ?int
    {
        $errorCode = explode('.', $errorCode);
        $key = array_shift($errorCode);
        $value = $this->errors[$key];

        if (!count($errorCode)) {
            return $value;
        }

        foreach ($errorCode as $k) {
            $value = $value[$k];
        }

        $this->data['status'] = $value;

        return null;
    }
}
