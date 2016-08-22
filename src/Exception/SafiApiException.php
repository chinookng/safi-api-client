<?php

namespace Chinookng\SafiApi\Exception;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class SafiApiException extends \Exception
{
    protected $errorMessage;
    protected $errorCode;
    protected $validationErrors = [];

    public function __construct($message, $code)
    {
        $this->errorCode = $code;
        $this->errorMessage = $message;
        $this->build();
        parent::__construct($this->errorMessage);
    }

    public static function clientException(ClientException $e)
    {
        $message = $e->getMessage();
        $errorCode = 'unknown_error';

        if ($e->hasResponse()) {
            $json = \GuzzleHttp\json_decode($e->getResponse()->getBody());
            if (isset($json->error_description)) {
                $message = $json->error_description;
            } else {
                if (isset($json->error) && is_object($json->error)) {
                    $errorCode = $json->error->id;
                    $message = $json->error->details;
                }
            }
        }

        return new static($message, $errorCode, $e->getPrevious());
    }

    public static function serverException(ServerException $e)
    {
        dd($e);
    }

    public static function runtimeException($message)
    {
        return new static($message, 0);
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * Checks if there are validation errors in the api response
     * @return int
     */
    public function hasValidationErrors()
    {
        return count($this->validationErrors);
    }

    /**
     * gets all validation errors
     * @return array
     */
    public function getValidationErrors()
    {
        return $this->validationErrors;
    }

    public function authorizationFailure()
    {
        return preg_match('/(Access\ token\ provided\ has\ expired)/', $this->message);
    }

    protected function build()
    {
        if ($this->errorCode == 'validation_error') {
            $this->validationErrors = $this->errorMessage;
            $this->errorMessage = 'Validation error';
        } else {
            if (is_array($this->errorMessage) || is_object($this->errorMessage)) {
                $this->errorMessage = array_first($this->errorMessage);
                if (is_array($this->errorMessage)) {
                    $this->errorMessage = array_first($this->errorMessage);
                }
            }
        }
    }
}
