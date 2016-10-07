<?php

$content = file_get_contents("php://input");

define('token', 'YOURBOTTOKEN); // Replace 'YOURBOTTOKEN' with your bot's token provided from @BotFather
define('api', 'https://api.telegram.org/bot'.token.'/'); // Define API url(For your bot)
define('botname', '@YOURBOTUSERHANDLE'); //Replace '@YOURBOTUSERHANDLE' with your bot userhandle EX: @Myphp_bot

$update = json_decode($content, true); //Decode json responses
$message = $update['message']; //Get the receivied message from the json

$text = $message['text']; //Get the message's text

$username = $message['from']['username']; //Username of the user who sent the message
$first = $message['from']['first_name']; //First name of the user who sent the message
$last = $message['from']['last_name']; //Surname of the user who sent the message

if($message['chat']['type'] == 'private'){ //Check where the message is coming from(private/group/supergroup)
  $cid = $message['from']['id'];
}else if($message['chat']['type'] == 'group' || $message['chat']['type'] == 'supergroup'){
  $cid = $message['chat']['id'];
}

function startsWith($word $con) //Define startswith function, check if ta word exist in a string
{
    return strncmp($word, $con, strlen($con)) === 0;
}

function apiRequest($method)
{
    $req = file_get_contents(api.$method);
    return $req;
}

if(startsWith($text, "/start")) // An example of a command (Bot will respond if the message will be '/start'
{
  $cmnd = "This is an example command!"; // Bot message
  $cmnd = urlencode($cmnd); //Encoding the message
  apiRequest("sendmessage?text=$cmnd&parse_mode=HTML&chat_id=$cid"); //Sending it and parsing html
}

if($update["message"]["new_chat_member"]) // Check if someone join the group, and send a welcome message
{
  $mess = "Hey $first, welcome on this group! This is a <b>basic bot</b>, written by <i>Gooogle</i> in <b>Php</b>";
  $mess = urlencode($mess);
  apiRequest("sendmessage?chat_id=$cid&parse_mode=HTML&text=$mess");
}

?>	
