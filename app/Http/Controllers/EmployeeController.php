<?php

namespace App\Http\Controllers;

use App\Models\employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = ['id', 'name', 'bdate', 'gender', 'salary'];
        //using fields array in order to return only the important fields
        return employee::get($fields);
    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'bdate' => 'required|date|before:now',
            'gender' => 'required|string|min:1|max:1',
            'salary' => 'required|numeric|min:1'
        ]);

        return employee::create([
            'name' => $request['name'],
            'bdate' => $request['bdate'],
            'gender' => strtoupper($request['gender']),
            'salary' => $request['salary']

        ]);
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
        $employee = employee::findorfail($id);
        $request->validate([
            'name' => 'string',
            'bdate' => 'date|before:now',
            'gender' => 'string|min:1|max:1',
            'salary' => 'numeric|min:1'
        ]);
        $employee->update([
            'name' => $request['name'],
            'bdate' => $request['bdate'],
            'gender' => strtoupper($request['gender']),
            'salary' => $request['salary']

        ]);
        return $employee;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        return employee::destroy($id);
    }
}
