<?php

if (!function_exists('formatPriceCOP')) {
    /**
     * Formatea un precio en pesos colombianos
     *
     * @param float $price
     * @return string
     */
    function formatPriceCOP(float $price): string
    {
        return '$' . number_format($price, 0, ',', '.') . ' COP';
    }
}

if (!function_exists('formatPriceCOPSimple')) {
    /**
     * Formatea un precio en pesos colombianos (solo símbolo y número)
     *
     * @param float $price
     * @return string
     */
    function formatPriceCOPSimple(float $price): string
    {
        return '$' . number_format($price, 0, ',', '.') . ' COP';
    }
}