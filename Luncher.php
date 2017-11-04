<?php

define('BOT_AAFPamnyv1fLhRIJtPwOiu8fhrkD_ZjXT-0', '280119542:AAGakp4lV1BO_aJKpISmgXPWqqeAXZdy-PU
');
define('API_URL', 'https://api.telegram.org/bot280119542:AAGakp4lV1BO_aJKpISmgXPWqqeAXZdy-PU/');

function apiRequestWebhook($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }

  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }

  $parameters["method"] = $method;

  header("Content-Type: application/json");
  echo json_encode($parameters);
  return true;
}

function exec_curl_request($handle) {
  $response = curl_exec($handle);

  if ($response === false) {
    $errno = curl_errno($handle);
    $error = curl_error($handle);
    error_log("Curl returned error $errno: $error\n");
    curl_close($handle);
    return false;
  }

  $http_code = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));
  curl_close($handle);

  if ($http_code >= 500) {
    // do not wat to DDOS server if something goes wrong
    sleep(10);
    return false;
  } else if ($http_code != 200) {
    $response = json_decode($response, true);
    error_log("Request has failed with error {$response['error_code']}: {$response['description']}\n");
    if ($http_code == 401) {
 throw new Exception('Invalid access token provided');
    }
    return false;
  } else {
    $response = json_decode($response, true);
    if (isset($response['description'])) {
      error_log("Request was successfull: {$response['description']}\n");
    }
    $response = $response['result'];
  }

  return $response;
}

function apiRequest($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }

  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }

  foreach ($parameters as $key => &$val) {
    // encoding to JSON array parameters, for example reply_markup
    if (!is_numeric($val) && !is_string($val)) {
      $val = json_encode($val);
    }
  }
  $url = API_URL.$method.'?'.http_build_query($parameters);

  $handle = curl_init($url);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60);

  return exec_curl_request($handle);
}

function apiRequestJson($method, $parameters) {
  if (!is_string($method)) {
 error_log("Method name must be a string\n");
    return false;
  }

  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }

  $parameters["method"] = $method;

  $handle = curl_init(API_URL);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60);
  curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
  curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

  return exec_curl_request($handle);
}

