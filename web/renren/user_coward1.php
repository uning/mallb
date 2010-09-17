<?php
require_once('config.php');
include "./header.php";

$pid =   $_REQUEST['xn_sig_user'];  
$sess=TTGenid::getbypid($pid);
$u=$sess['id'];
$user = new TTUser($sess['id']);
$gem = $user->chGem(0);
if(!$u || !$pid){
die('no user');
}	
 
?> 

 <style>  
 
#content {
height: 700px;
font:12px/1.5 tahoma,arial,微软雅黑,宋体,sans-serif;
}
#header .logo {
    width:195px;
    height: 46px;
    background: url("<?php echo RenrenConfig::$resource_urlp; ?>/images/logo.png?v=1") no-repeat 10px center transparent;
    text-indent: -9999px;
    float: left;
}

#header .logo  a {
    display: block;
    height: 36px;
} 
 
#navga ul { 
    margin: 0 0 5px 0px;
    padding-top: 14px;
}

#navga ul li {
    float: left;
    cursor: pointer;
    padding: 0 2px;
}

#navga ul li a {
    display: block;
    text-indent: -9999px;
    background: url("<?php echo RenrenConfig::$resource_urlp; ?>/images/nav.png") no-repeat left top;
    width: 95px;
    height: 32px; 
} 
#navga ul li.game a {
    background-position: 0 -1px;
}


#navga ul li.game a.active, #navga ul li.game a:hover {
    background-position: 0 -45px;
    outline:none;
	blr:expression(this.onFocus=this.blur());
	
}

#navga ul li.freegift a {
    background-position: 0 -88px;
}

#navga ul li.freegift a.active, #navga ul li.freegift a:hover {
    background-position: 0 -133px;
	outline:none;
	blr:expression(this.onFocus=this.blur());
}

#navga ul li.invite a {
    background-position: 0 -176px;
}

#navga ul li.invite a.active, #navga ul li.invite a:hover {
    background-position: 0 -221px;
}

/*payment*/
#navga ul li.faq a {
    background-position: 0 -263px;
}

#navga ul li.faq a.active, #navga ul li.faq a:hover {
    background-position: 0 -308px;
    outline:none;
	blr:expression(this.onFocus=this.blur());
}

#navga ul li.forum a {
    background-position: 0 -351px;
}

#navga ul li.forum a.active, #navga ul li.forum a:hover {
    background-position: 0 -396px;
}
#navga ul li.payment a {
    background-position: 0 -440px;
}

#navga ul li.payment a.active, #navga ul li.payment a:hover {
    background-position: 0 -487px;
    outline:none;
	blr:expression(this.onFocus=this.blur());
}
#navga ul li.problem a {
    background-position: 0 -532px;
}

#navga ul li.problem a.active, #navga ul li.problem a:hover {
    background-position: 0 -579px;
    outline:none;
	blr:expression(this.onFocus=this.blur());
}

#pay-body{
 height: 600px; 
 text-align:center;
}
.user-info {
height:60px;
margin:0 20px;
padding:10px 10px 10px 90px;
}
.user-info h2{
text-align:left;
}
.user-info p{
padding:10px 0 0;
text-align:left;
}
.user-info p label {
background:url("<?php echo RenrenConfig::$resource_urlp ?>/images/gem.png") no-repeat scroll 5px center #FFFAEF;
border:1px solid #E2C925;
margin-right:10px;
padding:5px 20px 6px 25px;
}
.user-info p label span {
color:#336699;
padding-left:5px;
}
.user-info .avatar{
-moz-border-radius:3px 3px 3px 3px;
-moz-box-shadow:1px 1px 2px #CCCCCC;
border:1px solid #B2B2B2;
display:block;
float:left;
height:50px;
margin-left:-70px;
padding:2px;
}
.user-info .avatar img{
width: 50px;
height: 50px;
}
  
.giftformsubmit {
background-color:#3B5998;
border-color:#D9DFEA #0E1F5B #0E1F5B #D9DFEA;
border-style:solid;
border-width:1px;
color:white;
cursor:pointer;
font-size:16px;
font-weight:bold;
height:50px;
margin:30px 5px;
padding:10px 20px;
text-decoration:none;
}
 </style>
 

 
<div id='is_install'></div>	

