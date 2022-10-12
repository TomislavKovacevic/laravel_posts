<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use App\Models\Message;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function index()
    {
        $all_ads = new Ad;

        if (isset(request()->cat)) 
        {
            $all_ads = Ad::whereHas("category",function ($query)
            {
                $query->whereName(request()->cat);
            });
        } 

        if(isset(request()->type))
        {
            $type = (request()->type == "lower") ? "asc" : "desc";
            $all_ads = $all_ads->orderBy("price",$type);
        }
        $all_ads = $all_ads->get();
        $categories = Category::all(); //uzimamo sve kategorije od modela Category

        return view("welcome",compact("all_ads","categories")); //kroz compact metodu saljemo sve oglase 
                                                                //i kategorije na welcom stranicu
    }

    public function show($id)  //preuzimamo $id
    {
        $single_ad = Ad::find($id); //model Ad da pronadje $id

        if(auth()->check() && auth()->user()->id !== $single_ad->user_id)
        {
            $single_ad->increment("views");
        }
        return view("singleAd",compact("single_ad"));
    }

    public function sendMessage(Request $request, $id){
        $ad = Ad::find($id); //koji oglas

        //sta nam sve treba za novu poruku mozemo videti u bazi -- migration
        $ad_owner = $ad->user; //vlasnik oglasa

        //nova poruka
        $new_msg = new Message();
        $new_msg->text = $request->msg; //msg smo nazvali textarea name
        $new_msg->sender_id = auth()->user()->id;
        $new_msg->receiver_id = $ad_owner->id;
        $new_msg->ad_id = $ad->id;
        $new_msg->save();

           //Mesage::create([
           // "text"->$request->msg,
           // "sender_id" => auth()->user()->id;
           // ...
           // za ovakav način je potreban fillable
           // ]);

           return redirect()->back()->with("message","Message sent");
    }
}