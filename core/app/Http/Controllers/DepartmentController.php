<?php

namespace App\Http\Controllers;

use App\Datatables\RoleDatatable;
use App\Http\Forms\RoleForm;
use App\Http\Requests\RoleFormRequest;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;


class DepartmentController extends Controller
{
    // Display the department list
    public function index()
    {
        $title = __('app.department');
        $canAdminStaffEditDepartment = auth('admin')->user()->hasPermission('department.edit');
        $canAdminStaffAddDepartment = auth('admin')->user()->hasPermission('department.add');
        $departments = Department::all(); 
        return view('department.department', compact('title', 'departments', 'canAdminStaffEditDepartment', 'canAdminStaffAddDepartment'));
    }

    // Store a new department
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'display_name' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive'
        ]);

        // Debugging: Log the status received from the form
        Log::info('Status received:', ['status' => $request->status]);

        // Convert status to boolean (1 = Active, 0 = Inactive)
        $status = ($request->status === 'active') ? 1 : 0;

        // Debugging: Log the converted status before storing
        Log::info('Converted Status:', ['status' => $status]);

        Department::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'status' => $status
        ]);

        return redirect()->back()->with('success', __('app.department_added_successfully'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'display_name' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive'
        ]);

        // Debugging: Log request data
        Log::info('Update Request Data:', $request->all());

        // Convert 'active' to 1 and 'inactive' to 0
        $status = ($request->status == 'active') ? 1 : 0;

        // Find the department and update it
        $department = Department::findOrFail($id);
        $department->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'status' => $status
        ]);

        // Debugging: Check if update is successful
        Log::info('Updated Department:', $department->toArray());

        return redirect()->back()->with('success', __('app.department_updated_successfully'));
    }

}
