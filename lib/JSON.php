<?php

/**
 * Project:     JSON: the PHP Object JSON implementation
 * File:        JSON:php
 * 
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 * 
 * For questions, help, comments, discussion, etc., please join the
 * Smarty mailing list. Send a blank e-mail to
 * smarty-discussion-subscribe@googlegroups.com
 * 
 * @link http://code.google.com/p/json-php/
 * @copyright 2010 NCDC Solutions.
 * @author Mario Uriarte Amaya <necudeco at gmail dot com> 
 * @author http://necudeco.org
 * @package JSON
 */

    function jsonEncode($obj)
    {
            if ( is_object($obj) )
            {
                    if ( method_exists($obj,'__toSleep'))
                    {
                            $obj = $obj->__toSleep();
                    }

                    return jsonEncode($obj);
            }

            if ( is_array($obj) )
            {
                    $response = array();
                    if ( count($obj) == 0 ) 
                            //return '[]';
                            return json_encode(array());
                    $barray = true;
                    $j = 0;
                    foreach( $obj as $k => $i)
                    {
                            $i = jsonEncode($i);
                            $response[$j] = "\"$k\":$i";

                            if ( is_numeric($k) && $j == intval($k) )
                            {
                                    $barray = false;
                                    $response[$j] = "$i";
                            }


                            $j++;
                    }
                    $response = join(',',$response);
                    if ( $barray == false )
                            return "[".$response."]";
                    else
                            return "{".$response."}";
            }

            return json_encode($obj);

    }

    function jsonDecode($str)
    {
            return json_decode($str);
    }
?>