<?php 
class Qualtrics {
    
    public $user;
    public $basepath;
    public $format;
    public $token;
    public $version;
    protected $requestDefaults;
    
    public function __construct($user,$token,$format,$basepath,$version) {
        $this->user = $user;
        $this->token = $token;
        $this->basepath = $basepath;
        $this->format = $format;
        $this->version = $version;
        $this->requestDefaults = array('User' => $this->user,'Token' => $this->token,'Format' => $this->format ,'Version' => $this->version);
    }
    
    public function __call($name, $arguments) {
        return $this->request($name,$arguments);
    }      
        
    private function request($method,$params) {
        $method = array('Request' => $method);
        $params  = array_merge($this->requestDefaults,$params);
        $params  = array_merge($method,$params);
        $params = http_build_query($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->basepath);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
 
}
?>