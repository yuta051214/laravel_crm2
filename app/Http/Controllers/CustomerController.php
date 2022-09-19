<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use GuzzleHttp\Client;
use LDAP\Result;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', $customers);
    }


    public function post_code()
    {
        return view('customers.post_code');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $method = 'GET';
        $zipcode = $request->postcode;
        $url = 'https://zipcloud.ibsnet.co.jp/api/search?zipcode=' . $zipcode;

        $client = new Client();
        try {
            $response = $client->request($method, $url);
            $body = $response->getBody();
            $zip_cloud = json_decode($body, true);
            $result = $zip_cloud['results'][0];
            $address = $result['address1'].$result['address2'].$result['address3'];
            $post_code = $result['zipcode'];
        }catch(\Throwable $th){
            $address = null;
        }
        return view('customers.create')->with(compact('address', 'post_code'));
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
}
