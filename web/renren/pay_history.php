<?php
require_once('config.php');
include "./header.php";

$pid =   $_REQUEST['xn_sig_user'];  
$sess=TTGenid::getbypid($pid);
$user = new TTUser($sess['id']);
$gem = $user->chGem(0);
$u = $sess['id'];

$ot = TT::get_tt('order');  
$q = $ot->getQuery();
if($u)
  $q->addCond('uid', TokyoTyrant::RDBQC_NUMEQ,$u); 
$q->addCond('status', TokyoTyrant::RDBQC_NUMEQ,1);	  

$q->setLimit(100);
$rets = $q->search();
	
 
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
.pay-form {
padding:10px 30px;
 }
.pay-form h2 {
font-size:14px;
font-weight:normal;
padding:10px 30px;
}
.pay-type{
padding-left: 30px;
}
.pay-type li div {
text-indent:-9999px;
}
.pay-type li {
	background:url("<?php echo RenrenConfig::$resource_urlp ?>/images/payment.png") no-repeat scroll center top transparent;
	float:left;
	height:210px;
	padding:10px 40px;
	position:relative;
	text-align:center;
	width:86px;
}
.pay-type li input {
background:url("<?php echo RenrenConfig::$resource_urlp ?>/images/payment.png") no-repeat scroll center top transparent;
 background-position: -19px -205px;
border:0 none;
bottom:24px;
cursor:pointer; 
height:50px;
position:absolute;
right:26px;
width:120px;
}
.pay-type li.gem-100 {
background-position: 0;
}
.pay-type li.gem-200 {
background-position:-166px 50%;
}
.pay-type li.gem-500 {
background-position:-332px 50%;
}
.pay-type li.gem-1000 {
background-position:-498px 50%
}
.payment-type label{
padding-right:20px;
}


.pay-tab {
background:url("<?php echo RenrenConfig::$resource_urlp ?>images/pay_feedbottombg.gif") repeat-x scroll center bottom transparent;
clear:both;
margin-left:30px;
overflow:hidden;
padding-left:10px;
}
.pay-tab li.current {
background:url("<?php echo RenrenConfig::$resource_urlp ?>images/pay_menubg.gif") no-repeat scroll left -72px transparent;
}
.pay-tab ul li {
background-image:url("<?php echo RenrenConfig::$resource_urlp ?>images/pay_menubg.gif");
background-position:left -179px;
background-repeat:no-repeat;
float:left;
font-size:14px;
margin-left:3px;
margin-right:5px;
overflow:hidden;
padding-left:5px;
text-align:center;
}

.pay-tab li.current a {
background:url("<?php echo RenrenConfig::$resource_urlp ?>images/pay_menubg.gif") no-repeat scroll right 1px transparent;
color:#333333 !important;
font-weight:bold;
padding:0 15px 0 10px;
}
.pay-tab li a {
background:url("<?php echo RenrenConfig::$resource_urlp ?>images/pay_menubg.gif") no-repeat scroll right -179px transparent;
display:block;
float:left;
font-weight:bold;
height:31px;
line-height:31px;
margin-left:-3px;
padding:0 15px 0 10px;
}
.pay-tab li a:hover{
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
					<li class="payment" ><a  class="active" href="<?php echo RenrenConfig::$canvas_url;?>pay.php"   id ="pay">充值</a></li>
				</ul>
				</div>
				</div>
			</div>
		
		    <div id='pay-body'>
				<div class='user-info'>
					<span class='avatar'>
						<xn:profile-pic uid="<?php echo $pid;?>" linked="false" size="tiny" />
					</span>
					<h2><xn:name uid="<?php echo $pid;?>" linked="false" shownetwork="false" /></h2>
					<p>
						<label>
							宝石余额: <span class='gem' id='gemValue'><?php echo $gem; ?></span>
						</label>
					</p>
				</div>
				
				<div class='pay-tab'> 
						<ul style="clear:both;">
							<li><a target="_top" href="<?php echo RenrenConfig::$canvas_url;?>pay.php?f=pay_history">充值宝石</a></li>
						     <li class="current"><a href="#nogo">充值记录</a></li>
							 <li style='display:none'><a target="_top" href=" " >消费记录</a></li>
						</ul>
 				</div>
				
				<div class='pay-form'>
				     <table style='margin-left:40px;width:700px;'>
						<tr style='font-weight:bold;font-size:12px;'>
							<td>订单号</td><td>人人豆</td><td>宝石数</td> 
						</tr>
						
						
						
						<?php foreach($rets as $ordernum =>$order){ ?>
							<tr style='font-weight:normal;font-size:12px;'>
							  <td><?php echo $ordernum; ?></td>
							  <td><?php echo $order['amount']; ?></td>
							  <td><?php echo $order['gem']; ?></td>
						 
							</tr>
							
						<?php } ?>
						
 					 
					 </table>
				 </div> 
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

