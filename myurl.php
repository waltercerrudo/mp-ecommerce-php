<?php
class myUrl
{
    var $protocol;
    var $site;
    var $thisfile;
    var $real_directories;
    var $num_of_real_directories;
    var $virtual_directories = array();
    var $num_of_virtual_directories = array();
    var $baseurl;
    var $thisurl;
    function myUrl()
    {
        $this->protocol = (isset($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == "on") ? 'https' : 'http';
        $this->site = $this->protocol . '://' . $_SERVER['HTTP_HOST'];
        $this->thisfile = basename($_SERVER['SCRIPT_FILENAME']);
        $this->real_directories = $this->cleanUp(explode("/", str_replace($this->thisfile, "", $_SERVER['PHP_SELF'])));
        $this->num_of_real_directories = count($this->real_directories);
        $this->virtual_directories = array_diff($this->cleanUp(explode("/", str_replace($this->thisfile, "", $_SERVER['REQUEST_URI']))) , $this->real_directories);
        $this->num_of_virtual_directories = count($this->virtual_directories);
        $this->baseurl = $this->site . "/" . implode("/", $this->real_directories);
        $this->thisurl = $this->baseurl . implode("/", $this->virtual_directories);
        if (strcmp(substr($this->thisurl, -1) , "/") != 0) $this->thisurl = $this->thisurl . "/";
        if (strcmp(substr($this->baseurl, -1) , "/") != 0) $this->baseurl = $this->baseurl . "/";
    }
    
    function cleanUp($array)
    {
        $cleaned_array = array();
        foreach ($array as $key => $value)
        {
            $qpos = strpos($value, "?");
            if ($qpos !== false)
            {
                break;
            }
            if ($key != "" && $value != "")
            {
                $cleaned_array[] = $value;
            }
        }
        return $cleaned_array;
    }
}
