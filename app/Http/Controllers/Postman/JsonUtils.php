<?php

namespace App\Http\Controllers\Postman;

use App\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class JsonUtils
{

 static function prettyJson($jsonString)
        {
            if (!$jsonString) {
                return '';
            }

            // Decode JSON, if invalid return original string
            $data = json_decode($jsonString, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return htmlentities($jsonString);
            }

            // Recursive function to build HTML with colors
            $buildHtml = function ($data, $indent = 0) use (&$buildHtml) {
                $html = '';
                $space = str_repeat('&nbsp;', $indent * 4);

                if (is_array($data)) {
                    $isAssoc = array_keys($data) !== range(0, count($data) - 1);
                    if ($isAssoc) {
                        $html .= '{<br>';
                        foreach ($data as $key => $value) {
                            $html .= $space . '&nbsp;&nbsp;';
                            $html .= '<span class="text-pink-600">"' . htmlentities($key) . '"</span>: ';
                            if (is_array($value)) {
                                $html .= $buildHtml($value, $indent + 1);
                            } elseif (is_bool($value)) {
                                $html .=
                                    '<span class="text-purple-600 font-semibold">' .
                                    ($value ? 'true' : 'false') .
                                    '</span>';
                            } elseif (is_null($value)) {
                                $html .= '<span class="text-gray-500 italic">null</span>';
                            } elseif (is_numeric($value)) {
                                $html .= '<span class="text-blue-600">' . htmlentities($value) . '</span>';
                            } else {
                                $html .= '<span class="text-green-600">"' . htmlentities($value) . '"</span>';
                            }
                            $html .= ',<br>';
                        }
                        $html .= $space . '}';
                    } else {
                        // Indexed array
                        $html .= '[<br>';
                        foreach ($data as $value) {
                            $html .= $space . '&nbsp;&nbsp;';
                            if (is_array($value)) {
                                $html .= $buildHtml($value, $indent + 1);
                            } elseif (is_bool($value)) {
                                $html .=
                                    '<span class="text-purple-600 font-semibold">' .
                                    ($value ? 'true' : 'false') .
                                    '</span>';
                            } elseif (is_null($value)) {
                                $html .= '<span class="text-gray-500 italic">null</span>';
                            } elseif (is_numeric($value)) {
                                $html .= '<span class="text-blue-600">' . htmlentities($value) . '</span>';
                            } else {
                                $html .= '<span class="text-green-600">"' . htmlentities($value) . '"</span>';
                            }
                            $html .= ',<br>';
                        }
                        $html .= $space . ']';
                    }
                } else {
                    // Scalar fallback
                    $html .= htmlentities($data);
                }

                return $html;
            };

            return $buildHtml($data);
        }

    }
