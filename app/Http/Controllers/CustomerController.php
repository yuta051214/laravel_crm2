<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\PostCodeRequest;

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
        // return view('customers.index', compact('customers'));

        // 取得したデータの中心地を求める
        $latitude = $customers->average('latitude');
        $longitude = $customers->average('longitude');
        $zoom = 5;

        return view('customers.index', compact('customers', 'latitude', 'longitude', 'zoom'));
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
    public function create(PostCodeRequest $request)
    {
        $method = 'GET';
        $zipcode = $request->post_code;
        $url = 'https://zipcloud.ibsnet.co.jp/api/search?zipcode=' . $zipcode;

        $client = new Client();
        $response = $client->request($method, $url);
        $body = $response->getBody();
        $zip_cloud = json_decode($body, true);

        if ($zip_cloud['status'] == 200) {
            // 正常(status: 200)時の処理
            $result = $zip_cloud['results'][0];
            $address = $result['address1'] . $result['address2'] . $result['address3'];
            $post_code = $result['zipcode'];
            $latitude = 35.658584;
            $longitude = 139.7454316;
            $zoom = 10;
            return view('customers.create', compact('address', 'post_code', 'latitude', 'longitude', 'zoom'));
        } else {
            // エラー(statusが400、または500)時の処理
            $message = $zip_cloud['message'];
            return view('/customers/post_code', compact('message'));
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $customer = new Customer;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->post_code = $request->post_code;
        $customer->address = $request->address;
        $customer->tel = $request->tel;
        $customer->latitude = $request->latitude;
        $customer->longitude = $request->longitude;
        $customer->save();
        return redirect()->route('customers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        $latitude = $customer->latitude;
        $longitude = $customer->longitude;
        $zoom = 12;
        
        return view('customers.show', compact('customer', 'latitude', 'longitude', 'zoom'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        $latitude = $customer->latitude;
        $longitude = $customer->longitude;
        $zoom = 12;
        return view('customers.edit', compact('customer', 'latitude', 'longitude', 'zoom'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {
        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->post_code = $request->post_code;
        $customer->address = $request->address;
        $customer->tel = $request->tel;
        $customer->latitude = $request->latitude;
        $customer->longitude = $request->longitude;
        $customer->save();
        return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        return redirect()->route('customers.index');
    }
}
