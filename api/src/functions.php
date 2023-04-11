<?php

class CallToAction{
    
    /**
     * php function to convert csv to json format
     * @param $filePath
     */ 
    function csvToJson($filePath) {
        echo 'Inside csvToJson...';
        // open csv file
        try {
            echo '<br>inside try block..';
            $fp = fopen($filePath, 'r');
        }
        catch(Exception $e){
            echo '<br>inside catch block..';
            echo $e.getMessage();
            die("Can't open file...");
        }
        
        //read csv headers
        echo '<br>reading csv...';
        $key = fgetcsv($fp,"10000",",");
        
        // parse csv rows into array
        $json = array();
        $index=0;
        while ($row = fgetcsv($fp,"10000",",")) {
            $json[] = array_combine($key, $row);
            $index++;
        }
        
        // release file handle
        fclose($fp);

        /*for($i=0;$i<count($json);$i++){
                echo '<br>Value= '.json_encode($json[$i]); 
        }*/
        
        // encode array to json
        return json_encode($json);
    }

    /**
     * Pass the REST API URL and get the json ecoded values 
     * @param $url
     * @usage -- $getValues=json_decode(httpGet("http://url.com"));
     */
    function httpGet($url){
        $ch = curl_init(str_replace(' ','%20',$url));  
    
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    
        $result=curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * Pass the url and json encoded payload to call the POST API
     * @param $url (POST URL) -- $url = 'http://localhost/tsplogic/resources/destinations/add';
     * @param $payload (json encoded) -- e.g. $payload=json_encode(array_combine($key, $row),true);
     */
    function httpPost($url,$payload){
        $ch = curl_init(str_replace(' ','%20',$url));
                                                 
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute the POST request
        $result = curl_exec($ch);
    
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpcode;
    }

    public function httpPatch($url, $payload){
		$ch = curl_init(str_replace(' ','%20',$url));                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");                                                                  
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));    
        
        $result = curl_exec($ch);
        
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpcode;
	}

	public function httpDelete($url){

		$ch = curl_init(str_replace(' ','%20',$url));                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");                                                                   
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));   
        
        $result = curl_exec($ch);
        
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpcode;
	}


    /**
     * Pass the REST API URL and get the json ecoded values 
     * Pass the basic auth
     * @param $url
     * @param $auth -- base64 encoded 
     * @usage -- $getValues=json_decode(httpGet("http://url.com"));
     */
    function httpGetWithAuth($url,$auth){
        $ch = curl_init(str_replace(' ','%20',$url));  
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '. $auth));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        // curl_setopt($ch,CURLOPT_HEADER, false); 
    
        $result=curl_exec($ch);
    
        curl_close($ch);
        return $result;
    }

    /**
     * Pass the url and json encoded payload to call the POST API
     * @param $url (POST URL) -- $url = 'http://localhost/tsplogic/resources/destinations/add';
     * @param $payload (json encoded) -- e.g. $payload=json_encode(array_combine($key, $row),true);
     */
    function httpPostWithAuth($url,$payload,$auth){
        $ch = curl_init(str_replace(' ','%20',$url));
        //echo "<br>Payload=".$payload;             
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization: Basic '. $auth));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute the POST request
        $result = curl_exec($ch);
    
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($httpcode == 201)
            return $httpcode;
        else
            return $result;
    }

    /**
     * Pass the url and json encoded payload to call the POST API
     * @param $url (POST URL) -- $url = 'http://localhost/tsplogic/resources/destinations/add';
     * @param $payload (json encoded) -- e.g. $payload=json_encode(array_combine($key, $row),true);
     */
    function httpPostWithAuthAndProxy($url,$payload,$auth){
        $proxy='127.0.0.1:3128';
        //$proxy='http://proxy-east.infra.cloud.247-inc.net:3128';
        $ch = curl_init(str_replace(' ','%20',$url));
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        //echo "<br>Payload=".$payload;             
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization: Basic '. $auth));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute the POST request
        $result = curl_exec($ch);
    
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($httpcode == 201)
            return $httpcode;
        else
            return $result;
    }

    /**
     * Pass the url and json encoded payload to call the POST API
     * @param $url (POST URL) -- $url = 'http://localhost/tsplogic/resources/destinations/add';
     * @param $payload (json encoded) -- e.g. $payload=json_encode(array_combine($key, $row),true);
     */
    function jiraPost($url,$payload,$cookie,$auth){
        $ch = curl_init(str_replace(' ','%20',$url));
        //$proxy='127.0.0.1:3128';
        //$proxy='http://proxy-east.infra.cloud.247-inc.net:3128';
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        //curl_setopt($ch, CURLOPT_PROXY, $proxy);
        //echo "<br>Payload=".$payload;             
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization: Basic '. $auth));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute the POST request
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function httpPatchWithAuth($url, $payload,$auth){

		$ch = curl_init(str_replace(' ','%20',$url));                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");                                                                  
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Basic '. $auth));    
        
        $result = curl_exec($ch);
        
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($httpcode == 204 || $httpcode == 200 )
            return $httpcode;
        else
            return $result;
	}

	public function httpDeleteWithAuth($url,$auth){

		$ch = curl_init(str_replace(' ','%20',$url));                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");                                                                   
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Basic '. $auth));   
        
        $result = curl_exec($ch);
        
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpcode;
	}

}
?>