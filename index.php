<?php

class Bot {
    public function curlRequest($url){
        $_curl = curl_init($url);
        curl_setopt($_curl, CURLOPT_RETURNTRANSFER, true);
        $sonuc = curl_exec($_curl);
        return $sonuc;
    }

    public function getData($url){    
        $parseUrl = parse_url($url);
      
        $host = $parseUrl['host'];
        $host = str_replace('www.','',$host);
        $host = str_replace('.','',$host);

        if(method_exists($this,$host)){
            $sonuc = $this->curlRequest($url);
            return $this->$host($sonuc);
        }else{
            return 'Method Yok';
    
        }

    }

    public function kaftcom($sonuc){
        preg_match("/<meta property='og:title' content='(.*?)' \/>/", $sonuc,$info); 
        $response['title'] = $info[1]; 
        preg_match("/<meta name=\"description\" content=\"(.*?)\" \/>/", $sonuc,$info);
        $response['description'] = $info[1]; 
        preg_match("/data-price=\"(.*?)\"/", $sonuc,$info);
        $response['price'] = $info[1]; 
        preg_match("/<span class='priceCurrency formattedPrice' itemprop='priceCurrency' content='(.*?)'/", $sonuc,$info);
        $response['currency'] = $info[1]; 
        preg_match("/<meta itemprop='image' content='(.*?)' \/>/", $sonuc,$info);
        $response['item-image'] = $info[1]; 


        $response['brand'] = 'KAFT';
        $response['seller'] = 'KAFT'; 


       
 
        return $response;
    }
}

$url = "https://www.kaft.com/store/flugi-tisort/1288/gender,male";
$bot = new Bot();

$veri = $bot->getData($url);

?>
<pre>

<?php echo print_r($veri);?>

</pre>
