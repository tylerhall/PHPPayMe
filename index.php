<?PHP
	require 'config.inc.php';
	require 'lib/Stripe.php';

	if(isset($_POST['txtAmount']))
	{
		Stripe::setApiKey($private_key);
		$token = $_POST['stripeToken'];

		try
		{
			$charge = Stripe_Charge::create(array(
		  		"amount" => $_POST['txtAmount'] * 100, // amount in cents, again
		  		"currency" => "usd",
		  		"card" => $token,
		  		"description" => "Payment from pay.clickontyler.com")
				);
				header('Location: /?payment=true');
				exit;
		}
		catch(Stripe_CardError $e)
		{
			header('Location: /?payment=false');
			exit;
		}	
	}	
?>
<html>
<head>
	<style type="text/css" media="screen">
		body { background-color:rgb(0, 139, 223); text-align:center; color:#fff; font-family:verdana; }
		p { font-size:11px; }
		p a { color:#fff; }
		.amount { font-size:36px; }
		.amount input { font-size:36px; width:5em; text-align:center; }
		
		.stripe-button-el {
		  overflow: hidden;
		  display: inline-block;
		  visibility: visible !important;
		  background-image: -webkit-linear-gradient(#28a0e5, #015e94);
		  background-image: -moz-linear-gradient(#28a0e5, #015e94);
		  background-image: -ms-linear-gradient(#28a0e5, #015e94);
		  background-image: -o-linear-gradient(#28a0e5, #015e94);
		  background-image: linear-gradient(#28a0e5, #015e94);
		  -webkit-font-smoothing: antialiased;
		  border: 0;
		  padding: 1px;
		  text-decoration: none;
		  -moz-border-radius: 5px;
		  -webkit-border-radius: 5px;
		  border-radius: 5px;
		  -moz-box-shadow: 0 1px 0 rgba(0,0,0,0.2);
		  -webkit-box-shadow: 0 1px 0 rgba(0,0,0,0.2);
		  box-shadow: 0 1px 0 rgba(0,0,0,0.2);
		  -webkit-touch-callout: none;
		  -webkit-tap-highlight-color: transparent;
		  -moz-user-select: none;
		  -khtml-user-select: none;
		  -webkit-user-select: none;
		  -ms-user-select: none;
		  -o-user-select: none;
		  user-select: none;
		  cursor: pointer;
		}
		.stripe-button-el::-moz-focus-inner {
		  border: 0;
		  padding: 0;
		}
		.stripe-button-el span {
		  display: block;
		  position: relative;
		  padding: 0 12px;
		  height: 30px;
		  line-height: 30px;
		  background: #1275ff;
		  background-image: -webkit-linear-gradient(#7dc5ee, #008cdd 85%, #30a2e4);
		  background-image: -moz-linear-gradient(#7dc5ee, #008cdd 85%, #30a2e4);
		  background-image: -ms-linear-gradient(#7dc5ee, #008cdd 85%, #30a2e4);
		  background-image: -o-linear-gradient(#7dc5ee, #008cdd 85%, #30a2e4);
		  background-image: linear-gradient(#7dc5ee, #008cdd 85%, #30a2e4);
		  font-size: 14px;
		  color: #fff;
		  font-weight: bold;
		  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
		  text-shadow: 0 -1px 0 rgba(0,0,0,0.25);
		  -moz-box-shadow: inset 0 1px 0 rgba(255,255,255,0.25);
		  -webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,0.25);
		  box-shadow: inset 0 1px 0 rgba(255,255,255,0.25);
		  -moz-border-radius: 4px;
		  -webkit-border-radius: 4px;
		  border-radius: 4px;
		}
	</style>
	<script src="https://checkout.stripe.com/v2/checkout.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js"></script>
</head>
<body>
	<h1>Pay Click On Tyler</h1>
	<?PHP if(!isset($_GET['payment'])) : ?>
	<p>Fill in the amount to pay and click "Pay with Card"<br>All payments are securely processed by <a href="http://stripe.com">Stripe</a></p>
	<form action="/" method="POST">
		<p class="amount">$<input type="text" name="txtAmount" value="0.00" id="txtAmount"></p>
		<button id="btnPay" type="submit" class="stripe-button-el">
			<span style="display:block; min-height:30px;">Pay with Card</span>
		</button>
	</form>
	<?PHP else : ?>
	<?PHP if($_GET['payment'] == 'true') : ?>
	<h2>Thanks for your payment!</h2>
	<?PHP else : ?>
	<h2>Card Declined. Please try again.</h2>
	<?PHP endif; ?>
	<?PHP endif; ?>
	<script type="text/javascript" charset="utf-8">
		$('#btnPay').click(function() {
			$('#btnPay').css('display', 'none');

			var token = function(res) {
				var input = $('<input type=hidden name=stripeToken />').val(res.id);
				$('form').append(input).submit();
			};
			
			StripeCheckout.open({
				key:         '<?PHP echo $public_key; ?>',
				amount:      $('#txtAmount').val() * 100,
				name:        'Click on Tyler Payment',
				panelLabel:  'Pay',
				token:       token
			});

			return false;
		});
	</script>
</body>
</html>