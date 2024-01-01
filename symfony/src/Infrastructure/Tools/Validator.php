<?php

namespace Infrastructure\Tools;

class Validator
{
    public function __construct(
        private array $errors = array(),
        private bool $valid = true
    )
    {  
    }

    public function isValid(): bool { return $this->valid; }
    public function getErrors(): array { return $this->errors; }

    private function addError(string $msg): void
    {
        $this->valid = false;
        array_push($this->errors, $msg);
    }

    public function fieldIsNull(string $field, $value): bool
    {
        if(Assertion::isNull($value)) return true;
        
        $this->addError("Le champ '$field' contient une valeur alors qu'une valeur null était attendue.");
        return false;
    }

    public function fieldNotNull(string $field, $value): bool
    {
        if(Assertion::notNull($value)) return true;

        $this->addError("Le champ '$field' est vide alors qu'une valeur était attendue.");
        return false;
    }

    public function fieldLenghtLessThan(string $field, string $value, int $limit): bool
    {

        if(Assertion::lessThan(strlen($value), $limit)) return true;

        $this->addError("La longueur de la valeur du champ '$field' doit-être inférieur à $limit.");
        return false;
    }

    public function fieldLenghtGreaterThan(string $field, string $value, int $limit): bool
    {
        if(Assertion::greaterThan(strlen($value), $limit)) return true;

        $this->addError("La longueur de la valeur du champ '$field' doit-être supérieur à $limit.");
        return false;
    }

    public function fieldLessThan(string $field, float|int $value, float|int $limit): bool
    {
        if(Assertion::lessThan($value, $limit)) return true;

        $this->addError("La valeur du champ '$field' doit-être inférieur à $limit.");
        return false;
    }

    public function fieldGreaterThan(string $field, float|int $value, float|int $limit): bool
    {
        if(Assertion::greaterThan($value, $limit)) return true;

        $this->addError("La valeur du champ '$field' doit-être supérieur à $limit.");
        return false;
    }

    public function fieldIsString(string $field, $value): bool
    {
        if(Assertion::isString($value)) return true;

        $this->addError("Le type du champ '$field' doit-être un string.");
        return false;
    }
}