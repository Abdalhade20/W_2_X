<?php
date_default_timezone_set('Asia/Baghdad');
if(!file_exists('config.json')){
	$token = readline('Enter Token: ');
	$id = readline('Enter Id: ');
	file_put_contents('config.json', json_encode(['id'=>$id,'token'=>$token]));
	
} else {
		  $config = json_decode(file_get_contents('config.json'),1);
	$token = $config['token'];
	$id = $config['id'];
}

if(!file_exists('accounts.json')){
    file_put_contents('accounts.json',json_encode([]));
}
include 'index.php';
try {
	$callback = function ($update, $bot) {
		global $id;
		if($update != null){
		  $config = json_decode(file_get_contents('config.json'),1);
		  $config['filter'] = $config['filter'] != null ? $config['filter'] : 1;
      $accounts = json_decode(file_get_contents('accounts.json'),1);
			if(isset($update->message)){
				$message = $update->message;
				$chatId = $message->chat->id;
				$text = $message->text;
				if($chatId == $id){
					if($text == '/start'){
              $bot->sendphoto([ 'chat_id'=>$chatId,
                  'photo'=>"https://telegra.ph/file/84f48f4565147ed60454f.jpg",
                   'caption'=>'๐ ๐๐ธ๐ฟ๐ฟ๐ถ๐๐ธ ๐ ๐น                                   .
Develop๐งโ๐ป๐ฏ๐ด : @W_2_X ("ABOOD")',
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'ุชุณุฌูู ุญุณุงุจ ูููู ูู ุงูุจูุช ๐โโ','callback_data'=>'login']],
                      ]
                  ])
              ]);   
             
             //$bot->sendvideo([ 'chat_id'=>$chatId,
                  //'video'=>"https://t.me/FOLLOW_NAFSEA/145",
                   //'caption'=>'ููุฏูู ุชูุถูุญู ูุนูู ุงูุจูุช ๐',

                //]);

               
                 //$bot->sendvoice([ 'chat_id'=>$chatId,
                  //'voice'=>"https://t.me/FOLLOW_NAFSEA/147",
                   //'caption'=>'ุจุตูู ุชุนููู ุงูุณุญุจ โป๏ธ',

                //]);
                
                //$bot->sendvoice([ 'chat_id'=>$chatId,
                  //'voice'=>"https://t.me/FOLLOW_NAFSEA/160",
                   //'caption'=>'ุจุตูู ุชุนููู ุงูุณุญุจ 2 โป๏ธ',

                //]);

          } elseif($text != null){
          	if($config['mode'] != null){
          		$mode = $config['mode'];
          		if($mode == 'addL'){
          			$ig = new ig(['file'=>'','account'=>['useragent'=>'Instagram 113.0.0.39.122 Android (24/5.0; 515dpi; 1440x2416; huawei/google; Nexus 6P; angler; angler; en_US)']]);
          			list($user,$pass) = explode(':',$text);
          			list($headers,$body) = $ig->login($user,$pass);
          			// echo $body;
          			$body = json_decode($body);
          			if(isset($body->message)){
          				if($body->message == 'challenge_required'){
          					$bot->sendMessage([
          							'chat_id'=>$chatId,
          							'parse_mode'=>'markdown',
          							'text'=>"ููุฏ ุชู ุฑูุถ ุงูุญุณุงุจ ูุงูู ูุญุธูุฑ ุงู ุงูู ูุทูุจ ูุตุงุฏููโ๏ธ"
          					]);
          				} else {
          					$bot->sendMessage([
          							'chat_id'=>$chatId,
          							'parse_mode'=>'markdown',
          							'text'=>"ูููู ุงูุณุฑ ุงู ุงูููุฒุฑ ุฎุทุฃ๐ช"
          					]);
          				}
          			} elseif(isset($body->logged_in_user)) {
          				$body = $body->logged_in_user;
          				preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $headers, $matches);
								  $CookieStr = "";
								  foreach($matches[1] as $item) {
								      $CookieStr .= $item."; ";
								  }
          				$account = ['cookies'=>$CookieStr,'useragent'=>'Instagram 113.0.0.39.122 Android (24/5.0; 515dpi; 1440x2416; huawei/google; Nexus 6P; angler; angler; en_US)'];
          				
          				$accounts[$text] = $account;
          				file_put_contents('accounts.json', json_encode($accounts));
          				$mid = $config['mid'];
          				$bot->sendMessage([
          				      'parse_mode'=>'markdown',
          							'chat_id'=>$chatId,
          							'text'=>"ุชู ุงุถุงูู ุญุณุงุจ ุฌุฏูุฏ ุงูู ุงูุงุฏุงู ๐ฃ.*\n _Username_ : [$user])(instagram.com/$user)\n_Account Name_ : _{$body->full_name}_",
												'reply_to_message_id'=>$mid		
          					]);
          				$keyboard = ['inline_keyboard'=>[
										[['text'=> "โ ุฃุถุงูู ุญุณุงุจ ูููู ุฌุฏูุฏ",'callback_data'=>'addL']]
									]];
		              foreach ($accounts as $account => $v) {
		                  $keyboard['inline_keyboard'][] = [['text'=>$account,'callback_data'=>'ddd'],['text'=>"ุชุณุฌูู ุงูุฎุฑูุฌ",'callback_data'=>'del&'.$account]];
		              }
		              $keyboard['inline_keyboard'][] = [['text'=>'โป๏ธ ุงูุตูุญู ุงูุฑุฆูุณูุฉ','callback_data'=>'back']];
		              $bot->editMessageText([
		                  'chat_id'=>$chatId,
		                  'message_id'=>$mid,
		                  'text'=>"ุงููุง ุนุฒูุฒู โ๏ธ ูู ุงูุงุณูู ูู ุญุณุงุจุงุชู ุงูููููู ุงููุณุฌูู ูู ุงูุงุฏุงุฉ",
		                  'reply_markup'=>json_encode($keyboard)
		              ]);
		              $config['mode'] = null;
		              $config['mid'] = null;
		              file_put_contents('config.json', json_encode($config));
          			}
          		}  elseif($mode == 'selectFollowers'){
          		  if(is_numeric($text)){
          		    bot('sendMessage',[
          		        'chat_id'=>$chatId,
          		        'text'=>"ุชู ุงูุชุนุฏูู.",
          		        'reply_to_message_id'=>$config['mid']
          		    ]);
          		    $config['filter'] = $text;
          		    $bot->editMessageText([
                      'chat_id'=>$chatId,
                      'message_id'=>$mid,
                      'text'=>"ุตูุญู ุงูุชุญูู ุงูุฎุงุตู ุจู ุนุฒูุฒู ุงุณุชูุชุน ูุน ุงุณูู ุทุฑููู ูุณุญุจ ุงูุญุณุงุจุงุช ู ุงููุงูุง
ููุฑุงุณูู ุงููุทูุฑ - @W_2_X",
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'โ ุฃุถุงูู ุญุณุงุจ ูููู ุฌุฏูุฏ','callback_data'=>'login']],
                          [['text'=>'๐ก ุทุฑู ุณุญุจ ุงูููุฒุฑุงุช ๐ก','callback_data'=>'grabber']],
                          [['text'=>'โธ ุจุฏุก ุงูุตูุฏ','callback_data'=>'run'],['text'=>'โถ๏ธ ุงููุงู ุงูุตูุฏ','callback_data'=>'stop']],
                              [['text'=>'๐ ุญุงูุฉ ุงูุญุณุงุจุงุช ุงูููููุฉ ๐','callback_data'=>'status']],
                      ]
                  ])
                  ]);
          		    $config['mode'] = null;
		              $config['mid'] = null;
		              file_put_contents('config.json', json_encode($config));
          		  } else {
          		    bot('sendMessage',[
          		        'chat_id'=>$chatId,
          		        'text'=>'- ูุฑุฌู ุงุฑุณุงู ุฑูู ููุท .'
          		    ]);
          		  }
          		} else {
          		  switch($config['mode']){
          		    case 'search': 
          		      $config['mode'] = null; 
          		      $config['words'] = $text;
          		      file_put_contents('config.json', json_encode($config));
          		      exec('screen -dmS gr php search.php');
          		      break;
          		      case 'followers': 
          		      $config['mode'] = null; 
          		      $config['words'] = $text;
          		      file_put_contents('config.json', json_encode($config));
          		      exec('screen -dmS gr php followers.php');
          		      break;
          		      case 'following': 
          		      $config['mode'] = null; 
          		      $config['words'] = $text;
          		      file_put_contents('config.json', json_encode($config));
          		      exec('screen -dmS gr php following.php');
          		      break;
          		      case 'hashtag': 
          		      $config['mode'] = null; 
          		      $config['words'] = $text;
          		      file_put_contents('config.json', json_encode($config));
          		      exec('screen -dmS gr php hashtag.php');
          		      break;
          		  }
          		}
          	}
          }
				} else {
					$bot->sendphoto([
							'chat_id'=>$chatId,
							'photo'=> "https://telegra.ph/file/ce1a4b1af1f6ae8326628.jpg",
							 'caption'=>'ุงูุจูุช ูุฏููุน ุญูุจู๐ฒ ู ููุณ ูุฌุงูู ๐โ๐จ
ูุดุฑุงุก ูุณุฎู ูุฑุงุณูุฉุฉ ุงููุทูุฑ ๐โ๐จ ููุงุจู ุงู ุดู',
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'โซ๏ธ| ูุทูุฑ ุงูุจูุช','url'=>'t.me/W_2_X']],
                       [['text'=>"โช๏ธ| ููุงู ุงููุทูุฑ", 'url'=>"t.me/iatool"]],
                      ]
                  ])
              ]);   
				}
			} elseif(isset($update->callback_query)) {
          $chatId = $update->callback_query->message->chat->id;
          $mid = $update->callback_query->message->message_id;
          $data = $update->callback_query->data;
          echo $data;
          if($data == 'login'){
              
        		$keyboard = ['inline_keyboard'=>[
									[['text'=>"โ ุฃุถุงูู ุญุณุงุจ ูููู ุฌุฏูุฏ",'callback_data'=>'addL']]
									]];
		              foreach ($accounts as $account => $v) {
		                  $keyboard['inline_keyboard'][] = [['text'=>$account,'callback_data'=>'ddd'],['text'=>"ุชุณุฌูู ุงูุฎุฑูุฌ",'callback_data'=>'del&'.$account]];
		              }
		              $keyboard['inline_keyboard'][] = [['text'=>'โป๏ธ ุงูุตูุญู ุงูุฑุฆูุณูุฉ','callback_data'=>'back']];
		              $bot->sendMessage([
		                  'chat_id'=>$chatId,
		                  'message_id'=>$mid,
		                   'text'=>"ููู ฺฏูุจู โ๏ธ ูู ุงูุงุณูู ูู ุญุณุงุจุงุชู ุงูููููู ุงููุณุฌูู ูู ุงูุงุฏุงุฉ",
		                  'reply_markup'=>json_encode($keyboard)
		              ]);
          } elseif($data == 'addL'){
          	
          	$config['mode'] = 'addL';
          	$config['mid'] = $mid;
          	file_put_contents('config.json', json_encode($config));
          	$bot->sendMessage([
          			'chat_id'=>$chatId,
          			'text'=>"  ุงุฑุณู ุงูุญุณุงุจ ุจูุฐุง ุงูููุท `user:pass`",
          			'parse_mode'=>'markdown'
          	]);
          } elseif($data == 'grabber'){
            
            $for = $config['for'] != null ? $config['for'] : 'ุญุฏุฏ ุงูุญุณุงุจ';
            $count = count(explode("\n", file_get_contents($for)));
            $bot->editMessageText([
                'chat_id'=>$chatId,
                'message_id'=>$mid,
                'text'=>"Users collection page. \n - Users : $count \n - For Account : $for",
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                        [['text'=>'๐ฃ ุจุญุซ ูููุงุช','callback_data'=>'search']],
                        [['text'=>'โ๏ธุจุญุซ ูุงุดุชุงู ','callback_data'=>'hashtag'],['text'=>'๐ ูู ุงูุงูุณุจููุฑ','callback_data'=>'explore']],
                        [['text'=>'Followers','callback_data'=>'followers'],['text'=>"Following",'callback_data'=>'following']],
                        [['text'=>"ุงูุญุณุงุจ ุงููุญุฏุฏ : $for",'callback_data'=>'for']],
                        [['text'=>'๐ธ ูุณุชุฉ ููุฒุฑุงุช ุฌุฏูุฏู','callback_data'=>'newList'],['text'=>'๐ธ ูุณุชุฉ ููุฒุฑุงุช ุณุงุจูุฉ','callback_data'=>'append']],
                        [['text'=>'โป๏ธ ุงูุตูุญู ุงูุฑุฆูุณูุฉ ','callback_data'=>'back']],
                    ]
                ])
            ]);
          } elseif($data == 'search'){
            $bot->sendMessage([
                'chat_id'=>$chatId,
                'text'=>"ุงูุงู ูู ุจุฃุฑุณุงู ุงููููู ุงูุชุฑูุฏ ุงูุจุญุซ ุนูููุง ู ุงูุถุง ููููู ูู ุงุณุชุฎุฏุงู ุงูุซุฑ ูู ูููู ุนู ุทุฑูู ูุถุน ููุงุตู ุจูู ุงููููุงุชโ๏ธ"
            ]);
            $config['mode'] = 'search';
            file_put_contents('config.json', json_encode($config));
          } elseif($data == 'followers'){
            $bot->sendMessage([
                'chat_id'=>$chatId,
                'text'=>"ุงูุงู ูู ุจุฃุฑุณุงู ุงูููุฒุฑ ุงูุชุฑูุฏ ุณุญุจ ูุชุงุจุนูู ู ุงูุถุง ููููู ูู ุงุณุชุฎุฏุงู ุงูุซุฑ ูู ููุฒุฑ ุนู ุทุฑูู ูุถุน ููุงุตู ุจูู ุงูููุฒุฑุงุช ๐คญ"
            ]);
            $config['mode'] = 'followers';
            file_put_contents('config.json', json_encode($config));
          } elseif($data == 'following'){
            $bot->sendMessage([
                'chat_id'=>$chatId,
                'text'=>"ุงูุงู ูู ุจุฃุฑุณุงู ุงูููุฒุฑ ุงูุชุฑูุฏ ุณุญุจ ุงูุฐู  ูุชุงุจุนูู ู ุงูุถุง ููููู ูู ุงุณุชุฎุฏุงู ุงูุซุฑ ูู ููุฒุฑ ุนู ุทุฑูู ูุถุน ููุงุตู ุจูู ุงูููุฒุฑุงุช ๐คญ"
            ]);
            $config['mode'] = 'following';
            file_put_contents('config.json', json_encode($config));
          } elseif($data == 'hashtag'){
            $bot->sendMessage([
                'chat_id'=>$chatId,
                'text'=>"ุงูุงู ูู ุจุฃุฑุณุงู ุงููุงุดุชุงู ุจุฏูู ุนูุงูู # ููููู ๐งฟุงุณุชุฎุฏุงู ูุงุดุชุงู ูุงุญุฏ ููุท"
            ]);
            $config['mode'] = 'hashtag';
            file_put_contents('config.json', json_encode($config));
          } elseif($data == 'newList'){
            file_put_contents('a','new');
            $bot->answerCallbackQuery([
							'callback_query_id'=>$update->callback_query->id,
							'text'=>"ุชู ุงุฎุชูุงุฑ ๐ธ ูุณุชุฉุฉ ููุฒุฑุงุช ุฌุฏูุฏู ุจูุฌุงุญ",
							'show_alert'=>1
						]);
          } elseif($data == 'append'){ 
            file_put_contents('a', 'ap');
            $bot->answerCallbackQuery([
							'callback_query_id'=>$update->callback_query->id,
							'text'=>"ุชู ุงุฎุชูุงุฑ ๐ธ ูุณุชุฉุฉ ููุฒุฑุงุช ุณุงุจูุฉุฉ ุจูุฌุงุญ",
							'show_alert'=>1
						]);
						
          } elseif($data == 'for'){
            if(!empty($accounts)){
            $keyboard = [];
             foreach ($accounts as $account => $v) {
                $keyboard['inline_keyboard'][] = [['text'=>$account,'callback_data'=>'forg&'.$account]];
              }
              $bot->editMessageText([
                  'chat_id'=>$chatId,
                  'message_id'=>$mid,
                  'text'=>"ุงุฎุชุงุฑ ุงูุญุณุงุจ",
                  'reply_markup'=>json_encode($keyboard)
              ]);
            } else {
              $bot->answerCallbackQuery([
							'callback_query_id'=>$update->callback_query->id,
							'text'=>"ููู ุบูุฑ ูุฎููู ุญุณูุงุจ ููููู ุญุชูู ุงุดุชุบูู ๐",
							'show_alert'=>1
						]);
            }
          } elseif($data == 'selectFollowers'){
            bot('sendMessage',[
                'chat_id'=>$chatId,
                'text'=>'ูู ุจุฃุฑุณุงู ุนุฏุฏ ูุชุงุจุนูู .'  
            ]);
            $config['mode'] = 'selectFollowers';
          	$config['mid'] = $mid;
          	file_put_contents('config.json', json_encode($config));
          } elseif($data == 'run'){
            if(!empty($accounts)){
            $keyboard = [];
             foreach ($accounts as $account => $v) {
                $keyboard['inline_keyboard'][] = [['text'=>$account,'callback_data'=>'start&'.$account]];
              }
              $bot->editMessageText([
                  'chat_id'=>$chatId,
                  'message_id'=>$mid,
                  'text'=>"ุญุฏุฏ ุญุณุงุจ",
                  'reply_markup'=>json_encode($keyboard)
              ]);
            } else {
              $bot->answerCallbackQuery([
							'callback_query_id'=>$update->callback_query->id,
							'text'=>"ููู ุบูุฑ ูุฎููู ุญุณูุงุจ ููููู ุญุชูู ุงุดุชุบูู  ๐",
							'show_alert'=>1
						]);
            }
          }elseif($data == 'stop'){
            if(!empty($accounts)){
            $keyboard = [];
             foreach ($accounts as $account => $v) {
                $keyboard['inline_keyboard'][] = [['text'=>$account,'callback_data'=>'stop&'.$account]];
              }
              $bot->editMessageText([
                  'chat_id'=>$chatId,
                  'message_id'=>$mid,
                  'text'=>"ุงุฎุชุงุฑ ุงูุญุณุงุจ",
                  'reply_markup'=>json_encode($keyboard)
              ]);
            } else {
              $bot->answerCallbackQuery([
							'callback_query_id'=>$update->callback_query->id,
							'text'=>"ูู ุจุชุณุฌูู ุญุณุงุจ ุงููุง ๐",
							'show_alert'=>1
						]);
            }
          }elseif($data == 'stopgr'){
            shell_exec('screen -S gr -X quit');
            $bot->answerCallbackQuery([
							'callback_query_id'=>$update->callback_query->id,
							'text'=>"ุชู ุงูุงูุชูุงุก ูู ุงูุณุญุจ",
						// 	'show_alert'=>1
						]);
						$for = $config['for'] != null ? $config['for'] : 'Select Account';
            $count = count(explode("\n", file_get_contents($for)));
						$bot->editMessageText([
                'chat_id'=>$chatId,
                'message_id'=>$mid,
                'text'=>"Users collection page. \n - Users : $count \n - For Account : $for",
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                       [['text'=>'๐ฃ ุจุญุซ ูููุงุช','callback_data'=>'search']],
                        [['text'=>'โ๏ธุจุญุซ ูุงุดุชุงู ','callback_data'=>'hashtag'],['text'=>'๐ ูู ุงูุงูุณุจููุฑ','callback_data'=>'explore']],
                        [['text'=>'Followers','callback_data'=>'followers'],['text'=>"Following",'callback_data'=>'following']],
                        [['text'=>"ุงูุญุณุงุจ ุงููุญุฏุฏ : $for",'callback_data'=>'for']],
                        [['text'=>'๐ธ ูุณุชุฉ ููุฒุฑุงุช ุฌุฏูุฏู','callback_data'=>'newList'],['text'=>'๐ธ ูุณุชุฉ ููุฒุฑุงุช ุณุงุจูุฉ','callback_data'=>'append']],
                        [['text'=>'โป๏ธ ุงูุตูุญู ุงูุฑุฆูุณูุฉ','callback_data'=>'back']],
                    ]
                ])
            ]);
          } elseif($data == 'explore'){
            exec('screen -dmS gr php explore.php');
          } elseif($data == 'status'){
					$status = '';
					foreach($accounts as $account => $ac){
						$c = explode(':', $account)[0];
						$x = exec('screen -S '.$c.' -Q select . ; echo $?');
						if($x == '0'){
				        $status .= "*$account* ~> _Working_\n";
				    } else {
				        $status .= "*$account* ~> _Stop_\n";
				    }
					}
					$bot->sendMessage([
							'chat_id'=>$chatId,
							'text'=>"ุญุงูู ุงูุญุณุงุจุงุช : \n\n $status",
							'parse_mode'=>'markdown'
						]);
				} elseif($data == 'back'){
          	$bot->editMessageText([
                      'chat_id'=>$chatId,
                      'message_id'=>$mid,
                     'text'=> "ุงููุง ุนุฒูุฒู โ๏ธ
ูู ุงูุงุณูู ูู ุญุณุงุจุงุชู ุงูููููู ุงููุณุฌูู ูู ุงูุงุฏุงุฉ",
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'โ ุฃุถุงูู ุญุณุงุจ ูููู ุฌุฏูุฏ','callback_data'=>'login']],
                          [['text'=>'๐ก ุทุฑู ุณุญุจ ุงูููุฒุฑุงุช ๐ก','callback_data'=>'grabber']],
                          [['text'=>'โธ ุจุฏุก ุงูุตูุฏ','callback_data'=>'run'],['text'=>'โถ๏ธ ุงููุงู ุงูุตูุฏ','callback_data'=>'stop']],
                         [['text'=>'๐ ุญุงูุฉ ุงูุญุณุงุจุงุช ุงูููููุฉ ๐','callback_data'=>'status']],
                      ]
                  ])
                  ]);
          } else {
          	$data = explode('&',$data);
          	if($data[0] == 'del'){
          		
          		unset($accounts[$data[1]]);
          		file_put_contents('accounts.json', json_encode($accounts));
              $keyboard = ['inline_keyboard'=>[
							[['text'=>"โ ุฃุถุงูู ุญุณุงุจ ูููู ุฌุฏูุฏ",'callback_data'=>'addL']]
									]];
		              foreach ($accounts as $account => $v) {
		                  $keyboard['inline_keyboard'][] = [['text'=>$account,'callback_data'=>'ddd'],['text'=>"ุชุณุฌูู ุงูุฎุฑูุฌ",'callback_data'=>'del&'.$account]];
		              }
		              $keyboard['inline_keyboard'][] = [['text'=>'โป๏ธ ุงูุตูุญู ุงูุฑุฆูุณูุฉ','callback_data'=>'back']];
		              $bot->editMessageText([
		                  'chat_id'=>$chatId,
		                  'message_id'=>$mid,
		                    'text'=>"ุงููุง ุนุฒูุฒู โ๏ธ ูู ุงูุงุณูู ูู ุญุณุงุจุงุชู ุงูููููู ุงููุณุฌูู ูู ุงูุงุฏุงุฉ",
		                  'reply_markup'=>json_encode($keyboard)
		              ]);
          	} elseif($data[0] == 'forg'){
          	  $config['for'] = $data[1];
          	  file_put_contents('config.json',json_encode($config));
              $for = $config['for'] != null ? $config['for'] : 'Select';
              $count = count(file_get_contents($for));
              $bot->editMessageText([
                'chat_id'=>$chatId,
                'message_id'=>$mid,
                'text'=>"Users collection page. \n - Users : $count \n - For Account : $for",
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                            [['text'=>'๐ฃ ุจุญุซ ูููุงุช','callback_data'=>'search']],
                        [['text'=>'โ๏ธุจุญุซ ูุงุดุชุงู ','callback_data'=>'hashtag'],['text'=>'๐ ูู ุงูุงูุณุจููุฑ','callback_data'=>'explore']],
                        [['text'=>'Followers','callback_data'=>'followers'],['text'=>"Following",'callback_data'=>'following']],
                        [['text'=>"For Account : $for",'callback_data'=>'for']],
                        [['text'=>'๐ธ ูุณุชุฉ ููุฒุฑุงุช ุฌุฏูุฏู','callback_data'=>'newList'],['text'=>'๐ธ ูุณุชุฉ ููุฒุฑุงุช ุณุงุจูุฉ','callback_data'=>'append']],
                        [['text'=>'โป๏ธ ุงูุตูุญู ุงูุฑุฆูุณูุฉ','callback_data'=>'back']],
                    ]
                ])
            ]);
          	} elseif($data[0] == 'start'){
          	  file_put_contents('screen', $data[1]);
          	  $bot->editMessageText([
                      'chat_id'=>$chatId,
                      'message_id'=>$mid,
                       'text'=> "ุงููุง ุจู ุญุจู  โ๏ธ
ุงุฎุชุฑ ูุง ุชุฑูุฏ ูู ุงูุงุณูู ๐",
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'โ ุฃุถุงูู ุญุณุงุจ ูููู ุฌุฏูุฏ','callback_data'=>'login']],
                          [['text'=>'๐ก ุทุฑู ุณุญุจ ุงูููุฒุฑุงุช ๐ก','callback_data'=>'grabber']],
                          [['text'=>'โธ ุจุฏุก ุงูุตูุฏ','callback_data'=>'run'],['text'=>'โถ๏ธ ุงููุงู ุงูุตูุฏ','callback_data'=>'stop']],
                         [['text'=>'๐ ุญุงูุฉ ุงูุญุณุงุจุงุช ุงูููููุฉ ๐','callback_data'=>'status']],
                      ]
                  ])
                  ]);
              exec('screen -dmS '.explode(':',$data[1])[0].' php start.php');
              $bot->sendMessage([
                'chat_id'=>$chatId,
                'text'=>"*ุจุฏุก ุงูุตูุฏ.*\n Account: `".explode(':',$data[1])[0].'`',
                'parse_mode'=>'markdown'
              ]);
          	} elseif($data[0] == 'stop'){
          	  $bot->editMessageText([
                      'chat_id'=>$chatId,
                      'message_id'=>$mid,
                      'text'=>"ุงููุง ุจู ูุฑู ุงุฎุฑู ุนุฒูุฒู โ๏ธ
ุงุฎุชุฑ ูุง ุชุฑูุฏู ูู ุงูุงุณูู ๐",
                  'reply_markup'=>json_encode([
                      'inline_keyboard'=>[
                          [['text'=>'โ ุฃุถุงูู ุญุณุงุจ ูููู ุฌุฏูุฏ','callback_data'=>'login']],
                          [['text'=>'๐ก ุทุฑู ุณุญุจ ุงูููุฒุฑุงุช ๐ก','callback_data'=>'grabber']],
                          [['text'=>'โธ ุจุฏุก ุงูุตูุฏ','callback_data'=>'run'],['text'=>'โถ๏ธ ุงููุงู ุงูุตูุฏ','callback_data'=>'stop']],
                         [['text'=>'๐ ุญุงูุฉุฉ ุงูุญุณุงุจุงุช ุงูููููุฉ ๐','callback_data'=>'status']],
                      ]
                    ])
                  ]);
              exec('screen -S '.explode(':',$data[1])[0].' -X quit');
          	}
          }
			}
		}
	};
	$bot = new EzTG(array('throw_telegram_errors'=>false,'token' => $token, 'callback' => $callback));
} catch(Exception $e){
	echo $e->getMessage().PHP_EOL;
	sleep(1);
}
