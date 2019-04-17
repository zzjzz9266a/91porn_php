<?php
class Aria2
{
    protected $ch;
    protected $token;
    protected $batch = false;
    protected $batch_cmds = [];
    
    function __construct($server='http://127.0.0.1:6800/jsonrpc', $token=null)
    {
        $this->ch = curl_init($server);
        $this->token = $token;
        curl_setopt_array($this->ch, [
            CURLOPT_POST=>true,
            CURLOPT_RETURNTRANSFER=>true,
            CURLOPT_HEADER=>false
        ]);
    }
    
    function __destruct()
    {
        curl_close($this->ch);
    }
    
    protected function req($data)
    {
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);        
        return curl_exec($this->ch);
    }
    
    function batch($func=null)
    {
        $this->batch = true;
        if(is_callable($func)) {
            $func($this);
        }
        return $this;
    }
    
    function inBatch()
    {
        return $this->batch;
    }
    
    function commit()
    {
        $this->batch = false;
        $cmds = json_encode($this->batch_cmds);
        $result = $this->req($cmds);
        $this->batch_cmds = [];
        return $result;
    }
    
    function __call($name, $arg)
    {
        if(!is_null($this->token)) {
            array_unshift($arg, $this->token);
        }
        
        //Support system methods
        if(strpos($name, '_')===false) {
            $name = 'aria2.'.$name;
        } else {
            $name = str_replace('_', '.', $name);
        }
        
        $data = [
            'jsonrpc'=>'2.0',
            'id'=>'1',
            'method'=>$name,
            'params'=>$arg
        ];
        //Support batch requests
        if($this->batch) {
            $this->batch_cmds[] = $data;
            return $this;
        }
        $data = json_encode($data);
        $response = $this->req($data);
        if($response===false) {
            trigger_error(curl_error($this->ch));
        }
        return json_decode($response, 1);
    }
}