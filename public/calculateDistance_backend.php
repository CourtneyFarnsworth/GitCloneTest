<?php

//todo: set up API call to get City, State

function CallAPI($method, $url, $data = false){
    $curl = curl_init();

    switch ($method){
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);
    curl_close($curl);

    return $result;
}

/* This function works but takes forever!!! */

// function getDistance($zip1, $zip2){
// /* Call to API */
// $result = CallAPI("GET", "http://www.postcodez.com/api/distance/$zip1/$zip2/api.xml");

// /* Clean up results */
// $xml = simplexml_load_string($result);
// $json = json_encode($xml);
// $json = str_replace('}','',$json);
// $json = str_replace('{','',$json);
// $json = explode(":", $json);
// $json = explode(",", $json[9]);
// $json = str_replace('"','',$json[0]);

// return round($json);

// }

/* This function is fast but sometimes incorrect!!! */
function getDistance($zip1, $zip2){
    /* Call to API */
    $result = CallAPI("GET", "https://www.zipcodeapi.com/rest/RnkdUQtQlOT1bvcKi3L3KjXlGvyincVlaTwgadfOsBc7GT14TLQ4Cgp34kfbnLcm/distance.json/$zip1/$zip2/mile");
    
    $json = explode(":", $result);
    $json = str_replace('}','',$json[1]);
    
    return round($json);
}
function getLongAndLat($zip){
    $result = CallAPI("GET", "https://www.zipcodeapi.com/rest/aQxAxPH5K3Xsn7rKUu0n0AK68afiy2doGMujkxNIjarOXKYjb1hZiYyfBIyLooyw/info.json/$zip/degrees");
    
    $json = explode(",", $result);

    $lat = explode(":", $json[1]);
    $lat = str_replace(',','',$lat[1]);

    $long = explode(":", $json[2]);
    $long = str_replace(',','',$long[1]);

    $city = explode(":", $json[3]);
    $city = str_replace(',','',$city[1]);
    $city = str_replace('"','',$city);


    $state = explode(":", $json[4]);
    $state = str_replace(',','',$state[1]);
    $state = str_replace('"','',$state);

    $array[] = array();
    
    $array["lat"] = $lat;
    $array["long"] = $long;
    $array["city"] = $city;
    $array["state"] = $state;

    return $array;
}

?>