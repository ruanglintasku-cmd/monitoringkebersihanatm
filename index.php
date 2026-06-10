<?php
/**
 * Root redirect: arahkan ke aplikasi di folder /public.
 * Menggunakan BASE_URL absolut agar tidak salah resolve.
 */
require_once __DIR__ . '/config/config.php';
header('Location: ' . rtrim(BASE_URL, '/') . '/login');
exit;
