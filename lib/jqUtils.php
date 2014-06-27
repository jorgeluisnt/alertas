<?php 

class SimpleXMLExtended extends SimpleXMLElement {

    public function addCData($cdata_text) {
        $node = dom_import_simplexml($this);
        $no = $node->ownerDocument;
        $node->appendChild($no->createCDATASection($cdata_text));
    }

}

class jqGridUtils {

    public static function toXml($data, $rootNodeName = 'root', $xml=null, $encoding='utf-8', $cdata=false) {
        if (ini_get('zend.ze1_compatibility_mode') == 1) {
            ini_set('zend.ze1_compatibility_mode', 0);
        } if ($xml == null) {
            $xml = new SimpleXMLExtended("<?xml version='1.0' encoding='" . $encoding . "'?><$rootNodeName />");
        } foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                $key = "row";
            } if (is_array($value) || is_object($value)) {
                $node = $xml->addChild($key);
                self::toXml($value, $rootNodeName, $node, $encoding, $cdata);
            } else {
                $value = htmlspecialchars($value);
                if ($cdata === true) {
                    $node = $xml->addChild($key);
                    $node->addCData($value);
                } else {
                    $xml->addChild($key, $value);
                }
            }
        } return $xml->asXML();
    }

    public static function quote($js, $forUrl=false) {
        if ($forUrl)
            return strtr($js, array('%' => '%25', "\t" => '\t', "\n" => '\n', "\r" => '\r', '"' => '\"', '\'' => '\\\'', '\\' => '\\\\')); else
            return strtr($js, array("\t" => '\t', "\n" => '\n', "\r" => '\r', '"' => '\"', '\'' => '\\\'', '\\' => '\\\\', "'" => '\''));
    }

    public static function encode($value) {
        if (is_string($value)) {
            if (strpos($value, 'js:') === 0)
                return substr($value, 3); else
                return '"' . self::quote($value) . '"';
        } else if ($value === null)
            return "null"; else if (is_bool($value))
            return $value ? "true" : "false"; else if (is_integer($value))
            return "$value"; else if (is_float($value)) {
            if ($value === -INF)
                return 'Number.NEGATIVE_INFINITY'; else if ($value === INF)
                return 'Number.POSITIVE_INFINITY'; else
                return "$value";
        } else if (is_object($value))
            return self::encode(get_object_vars($value)); else if (is_array($value)) {
            $es = array();
            if (($n = count($value)) > 0 && array_keys($value) !== range(0, $n - 1)) {
                foreach ($value as $k => $v)
                    $es[] = '"' . self::quote($k) . '":' . self::encode($v); return "{" . implode(',', $es) . "}";
            } else {
                foreach ($value as $v)
                    $es[] = self::encode($v); return "[" . implode(',', $es) . "]";
            }
        } else
            return "";
    }

    public static function decode($json) {
        $comment = false;
        $out = '$x=';
        for ($i = 0; $i < strlen($json); $i++) {
            if (!$comment) {
                if ($json[$i] == '{')
                    $out .= ' array('; else if ($json[$i] == '}')
                    $out .= ')'; else if ($json[$i] == '[')
                    $out .= ' array('; else if ($json[$i] == ']')
                    $out .= ')'; else if ($json[$i] == ':')
                    $out .= '=>'; else
                    $out .= $json[$i];
            } else
                $out .= $json[$i]; if ($json[$i] == '"')
                $comment = !$comment;
        } eval($out . ';');
        return $x;
    }

    public static function Strip($value) {
        if (get_magic_quotes_gpc() != 0) {
            if (is_array($value))
                if (0 !== count(array_diff_key($value, array_keys(array_keys($value))))) {
                    foreach ($value as $k => $v)
                        $tmp_val[$k] = stripslashes($v); $value = $tmp_val;
                } else
                    for ($j = 0; $j < sizeof($value); $j++)
                        $value[$j] = stripslashes($value[$j]); else
                $value = stripslashes($value);
        } return $value;
    }

    public static function generatePattern($dateformat) {
        $k = 0;
        $datearray = preg_split("//", $dateformat);
        $patternkey = array();
        self::$patrVal = "";
        for ($i = 0; $i < count($datearray); $i++) {
            if (isset($datearray[$i - 1]) && $datearray[$i - 1] == "@") {
                $patternkey[$i] = $datearray[$i];
            } elseif ($datearray[$i] == "@") {
                $patternkey[$i] = "";
            } elseif ($datearray[$i] == " ") {
                $patternkey[$i] = "\040";
            } elseif (in_array($datearray[$i], array_keys(self::$types))) {
                $patternkey[$i] = self::$types[$datearray[$i]];
                self::$patrVal[$k] = array_search($datearray[$i], array_keys(self::$types));
                $k++;
            } else {
                $patternkey[$i] = $datearray[$i];
            }
        } $patternkey = implode("", $patternkey);
        return "/" . $patternkey . "/";
    }

    public static function date_parse($dateformat, $date) {
        $newdate = "";
        $dateformat = str_replace(array("\\", "\t", "/"), array("@", "@t", "~"), $dateformat);
        $date = str_replace("/", "~", $date);
        $pattern = self::generatePattern($dateformat);
        preg_match_all($pattern, $date, $newdate);
        $newdate = array_slice($newdate, 1);
        if (self::$patrVal[0] == 34) {
            $resultvar = array("Year" => $newdate[0], "Year" => $newdate[0][0], "Month" => $newdate[1][0], "Day" => $newdate[2][0], "Hour" => $newdate[3][0], "Minute" => $newdate[4][0], "Second" => $newdate[5][0], "Timezone" => $newdate[6][0] . $newdate[7][0] . $newdate[8][0]);
        } elseif (self::$patrVal[0] == 35) {
            $resultvar = array("Year" => $newdate[0], "Year" => $newdate[3][0], "Month" => (array_search($newdate[2][0], self::$month3) + 1), "Day" => $newdate[1][0], "Hour" => $newdate[4][0], "Minute" => $newdate[5][0], "Second" => $newdate[6][0], "Timezone" => $newdate[7][0]);
        } elseif (self::$patrVal[0] == 36) {
            $result = getdate(mktime($newdate));
            $resultvar = array("Year" => $result["year"], "Month" => array_search($result["month"], self::$month) + 1, "Day" => $result["mday"], "Hour" => $result["hours"], "Minute" => $result["minutes"], "Second" => $result["seconds"], "Timezone" => date("O"));
        } else {
            $labels = array_keys(self::$types);
            for ($i = 0; $i < count($newdate); $i++) {
                $result[$labels[self::$patrVal[$i]]] = $newdate[$i][0];
            } if (isset($result["F"]))
                $month = array_search($result["F"], self::$month) + 1; elseif (isset($result["M"]))
                $month = array_search($result["M"], self::$month3) + 1; elseif (isset($result["m"]))
                $month = $result["m"]; elseif (isset($result["n"]))
                $month = $result["n"]; else
                $month = 1; if (isset($result["d"]))
                $day = $result["d"]; elseif (isset($result["j"]))
                $day = $result["j"]; else
                $day = 1; if (isset($result["Y"]))
                $year = $result["Y"]; elseif (isset($result["o"]))
                $year = $result["o"]; elseif (isset($result["y"]))
                $year = ($result["y"] > substr(date("Y", time()), 2, 2)) ? (substr(date("Y", time()), 0, 2) - 1) . $result["y"] : substr(date("Y", time()), 0, 2) . $result["y"]; else
                $year = 1970; if (isset($result["l"]))
                $weekday = array_search($result["l"], self::$days) + 1; elseif (isset($result["D"]))
                $weekday = array_search($result["D"], self::$days3) + 1; elseif (isset($result["N"]))
                $weekday = $result["N"]; elseif (isset($result["w"]))
                $weekday = $result["w"]; else
                $weekday = date("w", mktime(0, 0, 0, $month, $day, $year)); if (isset($result["H"]))
                $hour = $result["H"]; elseif (isset($result["G"]))
                $hour = $result["G"]; elseif (isset($result["h"]))
                $hour = ($result["A"] == "PM" | $result["a"] == "pm") ? ($result["h"] + 12) : ($result["h"]); elseif (isset($result["g"]))
                $hour = ($result["A"] == "PM" | $result["a"] == "pm") ? ($result["g"] + 12) : ($result["g"]); else
                $hour = 0; if (isset($result["O"]))
                $timezone = $result["O"]; elseif (isset($result["Z"]))
                $timezone = ($result["Z"] / 3600); else
                $timezone = date("O"); $minutes = isset($result["i"]) ? $result["i"] : 0;
            $seconds = isset($result["s"]) ? $result["s"] : 0;
            $resultvar = array("Year" => $year, "Month" => $month, "Day" => $day, "WeekDay" => $weekday, "Hour" => $hour, "Minute" => $minutes, "Second" => $seconds, "Timezone" => $timezone);
        } return $resultvar;
    }

    public static function parseDate($patternFrom, $date, $patternTo='') {
        $temp = self::date_parse($patternFrom, $date);
        if ($patternTo)
            return date($patternTo, mktime($temp["Hour"], $temp["Minute"], $temp["Second"], $temp["Month"], $temp["Day"], $temp["Year"])); else
            return mktime($temp["Hour"], $temp["Minute"], $temp["Second"], $temp["Month"], $temp["Day"], $temp["Year"]);
    }

    public static function GetParam($parameter_name, $default_value = "") {
        $parameter_value = "";
        if (isset($_POST[$parameter_name]))
            $parameter_value = self::Strip($_POST[$parameter_name]); else if (isset($_GET[$parameter_name]))
            $parameter_value = self::Strip($_GET[$parameter_name]); else
            $parameter_value = $default_value; return $parameter_value;
    }

    public static function array_extend($a, $b) {
        foreach ($b as $k => $v) {
            if (is_array($v)) {
                if (!isset($a[$k])) {
                    $a[$k] = $v;
                } else {
                    $a[$k] = self::array_extend($a[$k], $v);
                }
            } else {
                $a[$k] = $v;
            }
        } return $a;
    }

    public static function phpTojsDate($phpdate) {
        $count = 0;
        $phpdate = str_replace('j', 'd', $phpdate, $count);
        $phpdate = $count == 0 ? str_replace('d', 'dd', $phpdate) : $phpdate;
        $phpdate = str_replace('z', 'o', $phpdate);
        $phpdate = str_replace('l', 'DD', $phpdate);
        $count = 0;
        $phpdate = str_replace('n', 'm', $phpdate, $count);
        $phpdate = $count == 0 ? str_replace('m', 'mm', $phpdate) : $phpdate;
        $phpdate = str_replace('F', 'MM', $phpdate);
        $phpdate = str_replace('Y', 'yy', $phpdate);
        return $phpdate;
    }

    public static function sprintfn($format, array $args = array()) {
        $arg_nums = array_slice(array_flip(array_keys(array(0 => 0) + $args)), 1);
        for ($pos = 0; preg_match('/(?<=%)([a-zA-Z_]\w*)(?=\$)/', $format, $match, PREG_OFFSET_CAPTURE, $pos);) {
            $arg_pos = $match[0][1];
            $arg_len = strlen($match[0][0]);
            $arg_key = $match[1][0];
            if (!array_key_exists($arg_key, $arg_nums)) {
                user_error("sprintfn(): Missing argument '${arg_key}'", E_USER_WARNING);
                return false;
            } $format = substr_replace($format, $replace = $arg_nums[$arg_key], $arg_pos, $arg_len);
            $pos = $arg_pos + strlen($replace);
        } return vsprintf($format, array_values($args));
    }

}

