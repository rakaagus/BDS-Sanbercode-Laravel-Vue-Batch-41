<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use File;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['campaign'] = Campaign::all();
        if(count($data['campaign']) === 0){
            return response()->json([
                "response_code" => "00",
                "response_message" => "Data Campaign Masih Kosong",
            ], 200);
        }else{
            return response()->json([
                "response_code" => "00",
                "response_message" => "Data Berhasil Ditampilkan",
                "data" => $data
            ], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $request->validate([
            'title' => 'required|unique:campaigns,title',
            'description' => 'required',
            'address' => 'required',
            'image' => 'mimes:png,jpg,jpeg',
            'required' => 'required|numeric',
            'collected' => 'required|numeric',
        ]);

        $campaign = new Campaign;
        $campaign->title = $request->title;
        $campaign->description = $request->description;
        $campaign->address = $request->address;
        $campaign->required = $request->required;
        $campaign->collected = $request->collected;

        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_extension = $image->getClientOriginalExtension();
            $image_name = time().'.'.$image_extension;

            $image_path = '/photos/campaign/';
            $image_location = $image_path.$image_name;

            try{
                $image->move(public_path($image_path), $image_name);
                $campaign->image = $image_location;
            }catch(\Throwable $th){
                return response()->json([
                    "response_code" => "00",
                    "response_message" => "Image Gagal diupload",
                ], 400);
            }
        }

        $campaign->save();

        return response()->json([
            "response_code" => "00",
            "response_message" => "Tambah Campaign berhasil",
        ], 201);
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
        $data = Campaign::find($id);

        return response()->json([
            "response_code" => "00",
            "response_message" => "Detail Data Campaign Berhasil Ditampilkan",
            "data" => $data
        ], 200);
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
        $request->validate([
            'title' => 'required|unique:campaigns,title',
            'description' => 'required',
            'address' => 'required',
            'image' => 'mimes:png,jpg,jpeg',
            'required' => 'required|numeric',
            'collected' => 'required|numeric',
        ]);

        $campaign = Campaign::find($id);
        $campaign->title = $request->title;
        $campaign->description = $request->description;
        $campaign->address = $request->address;
        $campaign->required = $request->required;
        $campaign->collected = $request->collected;

        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_extension = $image->getClientOriginalExtension();
            $image_name = time().'.'.$image_extension;

            $image_path = '/photos/campaign/';

            $subCampaign = substr($campaign->image, 1);

            File::delete($subCampaign);

            $image_location = $image_path.$image_name;

            try{
                $image->move(public_path($image_path), $image_name);
                $campaign->image = $image_location;
            }catch(\Throwable $th){
                return response()->json([
                    "response_code" => "00",
                    "response_message" => "Image Gagal diupload",
                ], 400);
            }
        }

        $campaign->save();

        return response()->json([
            "response_code" => "00",
            "response_message" => "Update Campaign Berhasil",
        ], 201);
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
        $campaign = Campaign::find($id);
        $subCampaign = substr($campaign->image, 1);
        File::delete($subCampaign);
        $campaign->delete();
        return response()->json([
            "response_code" => "00",
            "response_message" => "berhasil Menghapus Campaig",
        ], 200);
    }
}
