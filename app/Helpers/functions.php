<?php

if (!function_exists('escapeString')) {
    /**
     * Escapa uma string para exibição segura no HTML (proteção contra XSS)
     *
     * @param string $value
     * @return string
     */
    function escapeString(?string $value): string
    {
        if ($value) {
            return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        return '';
    }
}

if (!function_exists('dd')) {
    /**
     * Dump and Die (debug rápido)
     *
     * @param mixed ...$vars
     * @return void
     */
    function dd(...$vars): void
    {
        echo '<pre>';
        foreach ($vars as $var) {
            print_r($var);
        }
        echo '</pre>';
        exit;
    }
}

if (!function_exists('sanitizeOrderBy')) {
    /**
     * Garante que o campo informado é permitido no ORDER BY
     *
     * Uso: $orderBy = sanitizeOrderBy($_GET['order'] ?? 'name', ['id', 'name', 'email'], 'id');
     *
     * @param string $field
     * @param array $allowed
     * @param string $default
     * @return string
     */
    function sanitizeOrderBy(string $field, array $allowed, string $default = 'id'): string
    {
        return in_array($field, $allowed) ? $field : $default;
    }
}

if (!function_exists('sanitizeDirection')) {

    /**
     * Garante que a direção do order by seja segura para execução
     *
     * Uso: $direction = sanitizeDirection($_GET['direction'] ?? 'asc');
     *
     * @param string $direction
     * @return string
     */
    function sanitizeDirection(string $direction): string
    {
        return strtolower($direction) === 'desc' ? 'DESC' : 'ASC';
    }

}

if (!function_exists('getDeviceName')) {
    /**
     * Retorna uma string legível com base no User-Agent
     *
     * @return string
     */
    function getDeviceName(): string
    {
        $agent = $_SERVER['HTTP_USER_AGENT'] ?? '';

        $map = [
            'insomnia' => 'Insomnia',
            'postman' => 'Postman',
            'android' => 'Android',
            'iphone' => 'iPhone',
            'ipad' => 'iPad',
            'windows' => 'Windows',
            'macintosh' => 'macOS',
            'linux' => 'Linux',
            'mobile' => 'Mobile',
        ];

        foreach ($map as $key => $name) {
            if (stripos($agent, $key) !== false) {
                return $name;
            }
        }

        return 'unknown';
    }
}

if (!function_exists('isValidDate')) {
    /**
     * Verifica se o valor informado é uma data válida
     * @param string $date
     * @param string $format
     * @return bool
     */
    function isValidDate(string $date, string $format = 'Y-m-d'): bool
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}

if (!function_exists('dateFormat')) {

    /**
     * Formata uma data
     * @param string $date
     * @param string $format
     * @return string
     * @throws DateMalformedStringException
     */
    function dateFormat(string $date, string $format = 'Y-m-d'): string
    {
        try {
            $d = new \DateTime($date);
            return $d->format($format);
        } catch (\Exception) {
            return '';
        }
    }

}
