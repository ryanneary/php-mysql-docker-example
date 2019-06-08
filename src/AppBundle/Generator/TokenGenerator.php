<?php

namespace AppBundle\Generator;

use Exception;

class TokenGenerator
{
    /**
     * @param int $length
     * @return string
     * @throws Exception
     */
    public function generate($length = 64) {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $max = strlen($codeAlphabet);

        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max-1)];
        }

        return $token;
    }
}
