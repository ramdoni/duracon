<?php
namespace app\components;
  
use Yii;
use yii\helpers\Url;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use app\models\mifx\MtpClientAccount;
use app\models\MtpTrades;
use app\models\MtpHistory;

class mtp extends Component
{
	/***
	 * AuthenticationHeader
	 *
	 * - url
	 * - apiToken
	 * - sessionToken (optional)
	 *	
	 */
	const url = "https://mt4msg.smt-data.com/mtp/";

	const apiToken = "760a27988ae2af5f05b1e0d34145c405";

	const operator = "M";

	const venue = "mt4mdev";

    public function init()
    {
        $query = Yii::$app->request->get();
        foreach($query as $key => $val)
        {
            Yii::$app->session->set($key, $val);
        }
    }

	public static function getApi($url, $data)
	{
        $data_string = json_encode( $data );
        $ch          = \curl_init( $url );
        curl_setopt( $ch , CURLOPT_CUSTOMREQUEST , "POST" );
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $data_string );
        curl_setopt( $ch , CURLOPT_HTTPHEADER , array (
                'Content-Type: application/json' ,
                'Content-Length: ' . strlen( $data_string )
            )
        );
        curl_setopt( $ch , CURLOPT_RETURNTRANSFER , true );
        curl_setopt( $ch , CURLOPT_SSL_VERIFYPEER , false ); // XXX
        $result      = curl_exec( $ch );
        $status_code = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
        $curl_errors = curl_error( $ch );

        $data = json_decode($result);

        if(isset($data))
        { 
        	if(isset($data->status))
        	{
        		if($data->status == 401 and $url != self::url.'trade/trade')
        		{
                    Yii::$app->session->setFlash('status_destroy', 'Session anda habis, silahkan login kembali!');
                    
                    Yii::$app->user->logout();
        		}
        	}
        }

