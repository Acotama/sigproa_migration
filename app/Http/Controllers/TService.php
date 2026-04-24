<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use sayhuite\Logic\Tools\requestTipoCambio;

use sayhuite\Models\Taller_Img;
use Jenssegers\ImageHash\Implementations\DifferenceHash;
use Jenssegers\ImageHash\ImageHash;


class TService extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();
        //$TCambio = new requestTipoCambio($params['year'],$params['mes'],$params['dia']);

        //return $TCambio->processHtml();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return "here";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function hashimg(){
        $data = Taller_Img::select('id','url','nombre')->where('imghash','=',null)->get();

        $hasher = new ImageHash;

        //$image

        //$distance = $hasher->distance($hasher, $hasherD);


        foreach ($data as $key => $value) {

            $url   = $value['url'].'/'.$value['nombre'];
            $hash  = $hasher->hash( public_path() . '/images' . $url );
            //$hashD = $hasherD->hash( public_path() . '/images' . $url );
            //$hash,$hashD;
            $img   = Taller_Img::find($value['id']);
            $img->imghash = $hash;
            $img->save();
        }


    }

    /*public function hashimg2(){
        $image = Taller_Img::select('id','url','nombre','imghash')->first();

        $hasher = new ImageHash;

        $hash1 = $image['imghash'];


        $dbImages = Taller_Img::select('imghash')->where('imghash','!=',$hash1)->get();


        foreach ($dbImages as $key => $value) {

            $hash = $value['imghash'];

            $distance = $hasher->distance($hash1, $hash);

            echo $distance . '<br>';

            //$hash,$hashD;
            //$img   = Taller_Img::find($value['id']);
            //$img->imghash = $hash;
            //$img->save();
        }


    }*/
}
