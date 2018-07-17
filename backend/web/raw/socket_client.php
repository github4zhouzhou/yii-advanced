<?php


fs_send_message();


function stream_send_message()
{
    $fp = stream_socket_client('tcp://127.0.0.1:8000', $errno, $errstr);
    if (!$fp) {
        echo "erreur : $errno - $errstr<br />n";
    } else {
        fwrite($fp, "hello");
        $response = fread($fp, 128);
        var_dump($response);

        fclose($fp);
    }
}

function fs_send_message()
{
    $ret = 'error';
    //---- open socket
    $ptr = @fsockopen('127.0.0.1', 8000, $errno, $errstr, 15);
    //---- check connection
    if ($ptr) {
        //---- send request
        if (fputs($ptr, "Whello\nQUIT\n") != FALSE) {
            //---- clear default answer
            $ret = '';
            //---- receive answer
            while (!feof($ptr)) {
                $line = fgets($ptr, 128);
                if ($line == "end\r\n")
                    break;
                $ret .= $line;
            }
        }
        fclose($ptr);
    }
    //---- return answer
    echo 'fs:'.$ret;
}

