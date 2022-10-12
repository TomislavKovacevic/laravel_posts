<?php

namespace App\Http\Controllers;

use DebugBar\DebugBar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PhoneController extends Controller
{
    public function index()
    {
        $all_phones = DB::table("phones")->get();

        //return view("phones.index",["all_phones"=>$all_phones]);
        return view ("phones.index",compact("all_phones"));
    }

    public function create()
    {
        return view("phones.create");
    }
   
    public function store(Request $request)
    {
        $request->validate([
            "name"=>"required",
            "brand"=>"required",
            "price"=>"required"
        ]);

            DB::table("phones")->insert(["name"=>$request->name,
            "brand"=>$request->brand, "price"=>$request->price]);

            return redirect ("/phones")->with("create", "Post CREATED");
    }

    public function edit($id)
    {
       //$phone = DB::select("SELECT * FROM phones WHERE id = :id", ["id"=>$id])[0];
       $phone = DB::table("phones")->find($id);
       return view ("phones.edit",compact("phone"));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name"=>"required",
            "brand"=>"required",
            "price"=>"required"
        ]);
        
         /*DB::update("UPDATE phones SET name= :name, brand= :brand, price =:price WHERE id= :id",
         ["name"=>$request->name, "brand"=>$request->brand, "price"=>$request->price, "id"=>$id]);*/
         DB::table("phones")->update(["name"=>$request->name,
        "brand"=>$request->brand,  "price"=>$request->price]);

        return redirect("/phones")->with("update", "Post UPDATED");
        //return redirect("/phones".$phones->id)->with("updated");
    }    
 

    public function destroy($id)
    {
        //DB::delete("DELETE FROM phones WHERE id = ?", [$id]);
        DB::table('phones')->delete($id);
        return redirect("/phones")->with("delete", "Post DELETED");;
    }
}
