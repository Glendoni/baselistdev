<?php
class Checkout extends Pricing

	{
	public $price = 0;

	public $total = 0;

	public $pricing_rules;

	function __construct($pricing_rules)
		{
		$this->pricing_rules = $pricing_rules;
		}

	public

	function scan($cart)
		{ 
        /*
         @@@@ Not in demo but this is where access, 
         @@@@ permission and additional security checks could be set up
         */
		$this->price($cart);
		}
	}

class Pricing

	{
	protected
	function price($cart)
		{
		foreach($cart as $key => $cart_qty) //loop through cart array
			{
            //get pricing rule array
			$value = $this->pricing_rules[$key]; 
             /*
             @@@@ no rules match below conditions use default price
             */
			$price = ($value['price'] * $cart_qty);
            /*  
            @@@@ IF price rule deal_greater_qty is TRUE use deal price not default price    
            @@@@ if ordered quantity is greater than or equal to required deal qty threshold
            */
			if ($value['deal_greater_qty'] <= $cart_qty && $value['deal_greater_qty'] != null) //
				{
				$price = ($value['deal_price'] * $cart_qty);
				}
            /*  
            @@@@ If price rule buyOneGetOneFree is TRUE     
            @@@@ round the cart qty up to the nearest integrer, multiply then devide value
            */
			if ($value['buyOneGetOneFree'] != null && $cart_qty > 1)
				{
				$price = $value['price'] * ceil($cart_qty / 2) * 2 / 2;
				}
            /*  
            @@@@ store total in public variable price
            */
			$this->price = $this->price + $price;
			}
		}
	}

class Pricing_rules
{
    public function rules()
    {
        /*
        @@@  This data would normally be retrieved from a database
        */
        return array(
            'fr1' => array(
                'price' => 3.11,
                'deal_greater_qty' => null,
                'deal_price' => null,
                'buyOneGetOneFree' => 1
            ),
            'sr1' => array(
                'price' => 5.00,
                'deal_greater_qty' => 3,
                'deal_price' => 4.50,
                'buyOneGetOneFree' => null
            ),
            'cf1' => array(
                'price' => 11.23,
                'deal_greater_qty' => null,
                'deal_price' => null,
                'buyOneGetOneFree' => null
            )
        );
    }
}
    /*
        @@@Update the qty in the arrays to see the results       
    */    
 
    $pr = new Pricing_rules();
    $pricing_rules = $pr->rules();
    //BASEKET 1
    $basket_one = new Checkout($pricing_rules);
    //Reresents our incoming basket query
    $basket_one->scan(array(
        'fr1' => 3,
        'sr1' => 1,
        'cf1' => 1
    ));
    //BASEKET 2    
    $basket_two = new Checkout($pricing_rules);
        //Reresents our incoming basket query
    $basket_two->scan(array(
        'fr1' => 2
    ));
    //BASEKET 3
    $basket_three = new Checkout($pricing_rules);
        //Reresents our incoming basket query
    $basket_three->scan(array(
        'fr1' => 2,
        'sr1' => 3
    ));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Untitled Document</title>
    <meta charset="UTF-8">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</head>
<body>
    <h1>Smart Supermarket Checkout</h1>
    <p>Our supermarket's quest for global reach has prompted us to open a new supermarket - we sell only three products:</p>
    
<div class="row">
    <div class="col-sm-12">

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product code</th>
                    <th>Name</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>FR1</td>
                    <td>Fruit tea</td>
                    <td>£3.11</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>SR1</td>
                    <td>Strawberries</td>
                    <td>£5.00</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>CF1</td>
                    <td>Coffee</td>
                    <td>£11.23</td>
                </tr>

            </tbody>
        </table>
    
 </div>
</div>
    <div class="row">
    
   <div class="col-md-12">

 

   
<p>The CEO is a big fan of buy-one-get-one-free offers and of fruit tea. He wants us to add a rule to do this.</p>
 
<p>The COO likes low prices and wants people buying strawberries to get a price discount for bulk purchases. If you buy 3 or more strawberries, the price should drop to £4.50</p>
 
<p>Our check-out can scan items in any order, and because the CEO and COO change their minds often, it needs to be flexible regarding our pricing rules.</p>
 
<p>The interface to our checkout looks like this (shown in PHP):</p>
 
 <p>
 $co = new Checkout($pricing_rules);<br />
 $co->scan($item);<br />
 $co->scan($item);<br />
 $price = $co->total;</p>
 
<p>Implement a checkout system that fulfils these requirements.</p>
 
 
<p>Test data<br>
---------<br>
Basket: FR1,SR1,FR1,FR1,CF1<br>
Total price expected: £22.45</p>
 
<p>Basket: FR1,FR1<br>
Total price expected: £3.11</p>
 
<p>Basket: SR1,SR1,FR1,SR1<br>
Total price expected: £16.61</p>
 
    
    <h2>Results</h2>
            <h6>Update scan array key values to change the total </h6>
           <table class="table table-bordered">
        <thead>
            <tr>
                <th>Basket</th>
                <th>Total</th>
                
            </tr>
        </thead>
        
        <tbody>
             <tr>
                <td>1</td>
                <td><?=$basket_one->price;?></td>
               
            </tr>
            <tr>
                <td>2</td>
                <td><?=$basket_two->price;?></td>
               
            </tr>
            <tr>
                <td>3</td>
                <td><?=$basket_three->price;?></td>
              
            </tr>
        </tbody>
    </table>

       
       
         </div> </div>
</body>
</html>