<div id='content'>
    <div class='container'>
        <div class='canvas'>
			<div id="header">
				<div id="navga">
				<div class="logo"><a href="<?php echo RenrenConfig::$canvas_url;?>" target="_top" title="开始游戏!">logo</a></div>
			   <div id="tabs">
				<ul class="clearfix tcenter">       
					<li class="game" id="flashTab" ><a  href="<?php echo RenrenConfig::$canvas_url;?>" >游戏</a></li>
					<li class="freegift"><a href="<?php echo RenrenConfig::$canvas_url;?>?a=freeGift" id="freeGift" >免费礼物</a></li>
					<li class="invite" ><a href="<?php echo RenrenConfig::$canvas_url;?>?a=invite" >邀请好友</a></li>
					<li class="faq"><a id='faq'  href="<?php echo RenrenConfig::$canvas_url;?>?a=faq" >常见问题</a></li>
					<li class="forum"><a href="<?php echo RenrenConfig::$group_url; ?>" class="fullpage" target='_blank' id="forum">论坛</a></li>
					<li class="payment" ><a  href="<?php echo RenrenConfig::$canvas_url;?>pay.php"   id ="pay">充值</a></li>
				</ul>
				</div>
				</div>
			</div>
		
		    <div id='pay-body'>
					<div style='padding:20px;'>
						9月8日凌晨和上午，某些玩家反映游戏出现问题。我们对给大家造成的困扰向大家道歉，并最快速度进行处理。<br/>
						我们按照承诺对游戏玩家进行补偿。
					</div>
					
					<?php 
					if($sess['caward'] && $sess['caward']==1 && !$_POST['do']){  
						echo "<form action='user_coward.php'> <input type='hidden' name='do' value='1'/> <input type='submit' class='giftformsubmit' value='领取补偿'/></form>";
					}else if($sess['caward'] && $sess['caward']==1 && $_POST['do'] )
					{
						$curaward = 1; 
						$tu = new TTUser($u);

						//$getids[]=$tu->getdid('caward');
						$getids[]=$tu->getdid('exp');
						$coid=$tu->getdid('copilot',TT::OTHER_GROUP );
						$getids[]= $coid;
						$datas = $tu->getbyids($getids);	

						$level = $tu->getLevel($datas['exp']);
						$copilot = $datas['copilot'];
						$copilot['id']=$coid;
						$str = '';
						if($level>30){
							$tu->chMoney(300000);
							$tu->chGem(15);
							$copilot['bag'][2002] += 4;//加两箱的道具
							$copilot['bag'][2004] += 6;//加6小时的道具
							$str = '300000金币,15个宝石,4份加两箱的道具，6份加6小时的道具';
						}
						else if($level>20){
							$tu->chMoney(150000);
							$tu->chGem(8);
							$copilot['bag'][2002] += 3;//加两箱的道具
							$copilot['bag'][2004] += 4;//加6小时的道具
							$str = '150000金币,8个宝石,3份加两箱的道具，4份加6小时的道具';
						}
						else if($level>10){
							$tu->chMoney(100000);
							$tu->chGem(5);
							$copilot['bag'][2002] += 2;//加两箱的道具
							$copilot['bag'][2004] += 2;//加6小时的道具
							$str = '100000金币,5个宝石,2份加两箱的道具，2份加6小时的道具';
						}
						else{
							$tu->chMoney(50000);
							$tu->chGem(3);
							$copilot['bag'][2002] += 1;//加两箱的道具
							$str = '50000金币,3个宝石,1份加两箱的道具';
						}
						$tu->puto($copilot);
						$sess['caward']+=1;
						TTGenid::genid($sess);
						
						echo "<div style='font-size:16px;margin:20px;'>已经补偿给你<span style='font-weigth:bold;color:red;'>$str</span>请注意查收。<a href='".RenrenConfig::$canvas_url."'>返回游戏</a></div>";
					} 
					else if($sess['caward'] && $sess['caward']==2){ 
						$tu = new TTUser($u);

						//$getids[]=$tu->getdid('caward');
						$getids[]=$tu->getdid('exp');
						$getids[]=$tu->getdid('');
						$coid=$tu->getoid('copilot',TT::OTHER_GROUP );
						$getids[]= $coid;
						$datas = $tu->getbyids($getids);	

						$level = $tu->getLevel($datas['exp']);
					   $str = "";
					    if($level>30){ 
							$str = '300000金币,15个宝石,4份加两箱的道具，6份加6小时的道具';
						}
						else if($level>20){
							 
							$str = '150000金币,8个宝石,3份加两箱的道具，4份加6小时的道具';
						}
						else if($level>10){ 
							$str = '100000金币,5个宝石,2份加两箱的道具，2份加6小时的道具';
						}
						else{ 
							$str = '50000金币,3个宝石,1份加两箱的道具';
						} 
						
						echo "<div style='font-size:16px;margin:20px;'>你的补偿<span style='font-weigth:bold;color:red;'>$str</span>已经领取过了。<a href='".RenrenConfig::$canvas_url."'>返回游戏</a></div>";
					
					}
					?>
					 
			</div>			 
		
		</div>
	</div>
</div>
 


<xn:else>
<img src="<?php echo RenrenConfig::$resource_urlp ?>images/genericbg.jpg"/>
<script>
var auth = false;
function authOK()
{
	auth = true;
	document.setLocation("<?php echo RenrenConfig::$canvas_url;?>pay.php?"+Math.random() ) ;
}
function authKO()
{
	auth = false;
	document.setLocation("<?php echo RenrenConfig::$canvas_url;?>") ;
}
var is_install=document.getElementById('is_install');
if(!Session.isApplicationAdded() || is_install == null ){
	Session.requireLogin(authOK,authKO);
}
</script>

</xn:else>

</xn:if-is-app-user>

