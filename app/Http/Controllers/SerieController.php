<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App \ Series;

class SerieController extends Controller
{
    public function index(Request $request){
        $series = Series::orderBy('id' , 'desc')->get();
        return ['series' => $series];
    }

    public function store(Request $request){

        //php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravel5"
        // composer require intervention/image

        $name = '';
       
        if($request->portada)
        {
          
           $name = time().'.' . explode('/', explode(':', substr($request->portada, 0, 
           strpos($request->portada, ';')))[1])[1];

           \Image::make($request->portada)->save(public_path('images/').$name);
         }


        $series = new Series();
        $series->nombre = $request->nombre;
        $series->descripcion = $request->descripcion;
        $series->portada = $name ;
        $series->save();
    }

    
    public function destroy($id){

        $series = Series::find($id);
        $series->delete();

    }
}