        return $result;
	}

	/*
	 * params
	 * - 
	 * -  
	 */
	 public static function getAccountLogin($params)
	 {
	 	$data = [
                'auth' => [
                    'apiToken' => self::apiToken
                ],
                'user' => [
                    "system" => [
                        "operator" => "M",
                        "venue" => "mt4mdev"
                    ],
                    "username" => $params['username'],
                    "accountID" => $params['accountID'],
                    "password" => $params['password']
                ]
        ];

		$json = self::getApi(self::url .'account/login', $data);

        // set session
        $data = json_decode($json);

        if($data)
        {
	        if($data->status == 'OK')
	        {
	        	Yii::$app->session->set('mtp-session-token', $data->authentication->sessionToken);
	        	Yii::$app->session->set('mtp-session-stream', $data->authentication->streamToken);
	        }
        }

        return $json;
	 }	

	/*
	 * params
	 * - 
	 * -  
	 */
	public static function getClientHeartbeat()
	{
	 	$data = [
                'auth' => [
                    'apiToken' => self::apiToken,
                    "sessionToken" => Yii::$app->session->get('mtp-session-token')
                ],
                'user' => [
                    "system" => [
                        "operator" => "M",
                        "venue" => "mt4mdev"
                    ],
                    "username" => Yii::$app->user->identity->email,
                    "password" => Yii::$app->user->identity->password,
                ]
        ];

        $url = self::url .'client/heartbeat';
        
		return self::getApi($url, $data);
	}

	/*
	 * params
	 * - username
	 * - password 
	 */
	public static function getTrade($post)
	{
		$data = [
                'auth' => [
                   'apiToken' => self::apiToken,
                    "sessionToken" => Yii::$app->session->get('mtp-session-token')
                ],
        ];
        
        $data['instrumentId'] = $post['symbol'];
        $data['price'] = floatval($post['price']);
        $data['orderType'] = 'market';

        if(!empty($post['sl']))
        {
        	$data['stopLossPrice'] = floatval($post['sl']);
            $data["stopLossAction"] =  "A";
        }

        if(!empty($post['tp']))
        {
        	$data['takeProfitPrice'] = floatval($post['tp']);
            $data["takeProfitAction"] =  "A";
        }

        if($post['orderType'] == 'sell-pending' || $post['orderType'] == 'sell-market'){
            $data['price'] = floatval($post['bid']);
        }

        if($post['orderType'] == 'buy-pending' || $post['orderType'] == 'buy-market'){
            $data['price'] = floatval($post['ask']);
        }

        if($post['orderType'] == 'sell-market' || $post['orderType'] == 'sell-pending')
        {
        	$post['volume'] = '-'.$post['volume'];
        }
        
        if($post['orderType'] == 'sell-pending' || $post['orderType'] == 'buy-pending')
        {
            $level = floatval($post['price_pending']);
            $middle_price = ($post['bid'] + $post['ask']) / 2;
            $quantity = floatval($post['volume']);

            $data['price'] = $level;

            if($quantity > 0){
                if($level < $middle_price){
                    $data['orderType'] = 'limit';
                    $data["limitPrice"] =  $level;    
                } else {
                    $data['orderType'] = 'stop';
                    $data["stopPrice"] =  $level;    
                }
            }else {
                if($level > $middle_price){
                    $data['orderType'] = 'limit';
                    $data["limitPrice"] =  $level;    
                }else{
                    $data['orderType'] = 'stop';
                    $data["stopPrice"] =  $level;    
                }
            }
        }

        $data['quantity'] = floatval($post['volume']);


        #echo '<pre>'; var_dump($data); die;


        $json = self::getApi(self::url .'trade/trade', $data);

        $data = json_decode($json);

        if($data)
        {
	        if($data->status == 'OK')
	        {
                $model =  new MtpHistory;
                $model->crm_login = Yii::$app->user->identity->email;
                $model->account = $post['account'];
                $model->time_of_trade = date('Y-m-d H:i:s');
                $model->type = $post['orderType'];
                $model->price_execution = $post['price'];
                $model->ip_address = self::getIp();
                $model->sl = $post['sl'];
                $model->tp = $post['tp'];
                $model->symbol = $post['symbol'];
                $model->save();
		    }
		}

        return $json;
	}

	/*
	 * params
	 * - username
	 * - password 
	 */
	public static function getClientLogin($username, $password)
	{
		$data = [
                'auth' => [
                    'apiToken' => self::apiToken
                ],
                'user' => [
                    "system" => [
                        "operator" => self::operator,
                        "venue" => self::venue
                    ],
                    "username" => $username,
                    "password" => $password,
                ]
        ];

        $json = self::getApi(self::url .'client/login', $data);

        // set session
        $data = json_decode($json);
        if($data)
        {
	        if($data->status == 'OK')
	        {
	        	Yii::$app->session->remove('mtp-session-stream');
	        	
	        	Yii::$app->session->set('mtp-session-token', $data->authentication->sessionToken);
                
                // truncate table
                \Yii::$app->db->createCommand()->delete('mtp_client_account', ['email' => Yii::$app->user->identity->email])->execute();
                
                // insert 
                foreach($data->account->tradingAccounts as $field => $val):
                    $model = new MtpClientAccount;
                    $model->username = $val->account->userAccount->username;
                    $model->accountID = $val->account->userAccount->accountID;
                    $model->password = $val->account->userAccount->password;
                    $model->email = Yii::$app->user->identity->email;
                    $model->operator =  $val->account->userAccount->system->operator;
                    $model->venue =  $val->account->userAccount->system->venue;
                    $model->date = date('Y-m-d H:i:s');
                    $model->save();
                endforeach;
	        }
	    }
        return $data;
		
	}

	/*
	 * params
	 * - username
	 * - password 
	 */
	public function getClientLogout()
	{
		$data = [
                'auth' => [
                    'apiToken' => self::apiToken,
                    'sessionToken' => Yii::$app->session->get('mtp-session-token')
                ]
        ];

        Yii::$app->session->remove('mtp-session-token');

        $json = self::getApi(self::url .'client/logout', $data);

        return $json;
	}

	/*
	 * params
	 * - 
	 */
	public function getClientRefresh()
	{
		$data = [
                'auth' => [
                    'apiToken' => self::apiToken,
                    "sessionToken" => Yii::$app->session->get('mtp-session-token')
                ],
        ];

        $json = self::getApi(self::url .'client/refresh', $data);

        // set session
        $data = json_decode($json);
        if($data)
        {
            if($data->status == 'OK')
            {
                Yii::$app->session->set('mtp-session-stream', $data->authentication->streamToken);

                // truncate table
                \Yii::$app->db->createCommand()->delete('mtp_client_account', ['email' => Yii::$app->user->identity->email])->execute();
                
                // insert 
                foreach($data->account->tradingAccounts as $field => $val):
                    $model = new MtpClientAccount;
                    $model->username = $val->account->userAccount->username;
                    $model->accountID = $val->account->userAccount->accountID;
                    $model->password = $val->account->userAccount->password;
                    $model->email = Yii::$app->user->identity->email;
                    $model->operator =  $val->account->userAccount->system->operator;
                    $model->venue =  $val->account->userAccount->system->venue;
                    $model->date = date('Y-m-d H:i:s');
                    $model->save();
                endforeach;
            }
        }

        return $json;
	}

	/*
	 * params
	 * - no account
	 */
	public function getAccountHeartbeat($params = null)
	{
		$result = json::encode(array(
					"status"=>"success",
					"message"=>"",
				));

		return $result;
	}

	/*
	 * params
	 * - no account
	 */
	public function getBrokerInstrumentsGet()
	{
		$data = [
                'auth' => [
                    'apiToken' => self::apiToken,
                    "sessionToken" => Yii::$app->session->get('mtp-session-token')
                ],
                'user' => [
                    "system" => [
                        "operator" => "M",
                        "venue" => "mt4mdev"
                    ],
                ]
        ];

        $json = self::getApi(self::url .'broker/instruments/get', $data);

        // set session
        $data = json_decode($json);
        if($data)
        {
	        if($data->status == 'OK')
	        {
	        	Yii::$app->session->set('mtp-session-token', $data->authentication->sessionToken);
	        }
        }

        return $json;
	}

	/*
	 * params
	 * - no account
	 */
	public function getBrokerInstrumentsAll($params = null)
	{
	
		return $result;
	}

	/*
	 * params
	 * - no account
	 */
	public function getBrokerInstrumentsPrices()
	{
		$data = [
                'auth' => [
                    'apiToken' => self::apiToken,
                    "sessionToken" => Yii::$app->session->get('mtp-session-token')
                ],
                'user' => [
                    "system" => [
                        "operator" => self::operator,
                        "venue" => self::venue
                    ]
                ]
        ];

        
        $json = self::getApi(self::url .'broker/instruments/prices', $data);

        $data = json_decode($json);

        return $data;
	}

	/*
	 * params
	 * - no account
	 */
	public function getBrokerWatchlistsSummary($params = null)
	{
		$data = [
                'auth' => [
                    'apiToken' => self::apiToken,
                    "sessionToken" => Yii::$app->session->get('mtp-session-token')
                ],
                "system" => [
                    "operator" => self::operator,
                    "venue" => self::venue
                ]
        ];

		$json = self::getApi(self::url .'broker/watchlists/summary', $data);

        $data = json_decode($json);

		return $data;
	}

    /*
     * params
     * - no account
     */
    public function getBrokerWatchlists($params = null)
    {
        $data = [
                'auth' => [
                    'apiToken' => self::apiToken,
                    "sessionToken" => Yii::$app->session->get('mtp-session-token')
                ],
                "system" => [
                    "operator" => self::operator,
                    "venue" => self::venue
                ]
        ];

        $json = self::getApi(self::url .'broker/watchlists', $data);

        $data = json_decode($json);

        return $data;
    }

	/*
	 * params
	 * - no account
	 */
	public function getTradeCancel($params = null)
	{
		$data = [
                'auth' => [
                    'apiToken' => self::apiToken,
                    "sessionToken" => Yii::$app->session->get('mtp-session-token')
                ],
                'instrumentId' => $params['instrumentId'],
                'instructionId' => $params['instructionId'],
                'quantity' => $params['quantity'],
                'price' => $params['price']
        ];

        $json = self::getApi(self::url .'trade/cancel', $data);

        // set session
        $data = json_decode($json);
        
        return $json;
	}

	/*
	 * params
	 * - no account
	 */
	public function getTradeClose($params = null)
	{
		$data = [
                'auth' => [
                    'apiToken' => self::apiToken,
                    "sessionToken" => Yii::$app->session->get('mtp-session-token')
                ],
                'instrumentId' => $params['instrumentId'],
                'instructionId' => $params['instructionId'],
                'quantity' => $params['quantity'],
                'price' => $params['price']
        ];

        $json = self::getApi(self::url .'trade/close', $data);

        return $json;
	}

	/*
	 * params
	 * - no account
	 */
	public function getTradeReplace($post = null)
	{	
		$data = [
                'auth' => [
                    'apiToken' => self::apiToken,
                    "sessionToken" => Yii::$app->session->get('mtp-session-token')
                ],
        ];

        #$data['account'] = $post['account'];
        $data['instructionId'] = $post['instructionId'];
        $data['instrumentId'] = $post['symbol'];
        $data['price'] = floatval($post['price']);
        $data['orderType'] = 'market';
        $data['quantity'] = floatval($post['volume']);

        $data['limitPrice'] = 0;

        if(!empty($post['sl']))
        {
        	$data['stopLossPrice'] = floatval($post['sl']);
        }

        if(!empty($post['tp']))
        {
        	$data['takeProfitPrice'] = floatval($post['tp']);
        }

		$json = self::getApi(self::url .'trade/replace', $data);

        $data = json_decode($json);
        if($data)
        {
	        if($data->status == 'OK')
	        {

	        }
	    }

	    return $json;
	}

	public function getSessionAccount()
	{
		if(!Yii::$app->user->isGuest){

			$data = MtpClientAccount::find()->where(['email' => Yii::$app->user->identity->email, 'venue' => self::venue, 'operator' => self::operator])->orderBy(['accountID'=>SORT_ASC])->one();

			if($data)
			{
                $data = [
                        'auth' => [
                            'apiToken' => self::apiToken
                        ],
                        'user' => [
                            "system" => [
                                "operator" => self::operator,
                                "venue" => self::venue
                            ],
                            "username" => $data->username,
                            "accountID" => $data->accountID,
                            "password" => $data->password
                        ]
                ];
                $json = self::getApi(self::url .'account/login', $data);
                // set session
                $data = json_decode($json);

                if($data)
                {
                    if($data->status == 'OK')
                    {
                        Yii::$app->session->remove('mtp-session-stream');
                        Yii::$app->session->set('mtp-session-stream', $data->authentication->streamToken);
                    }
                }

                return $json;
			}
		}
	}

    public function getIp()
    {
        $ip = "";
        
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        }

        return $ip;
    }

}