<?php

declare(strict_types=1);

namespace App\Model\Errors;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationErrorsToErrorListTransformer
{
    public function transformToErrorList(ConstraintViolationListInterface $errors): ErrorsList
    {
        $errorList = new ErrorsList();

        foreach ($errors as $error) {
            $errorList->addError(
                new Error(
                    $error->getMessage(),
                    null,
                    $error->getPropertyPath()
                )
            );
        }

        return $errorList;
    }
}
