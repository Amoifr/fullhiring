<?php

declare(strict_types=1);

namespace Fulll\Infra;

use Fulll\Infra\ErrorDTO\ErrorDTOInterface;

class ErrorStack
{
    private static ?ErrorStack $_instance = null;

    /**
     * @var ErrorDTOInterface[]
     */
    private array $errors = [];

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new ErrorStack();
        }

        return self::$_instance;
    }

    public function addError(ErrorDTOInterface $error): void
    {
        $this->errors[] = $error;
    }

    public function errorExists(ErrorDTOInterface $errorDTO): bool
    {
        $errors = array_filter(
            $this->errors,
            function ($error) use ($errorDTO) {
                return $this->errorsAreSimilar($error, $errorDTO);
            }
        );

        if (1 === count($errors)) {
            unset($this->errors[array_search($errors[0], $this->errors)]);

            return true;
        }

        return false;
    }

    private function errorsAreSimilar(ErrorDTOInterface $expectedError, ErrorDTOInterface $actualError): bool
    {
        foreach (get_object_vars($expectedError) as $key => $value) {
            if (is_object($expectedError->$key)) {
                if (!$this->errorsAreSimilar($expectedError->$key, $actualError->$key)) {
                    return false;
                }
            } else {
                if ($expectedError->$key !== $actualError->$key) {
                    return false;
                }
            }
        }

        return true;
    }
}
