<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use App\Models\Message;
use App\Models\User;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$all_ads = Ad::where("user_id", Auth::user()->id)->get();
        //iz modela AD uzimamo user_id koji je jednak logovanom useru (Auht:user())

        //bilji nacin za preuzimanje svih oglasa odredjenog usera jeste da odemo u user model
        //jer user postavlja oglase
        $all_ads = Auth::user()->ads;
        return view('home', ["all_ads" => $all_ads]);
    }

    
    public function addDeposit()
    {
        return view('home.addDeposit');
    }

    
    public function updateDeposit(Request $request)  //prihvatamo request u promenjivu $request
    {
        $user = Auth::user();

        $request->validate([
            "deposit"=>"required|max:4"   
        ],
        [
            "deposit.max"=>"Cant add more then 9999 rsd at once"

        ]);

        $user->deposit = $user->deposit + $request->deposit;
        $user->save();

        return redirect(route("home"));    
    }

    public function showAdForm()
    {
       $allCategories = Category::all();
       
       return view("home.showAdForm", ["categories"=>$allCategories]);
    }

    public function saveAd(Request $request)
    {
       $request -> validate([
        "title"=>"required | max:255",
        "body"=>"required",
        "price"=>"required",
        "image1"=>"mimes:jpeg,jpg,png", //samo ovi formati mogu da se koriste, fukcija mimes to omogucava
        "image2"=>"mimes:jpeg,jpg,png",
        "image3"=>"mimes:jpeg,jpg,png",
        "category"=>"required"
       ]);

       if($request->hasFile("image1")){ //da li u request-u ima file image1 
        $image1 = $request->file("image1"); //ako je true, našu sliku smeštamo u promenjivu $image1
        $image1_name = time()."1.".$image1->extension();// odredjujemo da slika koju prihvatamo ima jedinstven naziv
                                                        //dodeljujemo joj jedinstven naziv $image1_name
        $image1->move(public_path("ad_images"),$image1_name);//čuvamo sliku koja ima jedinstveni naziv u public folder
       }

       if($request->hasFile("image2")){
        $image2 = $request->file("image2"); 
        $image2_name = time()."2.".$image2->extension();                                                        
        $image2->move(public_path("ad_images"),$image2_name);
       }

       if($request->hasFile("image3")){
        $image3 = $request->file("image3"); 
        $image3_name = time()."3.".$image3->extension();                                                        
        $image3->move(public_path("ad_images"),$image3_name);
       }

       Ad::create([  //Ad je model, omogućava nam upis u bazu. Unosimo sva polja iz migracie 
        "title"=>$request->title,
        "body"=>$request->body,
        "price"=>$request->price,
        "image1"=>(isset($image1_name)) ? $image1_name : null, //ako je korisnik uneo sliku isset funkcija
                                                                //upisi u bazu $image_name, a ako nije uneo null
        "image2"=>(isset($image2_name)) ? $image2_name : null,
        "image3"=>(isset($image3_name)) ? $image3_name : null,
        "user_id"=>Auth::user()->id, //daj mi id aktivnog usera   //moze i ovako auth()->id()
        "category_id"=>$request->category //ne pisemo category_id jer u formi imamo definisano
       ]);

       return redirect(route("home"));

       //kad sve ovo unesemo idemo u Model gde ćemo odobriti upis u bazu, tj ništa ne branimo pri upisu

    }

    public function showSingleAd($id)  //preuzimamo id
    {
        $single_ad = Ad::find($id);    //obracamo se Modelu da pronadje id

        return view("home.singleAd",["single_ad"=>$single_ad]);
    }


    public function showMessages()
    {
        //zanima nas koj je receiver, pa od trenutnog korisnika uzimamo id
        $messages = Message::where("receiver_id",auth()->user()->id)->get();
        return view("home.messages", compact("messages"));
    }

    public function replay()
    {
        $sender_id = request()->sender_id;
        $ad_id = request()->ad_id;

        $messages = Message::where("sender_id",$sender_id)->where("ad_id",$ad_id)->get();
        
        return view("home.replay", compact("sender_id","ad_id","messages"));
    }

    public function replayStore(Request $request)
    {
        $sender = User::find($request->sender_id);
        $ad = Ad::find($request->ad_id);
        
        //nova poruka 

        $new_msg = new Message();
        $new_msg->text = $request->msg;
        $new_msg->sender_id = auth()->user()->id;
        $new_msg->receiver_id = $sender->id;
        $new_msg->ad_id = $ad->id;
        $new_msg->save();

        return redirect()->route("home.showMessages")->with("message","Replay sent");
    }

}