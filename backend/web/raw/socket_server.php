<?php


function ss_server()
{
    $socket = stream_socket_server("tcp://0.0.0.0:8000", $errno, $errstr);

    if (!$socket) {
        echo "$errstr ($errno)<br />\n";
    } else {
        while ($conn = stream_socket_accept($socket)) {
            fwrite($conn, 'The local time is ' . date('n/j/Y g:i a') . "\n");
            fclose($conn);
        }
        fclose($socket);
    }
}

// UDP
//$socket = stream_socket_server("udp://127.0.0.1:1113", $errno, $errstr, STREAM_SERVER_BIND);
//if (!$socket) {
//    die("$errstr ($errno)");
//}
//
//do {
//    $pkt = stream_socket_recvfrom($socket, 1, 0, $peer);
//    echo "$peer\n";
//    stream_socket_sendto($socket, date("D M j H:i:s Y\r\n"), 0, $peer);
//} while ($pkt !== false);


