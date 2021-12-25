<?php

namespace App\Http\Controllers\Practise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PractiseController extends Controller
{
   
    public function index(){
        Reservation::whereBetween('reservation_from', [$from1, $to1])
        ->orWhereBetween('reservation_to', [$from2, $to2])
        ->whereNotBetween('reservation_to', [$from3, $to3])
        ->get();  
        $people =array("Peter","Joe","Glenn","Cleveland"); 
            if(in_array("Joe",$people)){
                echo "Match found"; 
            }else{
            echo "Match is not found"; 

            }
     DB::table('analyser')
    ->selectRaw("concat(costumerDB.name, ' ', costumerDB.lastName) as name, costumerDB.telefon as telefon")
    ->leftJoin('costumerDB', 'analyser.kundnr', '=', 'costumerDB.kundnr')
    ->whereRaw('(sqrt(pow( ? - Y, 2) + pow( ? - X, 2))) < ?', [$x_center, $y_center, $radie])
    ->get();

  $subSelectSql=  "select product_id,item,sell_price  from products where prod_id in (select from products where sell_price> 1000)"; 

  $usersWithFlights = User::with(['flights'])->select()->addSelect(DB::raw('1 as number'))->get();

    }

    public function addSelect(){
        $students =Result::addSelect(['student_name'=>Student::select('name')->whereColumn('student_id','student.id')])->get();
        
        $data = DB::table("products")
          ->select("products.*",
        DB::raw("(SELECT SUM(products_stock.stock) FROM products_stock
            WHERE products_stock.product_id = products.id
            GROUP BY products_stock.product_id) as product_stock"),
        DB::raw("(SELECT SUM(products_sell.sell) FROM products_sell
            WHERE products_sell.product_id = products.id
            GROUP BY products_sell.product_id) as product_sell"))
          ->get();

//sub select in laravel 
          Products::whereIn('id', function($query){
            $query->select('paper_type_id')
            ->from(with(new ProductCategory)->getTable())
            ->whereIn('category_id', ['223', '15'])
            ->where('active', 1);
        })->get();

        DB::table('users')
            ->whereIn('id', function($query)
            {
                $query->select(DB::raw(1))
                      ->from('orders')
                      ->whereRaw('orders.user_id = users.id');})->get();

          $category_id = array('223','15');
          Products::whereIn('id', function($query) use ($category_id){
            $query->select('paper_type_id')
              ->from(with(new ProductCategory)->getTable())
              ->whereIn('category_id', $category_id )
              ->where('active', 1);
          })->get();


           $products = Product::where('name', 'like', "%$query%")
                           ->orWhere('details', 'like', "%$query%")
                           ->orWhere('description', 'like', "%$query%")
                           ->paginate(10);
        //INSTED OF
        $products = Product::search($query)->paginate(10);
    } 

      public function login(Request $req)
    {
          $req->validate([
              'username' => 'required|email|min:8|max:50',
              'password' => 'required|min:8|max:50'
          ]);

          $remember_me = $req->has('remember_me') ? true : false;

          $check = $req->only('username', 'password');
          
          if(Auth::attempt($check, $remember_me))
          {
              return redirect('admin/dashboard');
          }
          else
          {
              session()->put('error-msg', "Please enter the valid username and password");
              return redirect('admin/login');
          }
    }
      
      public function store(Request $request){
        if(in_array('Mango',$request->get('fruits'))){
           echo "User Likes Mango"; 
        }else{
          echo "User does not like mango"; 
        }
      }

 
public function storess(Request $request)
    {
    	$request->validate([
            'body'=>'required',
        ]);
   
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
    
        Comment::create($input);
   
        return back();
    }

    public function unions(){
      $student =DB::table('students')->where('id',2);
      $students =DB::table('students')->where('name','email')->union($student)->get();
      print_r($products);
    }

        public function indexx()
    {   
        $array1 = ['name' => 'steve', 'age' => 21];
        $exists1 = Arr::exists($array1, 'name');
        var_dump($exists1);
        echo "<br>";

        $array2 = ['language' => 'php', 'server' => 'apache'];
        $exists2 = Arr::exists($array2, 'name');
        var_dump($exists2);

        if (User::where('email', '=', Input::get('email'))->exists()) {
            // user found
        }

        $cartItems =Cart::getContent(); 
        foreach($cartItems as $item){
          if(is_array($item['conditions']) && !empty($item['conditions'])){
            $temp =[]; 
            foreach ($item['conditions'] as $key) {
              $temp =$key['name']; 
            }
          }
        }
  
    }

    public function stor(Request $request)
    {
        $coupon = Coupon::where('code', $request->coupon_code)->first();
        if (!$coupon) {
            return redirect()->back()->withErrors('Invalid coupon code. Please try again.');
        }
         $request->session()->put('coupon',  [
             'name' => $coupon->code,
             'amount' => $coupon->value,
             'amount_off' => $coupon->percent_off,
             'discount' => $coupon->value,
       
         ]);

        return redirect()->back()->with('success_message', 'Coupon has been applied!');
    }



    






}




