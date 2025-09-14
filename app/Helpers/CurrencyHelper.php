<?php

if (!function_exists('formatCurrency')) {
    function formatCurrency($amount, $short = false) {
        if ($short) {
            if ($amount >= 1000000000) {
                return 'Rp ' . number_format($amount / 1000000000, 1) . 'M';
            } elseif ($amount >= 1000000) {
                return 'Rp ' . number_format($amount / 1000000, 1) . 'Jt';
            } elseif ($amount >= 1000) {
                return 'Rp ' . number_format($amount / 1000, 0) . 'K';
            }
            return 'Rp ' . number_format($amount, 0);
        }
        
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}