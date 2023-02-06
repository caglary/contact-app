<?php

namespace App\Http\Controllers;

use Faker\Factory;
use App\Models\Kayit;
use App\Models\Musteri;
use Illuminate\Http\Request;
use Illuminate\Support\facades\DB;
use Illuminate\Support\Facades\Redirect;

class MusteriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(){
        
        return $this->GetAll();
        
    }
    public function GetAll(){
        $musteries=DB::table('musteries')->orderby('created_at','desc')->get();
        return view('treetoner.musteri.index',compact('musteries'));
    }
    public function musteriekle(Request $request){
        
        $musteri=new Musteri;
        $musteri->kurum_adi = $request->get('kurum_adi');
        $musteri->adi_soyadi = $request->get('adi_soyadi');
        $musteri->telefon_1 = $request->get('telefon_1');
        $musteri->telefon_2 = $request->get('telefon_2');
        $musteri->mail = $request->get('mail');
        $musteri->adres = $request->get('adres');
        $musteri->save();

        return $this->GetAll();
    }


    public function show($id){
        $musteri=Musteri::find($id);
        
        abort_if(!isset($musteri),404);
        
        return view('treetoner.musteri.show')->with('musteri',$musteri);
    }


    public function delete($id){
        $musteri=Musteri::find($id);
        $siparis=Kayit::where('musteri_id',$id)->first();
        $exists = is_null($siparis);
        if ($exists) {
            $musteri->delete();
           
            return redirect('/');
        }
        else{
            $mesaj="Silmek istediğiniz muşteri için siparişler mevcut. Öncelikle müşteriye ait siparişleri silmelisiniz.";
            return redirect()->action(
                [MusteriController::class, 'show'], ['id' => $id]
            )->with('mesaj', $mesaj);
           
        }
    }
    public function edit($id){
        $musteri=Musteri::find($id);
        
        return view('treetoner.musteri.edit')->with('musteri',$musteri);
    }
    public function update(Request $request ,$id){
        $musteri=Musteri::find($id);
        
        $musteri->kurum_adi = $request->get('kurum_adi');
        $musteri->adi_soyadi = $request->get('adi_soyadi');
        $musteri->telefon_1 = $request->get('telefon_1');
        $musteri->telefon_2 = $request->get('telefon_2');
        $musteri->mail = $request->get('mail');
        $musteri->adres = $request->get('adres');

        $musteri->save();
        return view('treetoner.musteri.show')->with('musteri',$musteri);
        
        
    }

    /* data table içerisindeki search input kullanıldığı için bu fonksiyona gerek kalmadı. */
   /* 
    public function search(Request $request)
    {
        //$text =$request->get('search');
        $musteries = Musteri::when($request->search, function ($query, $text) {
            //return $query->where('adi_soyadi', $text);
            return $query->where('adi_soyadi','like','%'.$text.'%');

          })->paginate(10);
          return view('treetoner.musteri.index', ['musteries' => $musteries]);
      
    } */
}
