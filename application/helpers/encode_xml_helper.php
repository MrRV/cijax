<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter XML Encoding Helper
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Encoding
 * @author		Josh Campbell
 * @link		https://github.com/ajillion/CodeIgniter-jQuery-Ajax
 */

// ------------------------------------------------------------------------

/**
 * Convert an array to an XML string. Must be an associative aray, eg. ('my_data' => 'something', 'data' => '1/1/1970')
 *
 * @access public
 * @param array $array The array to be converted to an XML string.
 * @param integer $level The XML version. Default 1.0
 * @return string
 */
function array_to_xml($array, $level = 1)
{
	$xml = '';
	if ($level==1)
	{
		$xml .= '<?xml version="1.0" encoding="ISO-8859-1"?>' . "\n<array>\n";
    }
	foreach ($array as $key=>$value)
	{
		$key = strtolower($key);
        if (is_array($value))
		{
            $multi_tags = false;
            foreach($value as $key2=>$value2)
			{
                if (is_array($value2))
				{
                    $xml .= str_repeat("\t",$level)."<$key>\n";
                    $xml .= array_to_xml($value2, $level+1);
                    $xml .= str_repeat("\t",$level)."</$key>\n";
                    $multi_tags = true;
                }
				else
				{
                    if (trim($value2)!='')
					{
                        if (htmlspecialchars($value2)!=$value2)
						{
                            $xml .= str_repeat("\t",$level) . "<$key><![CDATA[$value2]]>" . "</$key>\n";
                        }
						else
						{
                            $xml .= str_repeat("\t",$level) . "<$key>$value2</$key>\n";
                        }
                    }
                    $multi_tags = true;
                }
            }
            if (!$multi_tags and count($value)>0)
			{
                $xml .= str_repeat("\t",$level)."<$key>\n";
                $xml .= array_to_xml($value, $level+1);
                $xml .= str_repeat("\t",$level)."</$key>\n";
            }
        }
		else
		{
            if (trim($value)!='')
			{
                if (htmlspecialchars($value)!=$value)
				{
                    $xml .= str_repeat("\t",$level) . "<$key>" . "<![CDATA[$value]]></$key>\n";
                }
				else
				{
                    $xml .= str_repeat("\t",$level) . "<$key>$value</$key>\n";
                }
            }
        }
	}
	if ($level==1)
	{
		$xml .= "</array>\n";
	}
	return $xml;
}

/* End of file encode_xml_helper.php */
/* Location: ./app/helpers/encode_xml_helper.php */