<?php
require 'thirdPart/BigEndianLib/BigEndianSocketBuffer.php';
require 'thirdPart/BigEndianLib/BigEndianBytesBuffer.php';

define (D_KEY_CMD,'cmd');
define ('D_KEY_CMD1','cmd');

define (D_VALUE_CMD_SEND_LOGIN,0x0001);
define (D_KEY_CMD_SEND_LOGIN_PLATFORM,'platform');
define (D_KEY_CMD_SEND_LOGIN_VERSION,'version');
define (D_KEY_CMD_SEND_LOGIN_ACCOUNT,'account');
define (D_KEY_CMD_SEND_LOGIN_PASSWORD,'password');

define (D_VALUE_CMD_RECV_LOGIN,0x0002);
define (D_KEY_CMD_RECV_LOGIN_FLAG,'flag');
define (D_KEY_CMD_RECV_LOGIN_UID,'uid');
define (D_KEY_CMD_RECV_LOGIN_RANDOM_KEY,'random_key');
define (D_KEY_CMD_RECV_LOGIN_GUEST_ACCOUNT,'guest_account');

define (D_VALUE_CMD_SERVER_RECV,0x0003);
define (D_KEY_CMD_MSG_ID,'msg_id');

define (D_KEY_CMD_SEND_LOGIN_VERSION,'version');
define (D_KEY_CMD_SEND_LOGIN_ACCOUNT,'account');
define (D_KEY_CMD_SEND_LOGIN_PASSWORD,'password');

define (D_VALUE_CMD_EXPAND_CMD,0x000c);
define (D_KEY_CMD_JSON,'json');
define (D_VALUE_CMD_PUSH_EXPAND_CMD,0x000d);

define (D_VALUE_CMD_EXPAND_CMD,0x000d);

define (D_VALUE_CMD_CS_SEND_LOGIN,0x1001);
define (D_VALUE_CMD_CS_RECV_LOGIN,0x1002);
define (D_KEY_CMD_CS_SEND_LOGIN_SERVER_TYPE,'server_type');
class protocolAnalyze
{
	function __construct()
	{

	}
	public function build($arr)
	{
		$buf='';
		$analyzer=new BigEndianBytesBuffer($buf);
		$analyzer->writeInt(0x671BA3F7);
		$analyzer->writeChar(3);
		$analyzer->writeChar(1);
		$analyzer->writeChar(0);
		$analyzer->writeChar(1);

		$lenPos=$analyzer->getWriteIndex();
		$packBeginPos=$analyzer->getWriteIndex();
		$analyzer->writeShort(00);//内容长
		$analyzer->writeShort($arr[D_KEY_CMD]);//10进制的13
		switch ($arr[D_KEY_CMD])
		{
			case D_VALUE_CMD_CS_SEND_LOGIN:
				{
					$analyzer->writeChar($arr[D_KEY_CMD_CS_SEND_LOGIN_SERVER_TYPE]);					
				}
				break;
			case D_VALUE_CMD_SEND_LOGIN:
				{
					$analyzer->writeChar($arr[D_KEY_CMD_SEND_LOGIN_PLATFORM]);
					$analyzer->writeShort($arr[D_KEY_CMD_SEND_LOGIN_VERSION]);
					$AccountLen=strlen($arr[D_KEY_CMD_SEND_LOGIN_ACCOUNT]);
					$analyzer->writeChar($AccountLen);
					$analyzer->writeStr($arr[D_KEY_CMD_SEND_LOGIN_ACCOUNT]);
					$passLen=strlen($arr[D_KEY_CMD_SEND_LOGIN_PASSWORD]);
					$analyzer->writeChar($passLen);
					$analyzer->writeStr($arr[D_KEY_CMD_SEND_LOGIN_PASSWORD]);
				}
				break;
			case D_VALUE_CMD_EXPAND_CMD:
			case D_VALUE_CMD_PUSH_EXPAND_CMD:
				{
					$analyzer->writeShort($arr[D_KEY_CMD_MSG_ID]);
					$analyzer->writeStr($arr[D_KEY_CMD_JSON]);
				}
				break;
			default:
				$buf='';
				return $buf;
		}
		$packEndPos=$analyzer->getWriteIndex();
		$packLen=$packEndPos-($packBeginPos+4);
		$analyzer->setWriteIndex($packBeginPos);
		$analyzer->writeShortEx($packLen);
		$analyzer->setWriteIndex($packEndPos);
		$buf=$analyzer->readAllBytes();
		return $buf;
	}

	public function unbuild($buf)
	{
		//解析网络数据
		$arrReturn=array();
		$analyzer=new BigEndianBytesBuffer($buf);
		$flag=$analyzer->readInt();
		if ($flag==0x671BA3F7)
		{
			$headByte1=$analyzer->readChar();
			$headByte2=$analyzer->readChar();
			$headByte3=$analyzer->readChar();
			$headByte4=$analyzer->readChar();
			if ($headByte4==1)
			{
				$len=$analyzer->readShort();
				$cmd=$analyzer->readShort();
				$arrReturn[D_KEY_CMD]=$cmd;
				switch ($cmd)
				{
					case D_VALUE_CMD_CS_RECV_LOGIN:
						break;
					case D_VALUE_CMD_RECV_LOGIN:
						{
							$arrReturn[D_KEY_CMD_RECV_LOGIN_FLAG]=$analyzer->readChar();
							$arrReturn[D_KEY_CMD_RECV_LOGIN_UID]=$analyzer->readInt();
							$keyLen=$analyzer->readChar();
							$arrReturn[D_KEY_CMD_RECV_LOGIN_RANDOM_KEY]=$analyzer->readBytes($keyLen);
							$guestLen=$analyzer->readChar();
							$arrReturn[D_KEY_CMD_RECV_LOGIN_RANDOM_KEY]=$analyzer->readBytes($guestLen);
						}
						break;
					case D_VALUE_CMD_SERVER_RECV:
						{
							$arrReturn[D_VALUE_CMD_PUSH_EXPAND_CMD]=$analyzer->readShort();
						}
						break;
					case D_VALUE_CMD_EXPAND_CMD:
					case D_VALUE_CMD_PUSH_EXPAND_CMD:
						{
							$arrReturn[D_VALUE_CMD_PUSH_EXPAND_CMD]=$analyzer->readShort();
							$arrReturn[D_KEY_CMD_JSON]=$analyzer->readBytes($len-2);
						}
						break;
					default:
						break;
				}
			}
		}
		return $arrReturn;
	}
}