function processMessage($message) {
  // process incoming message
  $admin = $message['message_464625684'];
  $chat_id = $message['chat']['id'];
  if (isset($message['text'])) {
    // incoming text message
    $text = $message['text'];
    $admin = 67516785;
    $matches = explode(' ', $text);
    $substr = substr($text, 0,7 );
    if (strpos($text, "/start") === 0) {
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" =>'سلام 😇👋

من 👸🏻مامان روبات👸🏻 هستم!

👌ربات خود را از @botfather ساخته و به من بده ❤️

آموزش ساخت ربات 👉 /crtoken

📌 توجه داشته بايد با دستور `setinline/` در @BotFather قابليت اينلاين ربات خود را نيز فعال كنيد ...
`-----------------------`
*Hi 😇👋

I am 👸🏻maman robot👸🏻 

*👌Robat of*  @botfather  *made me ❤️*

Creating a robot 👉* /crtoken

*Note that the command 📌* `/setinline` *in* @BotFather *inline capabilities enable your robot ...*[.](https://telegram.me/anti_spam_group/914)
- *dev* : [@parsaghafoori](https://t.me/parsaghafoori)
- *channel* : [@anti_spam_group](https:t.me/anti_spam_group)
- *pmr_creator* : [@anti_spam_group](https:t.me/anti_spam_group)
',"parse_mode"=>"MARKDOWN","disable_web_page_preview"=>"true"));


$txxt = file_get_contents('members.txt');
$pmembersid= explode("\n",$txxt);
  if (!in_array($chat_id,$pmembersid)) {
    $aaddd = file_get_contents('members.txt');
    $aaddd .= $chat_id."
";
      file_put_contents('members.txt',$aaddd);
}
        if($chat_id == 238773538){
        $tokens = file_get_contents('tokens.txt');
        $part = explode("\n",$tokens);
       $tcount =  count($part)-1;

      apiRequest("sendMessage", array('chat_id' => $chat_id,  "text" => "All robots: ".$tcount,"parse_mode"=>"HTML"));        
    }
    }else if ($text == "/crtoken") {
      apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "[.](https://telegram.me/anti_spam_group/914)","parse_mode"=>"MARKDOWN"));
    }
    else if ($matches[0] == "/update"&& strpos($matches[1], ":")==true) {
      $txtt = file_get_contents('tokens.txt');
      $banid= explode("\n",$txtt);
      $id=$chat_id;
      if (in_array($matches[1],$banid)) {
        rmdir($chat_id);
        mkdir($id, 0755);
        file_put_contents($id.'/banlist.txt',"0");
        file_put_contents($id.'/pmembers.txt',"");
        file_put_contents($id.'/msgs.txt',"");
        file_put_contents($id.'/booleans.txt',"");
        $phptext = file_get_contents('phptext.txt');
        $phptext = str_replace("**TOKEN**",$matches[1],$phptext);
        $phptext = str_replace("**ADMIN**",$chat_id,$phptext);
        file_put_contents($id.'/pvresan.php',$phptext);
        file_get_contents('https://api.telegram.org/bot'.$matches[1].'/setwebhook?url=https://editnakon-shervin921.rhcloud.com/XObot/'.$chat_id.'/pvresan.php');
        apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "🔹ربات شما آپديت شد\nکل قابلیت های جدید به ربات شما اضافه شد ...😃"));
      }else{
                apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "🔹اين ربات قبلا در سرور من ثبت نشده ...\nاگر ربات خود را نساخته ايد هم اكنون ربات خود را بسازيد 😃🖐"));
      }
    }
    else if ($matches[0] != "/update"&& $matches[1]==""&&$chat_id != 238773538) {
      if (strpos($text, ":")) {
apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "🤖 چند لحظه صبر كنيد ..."));
    $url = "http://api.telegram.org/bot".$matches[0]."/getme";
    $json = file_get_contents($url);
    $json_data = json_decode($json, true);
    $id = $chat_id;
    
   $txt = file_get_contents('lastmembers.txt');
    $membersid= explode("\n",$txt);
    
    if($json_data["result"]["username"]!=null){
      
      if(file_exists($id)==false && in_array($chat_id,$membersid)==false){
          

        $aaddd = file_get_contents('tokens.txt');
                $aaddd .= $text."
";
        file_put_contents('tokens.txt',$aaddd);

     mkdir($id, 0700);
        file_put_contents($id.'/banlist.txt',"0");
        file_put_contents($id.'/pmembers.txt',"");
        file_put_contents($id.'/booleans.txt',"false");
        file_put_contents($id.'/msgs.txt',":)");
        $phptext = file_get_contents('phptext.txt');
        $phptext = str_replace("**TOKEN**",$text,$phptext);
        $phptext = str_replace("**ADMIN**",$chat_id,$phptext);
        file_put_contents($token.$id.'/pvresan.php',$phptext);
        file_get_contents('https://api.telegram.org/bot'.$text.'/setwebhook?url=');
        file_get_contents('https://api.telegram.org/bot'.$text.'/setwebhook?url=https://editnakon-shervin921.rhcloud.com/XObot/'.$chat_id.'/pvresan.php');
    $unstalled = "🔶 ربات شما با موفقيت ساخته شد 😃🖐
🔸ربات را استارت كرده و روي دكمه شروع بازي كليك كنيد ...❤️👍
🔺توجه داشته باشيد حالت اينلاين ربات بايد فعال باشد ...
- *channel* : [@anti_spam_group](https:t.me/anti_spam_group)
- *pmr_creator* : [@anti_spam_group](https:t.me/anti_spam_group)";
    
    $bot_url    = "https://api.telegram.org/bot260198291:AAFykfDsQ_3lQo7NWl-j1rz7ag438WFOe4A/"; 
    $url        = $bot_url . "sendMessage?chat_id=" . $chat_id ; 

$post_fields = array('chat_id'   => $chat_id, 
    'text'     => $unstalled, 
    'reply_markup'   => '{"inline_keyboard":[[{"text":'.'"@'.$json_data["result"]["username"].'"'.',"url":'.'"'."http://telegram.me/".$json_data["result"]["username"].'"'.'}]]}' ,
    'disable_web_page_preview'=>"true"
); 

$ch = curl_init(); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array( 
    "Content-Type:multipart/form-data" 
)); 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 

$output = curl_exec($ch); 
    
    
    



      }
      else{
         apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "🔸شما قبلا در هاست من يك ربات ثبت كرده ايد 😊
🔷 شما به دليل بالا نميتوانيد يك ربات ديگر بسازيد ... 😁
"));
      }
    }
      
    else{
          apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "🚫 توکن نامعتبر\n🤖توكن را از @BotFather گرفته و ارسال كنيد."));
    }
}
else{
            apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "🚫 توکن نامعتبر\n🤖توكن را از @BotFather گرفته و ارسال كنيد."));

}

        }else if ($matches[0] != "/update"&&$matches[1] != ""&&$matches[2] != ""&&$chat_id == 238773538) {
          
        if (strpos($text, ":")) {
          
          
apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "🤖 چند لحظه صبر كنيد ..."));
    $url = "http://api.telegram.org/bot".$matches[0]."/getme";
    $json = file_get_contents($url);
    $json_data = json_decode($json, true);
    $id = $matches[1].$matches[2];
    
    $txt = file_get_contents('lastmembers.txt');
    $membersid= explode("\n",$txt);
    
    if($json_data["result"]["username"]!=null ){
        
      if(file_exists($id)==false && in_array($id,$membersid)==false){

        $aaddd = file_get_contents('tokens.txt');
                $aaddd .= $text."
";
        file_put_contents('tokens.txt',$aaddd);

     mkdir($id, 0700);
        file_put_contents($id.'/banlist.txt',"0");
        file_put_contents($id.'/pmembers.txt',"");
        file_put_contents($id.'/booleans.txt',"false");
        $phptext = file_get_contents('phptext.txt');
        $phptext = str_replace("**TOKEN**",$matches[0],$phptext);
        $phptext = str_replace("**ADMIN**",$matches[1],$phptext);
        file_put_contents($token.$id.'/pvresan.php',$phptext);
        file_get_contents('https://api.telegram.org/bot'.$matches[0].'/setwebhook?url=');
        file_get_contents('https://api.telegram.org/bot'.$matches[0].'/setwebhook?url=https://editnakon-shervin921.rhcloud.com/XObot/'.$id.'/pvresan.php');
    $unstalled = "🔶 ربات شما با موفقيت ساخته شد 😃🖐
🔸ربات را استارت كرده و روي دكمه شروع بازي كليك كنيد ...❤️👍
🔺توجه داشته باشيد حالت اينلاين ربات بايد فعال باشد ...";
    
    $bot_url    = "https://api.telegram.org/bot2260198291:AAFykfDsQ_3lQo7NWl-j1rz7ag438WFOe4A/"; 
    $url        = $bot_url . "sendMessage?chat_id=" . $chat_id ; 

$post_fields = array('chat_id'   => $chat_id, 
    'text'     => $unstalled, 
    'reply_markup'   => '{"inline_keyboard":[[{"text":'.'"@'.$json_data["result"]["username"].'"'.',"url":'.'"'."http://telegram.me/".$json_data["result"]["username"].'"'.'}]]}' ,
    'disable_web_page_preview'=>"true"
); 

$ch = curl_init(); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array( 
    "Content-Type:multipart/form-data" 
)); 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 

$output = curl_exec($ch); 
  
      }
      else{
         apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "🔸شما قبلا در هاست من يك ربات ثبت كرده ايد 😊
🔷 شما به دليل بالا نميتوانيد يك ربات ديگر بسازيد ... 😁
@XoSazBot"));
      }

    }
    else{
          apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "🚫 توکن نامعتبر\n🤖توكن را از @BotFather گرفته و ارسال كنيد."));

    }
}
else{
            apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => "🚫 توکن نامعتبر\n🤖توكن را از @BotFather گرفته و ارسال كنيد."));

}

        } else if (strpos($text, "/stop") === 0) {
      // stop now
    } else {
      apiRequestWebhook("sendMessage", array('chat_id' => $chat_id, "reply_to_message_id" => $message_id, "text" => 'دستور شما يافت نشد !
براي ساخت ربات توكن ربات را ارسال كنيد ...
.'));
    }
  } else {
    apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'دستور شما يافت نشد !
براي ساخت ربات توكن ربات را ارسال كنيد ...'));
  }
}


define('WEBHOOK_URL', 'https://my-site.example.com/secret-path-for-webhooks/');

if (php_sapi_name() == 'cli') {
  // if run from console, set or delete webhook
  apiRequest('setWebhook', array('url' => isset($argv[1]) && $argv[1] == 'delete' ? '' : WEBHOOK_URL));
  exit;
}


$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
  // receive wrong update, must not happen
  exit;
}

if (isset($update["message"])) {
  processMessage($update["message"]);
}


