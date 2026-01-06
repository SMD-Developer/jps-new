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
use DB;

class DepartmentController extends Controller
{
    // Display the department list
    public function index(Request $request)
    {
        $title = __('app.department');
        $canAdminStaffEditDepartment = auth('admin')->user()->hasPermission('department.edit');
        $canAdminStaffAddDepartment = auth('admin')->user()->hasPermission('department.add');
        
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        
        $departments = Department::query()
            ->when($search, function($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage);
        
        return view('department.department', compact(
            'title', 
            'departments', 
            'canAdminStaffEditDepartment', 
            'canAdminStaffAddDepartment',
            'perPage',
            'search'
        ));
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


    public function manageFaq(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        
        $faqs = DB::table('faqs')
            ->when($search, function($query, $search) {
                return $query->where('question', 'like', "%{$search}%")
                            ->orWhere('answer', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);
        
        $title = 'FAQ ';
        
        return view('department.faqList', compact('faqs', 'perPage', 'title'));
    }

    public function storeFaq(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'status' => 'required|in:0,1'
        ]);

        DB::table('faqs')->insert([
            'question' => $request->question,
            'answer' => $request->answer,
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json(['success' => true, 'message' => 'FAQ added successfully']);
    }


    public function updateFaq(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'status' => 'required|in:0,1'
        ]);

        DB::table('faqs')
            ->where('id', $id)
            ->update([
                'question' => $request->question,
                'answer' => $request->answer,
                'status' => $request->status,
                'updated_at' => now()
            ]);

        return response()->json(['success' => true, 'message' => 'FAQ updated successfully']);
    }

}
