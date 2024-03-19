<?php

use Carbon\Carbon;

if (!function_exists('dob2age')) {
    function dob2age($dob) {
        return Carbon::parse($dob)->age;
    }
}

if (!function_exists('inches2height')) {
    function inches2height($num) {
        $num = (int) $num;
        $feet = floor($num/12);
        $inches = $num - ($feet * 12);
        return $feet."' ".$inches."\"";
    }
}

if (!function_exists('formatProfileFieldValue')) {    
    function formatProfileFieldValue($key, $value) {
        $results = null;               
        switch($key) {
            case "Age":  
                $results = dob2age($value) . " years old";                        
            break;
            case "Eye color":  
                $results = $value. " Eyes";                        
            break;
            case "Hair color":  
                $results = $value. " Hair";                        
            break;
            case "Height":  
                $results = inches2height($value);                        
            break;
            case "Looking for":  
                $results = "Looking for: ".$value;                        
            break;
            case "Education":  
                $results = "Education: ".$value;                        
            break;
            default:
                $results = $value;                        
            break;
        }
        return $results;
    } 
}

if (!function_exists('getProfileFieldValue')) {     
    function getProfileFieldValue($profile_data, $key) {        
        $value = null;
        foreach ($profile_data as $data) {
            if (isset($data->values)) {
                foreach($data->values as $k => $v) {
                    if ($v['title'] == $key) {
                        $value = formatProfileFieldValue($key, $v['value']);
                    }                    
                }
            }  
        }
        return $value;
    }
}

if (!function_exists('getProfileDescription')) {   
    function getProfileDescription($profile_data, $keys) {
        $line = [];
        foreach ($keys as $key) {
            $value = getProfileFieldValue($profile_data, $key);
            if (isset($value)) {
                array_push($line, $value);
            }
        }
        return implode(", ", $line);
    }
}

if (!function_exists('renderNotificationName')) {   
    function renderNotificationName($name) {
        $results = "";
        switch($name) {
            case 'viewed_profile';
                $results = "Viewed your profile"; 
            break;
            default:
                $results = $name;
            break;
        }
        return $results;
    }
}

if (!function_exists('getMediaType')) {   
    function getMediaType($media) {
        $type = null;
        if (isset($media)) {
            $mime_type = $media->mime_type;
            if (isset($mime_type)) {
                $results = explode("/", $mime_type);
                if (count($results)) {
                    $type = $results[0];
                }
            }
        }
        return $type;
    }
}
