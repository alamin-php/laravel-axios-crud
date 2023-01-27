<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;

class EmployeeController extends Controller
{
    // get all employee data
    public function index()
    {
        $employees = Employee::all();
        return view('employee.index', compact('employees'));
    }

    public function getAllEmployee()
    {
        return Employee::latest()->get();
    }

    // employee data store
    public function store(EmployeeRequest $request)
    {
        $data = $request->validated();
        Employee::create($data);
return 1;
    }
    //employee edit modal
    public function edit($id)
    {
        return Employee::find($id);
    }
    // employee udate data
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        $employee->name = $request->name;
        $employee->position = $request->position;
        $employee->salary = $request->salary;
        $employee->save();
        return $employee;
    }
    // employee data delete from database
    public function destroy($id)
    {
        Employee::find($id)->delete();
        return 'Deleted';
    }
}
