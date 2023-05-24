<?php

declare(strict_types=1);

namespace Api\Response;

class HtmlResponse extends AbstractResponse
{
    protected array $headers = [
        'Content-type: text/html; charset=utf-8'
    ];

    public function getBody(): string
    {
        return $this->prettyPrint(json_decode(json_encode($this->body->jsonSerialize()) ?: '', true));
    }

    /**
     * @param mixed $array
     * @return string
     */
    private function prettyPrint($array): string
    {
        $string = '<ul>';
        if (is_array($array)) {
            foreach ($array as $key => $val) {
                if (is_array($val)) {
                    $string .= '<li>' . $key . ' => ' . $this->prettyPrint($val) . '</li>';
                } else {
                    $string .= '<li>' . $key . ' => ' . $val . '</li>';
                }
            }
        }
        $string .= '</ul>';
        return $string;
    }
}
