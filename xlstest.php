<table>
    <thead>
        <tr>
            <th>Columna 1</th>
            <th>Columna 2</th>
            <th>Columna 3</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>dato 1.1</td>
            <td>dato 1.2</td>
            <td>dato 1.3</td>           
        </tr>
        <tr>
            <td>dato 2.1</td>
            <td>dato 2.2</td>
            <td>dato 2.3</td>           
        </tr>
        <tr>
            <td>dato 3.1</td>
            <td>dato 3.2</td>
            <td>dato 3.3</td>           
        </tr>
    </tbody>
</table>

<?php
$indicesServer = array('PHP_SELF',
    'argv',
    'argc',
    'GATEWAY_INTERFACE',
    'SERVER_ADDR',
    'SERVER_NAME',
    'SERVER_SOFTWARE',
    'SERVER_PROTOCOL',
    'REQUEST_METHOD',
    'REQUEST_TIME',
    'REQUEST_TIME_FLOAT',
    'QUERY_STRING',
    'DOCUMENT_ROOT',
    'HTTP_ACCEPT',
    'HTTP_ACCEPT_CHARSET',
    'HTTP_ACCEPT_ENCODING',
    'HTTP_ACCEPT_LANGUAGE',
    'HTTP_CONNECTION',
    'HTTP_HOST',
    'HTTP_REFERER',
    'HTTP_USER_AGENT',
    'HTTPS',
    'REMOTE_ADDR',
    'REMOTE_HOST',
    'REMOTE_PORT',
    'REMOTE_USER',
    'REDIRECT_REMOTE_USER',
    'SCRIPT_FILENAME',
    'SERVER_ADMIN',
    'SERVER_PORT',
    'SERVER_SIGNATURE',
    'PATH_TRANSLATED',
    'SCRIPT_NAME',
    'REQUEST_URI',
    'PHP_AUTH_DIGEST',
    'PHP_AUTH_USER',
    'PHP_AUTH_PW',
    'AUTH_TYPE',
    'PATH_INFO',
    'ORIG_PATH_INFO');

echo '<table cellpadding="10">';
foreach ($indicesServer as $arg) {
    if (isset($_SERVER[$arg])) {
        echo '<tr><td>' . $arg . '</td><td>' . $_SERVER[$arg] . '</td></tr>';
    } else {
        echo '<tr><td>' . $arg . '</td><td>-</td></tr>';
    }
}
echo '</table>';
?>
<?php

// folder to check
$dir = '/';

// get disk space free (in bytes)
$disk_free = disk_free_space($dir);

// get disk space total (in bytes)
$disk_total = disk_total_space($dir);

// calculate the disk space used (in bytes)
$disk_used = $disk_total - $disk_free;

// percentage of disk used
$disk_used_p = sprintf('%.2f',($disk_used / $disk_total) * 100);

// this function will convert bytes value to KB, MB, GB and TB
function convertSize( $bytes )
{
        $sizes = array( 'B', 'KB', 'MB', 'GB', 'TB' );
        for( $i = 0; $bytes >= 1024 && $i < ( count( $sizes ) -1 ); $bytes /= 1024, $i++ );
                return( round( $bytes, 2 ) . " " . $sizes[$i] );
}

// format the disk sizes using the function (B, KB, MB, GB and TB)
$disk_free = convertSize($disk_free);
$disk_used = convertSize($disk_used);
$disk_total = convertSize($disk_total);

echo '<ul>';
echo '<li>Total: '.$disk_total.'</li>';
echo '<li>Used: '.$disk_used.' ('.$disk_used_p.'%)</li>';
echo '<li>Free: '.$disk_free.'</li>';
echo '</ul>';

?>