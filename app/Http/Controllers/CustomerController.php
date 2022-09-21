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
        return view('customers.index')->with(compact('customers'));
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

        switch($zip_cloud['status']){
        case 400:
            return view('/customers/post_code', ['message' => $zip_cloud['message']]);
            break;
        case 500:
            return view('/customers/post_code', ['message' => $zip_cloud['message']]);
            break;
        case 200:
            $result = $zip_cloud['results'][0];
            $address = $result['address1'].$result['address2'].$result['address3'];
            $post_code = $result['zipcode'];
            return view('customers.create')->with(compact('address', 'post_code'));
            break;
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
        $customer->save();
        return redirect('/customers');
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
        return view('customers.show')->with(compact('customer'));
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
        return view('customers.edit')->with(compact('customer'));
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
        $customer->save();
        return redirect('/customers');
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
        return redirect('/customers');
    }
}
