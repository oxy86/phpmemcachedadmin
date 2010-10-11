<?php
/**
 * Copyright 2010 Cyrille Mahieux
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and limitations
 * under the License.
 *
 * ><)))°> ><)))°> ><)))°> ><)))°> ><)))°> ><)))°> ><)))°> ><)))°> ><)))°>
 *
 * Manipulation of HTML
 *
 * @author c.mahieux@of2m.fr
 * @since 05/04/2010
 */
class Library_HTML_Components
{
    /**
     * Dump server list in an HTML select
     *
     * @return string
     */
    public static function serverSelect($name, $selected = '', $class = '', $events = '')
    {
        # Loading ini file
        $_ini = Library_Configuration_Loader::singleton();

        # Select Name
        $serverList = '<select id="' . $name . '" ';

        # CSS Class
        $serverList .= ($class != '') ? 'class="' . $class . '"' : '';

        # Javascript Events
        $serverList .= ' ' . $events .'><option value="">All Servers</option>';

        foreach($_ini->get('servers') as $server)
        {
            # Option value and selected case
            $serverList .= '<option value="' . $server['hostname'] . ':' . $server['port'] . '" ';
            $serverList .= ($selected == $server['hostname'] . ':' . $server['port']) ? 'selected="selected"' : '';
            $serverList .= '>' . $server['hostname'] . ':' . $server['port'] . '</option>';
        }
        return $serverList . '</select>';
    }

    /**
     * Dump server response in proper formatting
     *
     * @param string $hostname Hostname
     * @param string $port Port
     * @param mixed $data Data (reponse)
     *
     * @return string
     */
    public static function serverResponse($hostname, $port, $data)
    {
        $header = '<span class="alert">Server ' . $hostname . ':' . $port . "</span>\r\n";
        $return = '';
        if(is_array($data))
        {
            foreach($data as $string)
            {
                $return .= $string . "\r\n";
            }
            return $header . htmlentities($return) . "\r\n";
        }
        return $header . $return . $data . "\r\n";
    }

    /**
     * Dump api list un HTML select with select name
     *
     * @param String $iniAPI API Name from ini file
     * @param String $id Select ID
     *
     * @return String
     */
    public static function apiList($iniAPI = '', $id)
    {
        return '<select class="commands" id="' . $id . '">
        <option value="Server" ' . self::selected('Server', $iniAPI) . '>Server API</option>
        <option value="Memcache" ' . self::selected('Memcache', $iniAPI) . '>Memcache API</option>
        <option value="Memcached" ' . self::selected('Memcached', $iniAPI) . '>Memcached API</option>
        </select>';
    }

    /**
     * Used to see if an option is selected
     *
     * @param String $actual Actual value
     * @param String $selected Selected value
     *
     * @return String
     */
    private static function selected($actual, $selected)
    {
        if($actual == $selected)
        {
            return 'selected="selected"';
        }
    }
}