class Session {
    const SESSION_STARTED = TRUE;
    const SESSION_NOT_STARTED = FALSE;

    private $sessionState = self::SESSION_NOT_STARTED;
    private static $instance;

    private function __construct() {
        
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        } self::$instance->startSession();
        return self::$instance;
    }

    public function startSession() {
        if ($this->sessionState == self::SESSION_NOT_STARTED && session_id() == "") {
            $this->sessionState = session_start();
        } return $this->sessionState;
    }

    public function __set($name, $value) {
        $_SESSION[$name] = $value;
    }

    public function __get($name) {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
    }

    public function __isset($name) {
        return isset($_SESSION[$name]);
    }

    public function __unset($name) {
        unset($_SESSION[$name]);
    }

    public function destroy() {
        if ($this->sessionState == self::SESSION_STARTED) {
            $this->sessionState = !session_destroy();
            unset($_SESSION);
            return!$this->sessionState;
        } return FALSE;
    }

}

class Template {

    protected $file;
    protected $values = array();
    public $sanitize = true;

    public function __construct($file) {
        $this->file = $file;
    }

    public function set($key, $value) {
        $this->values[$key] = $value;
    }

    public function output($str_template='') {
        if ($str_template && strlen($str_template) > 0) {
            $output = $str_template;
        } else {
            if (!file_exists($this->file)) {
                return "Error loading template file ($this->file).<br />";
            } $output = file_get_contents($this->file);
        } foreach ($this->values as $key => $value) {
            $tagToReplace = "[@$key]";
            $output = str_replace($tagToReplace, $value, $output);
        } if ($this->sanitize)
            $output = preg_replace("/\[@(.+?)\]/", "", $output); return $output;
    }

    static public function merge($templates, $str_template = '', $separator = "\n") {
        $output = "";
        foreach ($templates as $template) {
            $content = (get_class($template) !== "Template") ? "Error, incorrect type - expected Template." : $template->output($str_template);
            $output .= $content . $separator;
        } return $output;
    }

} ?>
