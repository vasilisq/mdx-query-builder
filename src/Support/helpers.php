<?php

if (! function_exists('array_wrap')) {
    /**
     * Converts value into array, if it`s not array already
     *
     * @param mixed $value
     *
     * @return array
     */
    function array_wrap($value)
    {
        if (is_null($value)) {
            return [];
        }

        return !is_array($value) ? [$value] : $value;
    }
}