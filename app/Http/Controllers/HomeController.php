<?php

namespace App\Http\Controllers;

use App\Models\FormBuilder;
use App\Models\User;
use App\Models\UserAssignForm;
use App\Models\UserFormData;
use Illuminate\Http\Request;

class HomeController extends Controller
{


    public function formBuilder($id)
    {
        $form = FormBuilder::find($id);
        return view('builder_edit', compact('form'));
    }



    public function index()
    {
        $forms = FormBuilder::all();
        $users = User::where('user_type', '0')->get();
        $assignedForms = UserAssignForm::all();
        return view('home', compact('forms', 'users', 'assignedForms'));
    }

    public function saveForm(Request $request)
    {
        $htmlData = $request->html;
        $jsonData = $request->json;

        $id = $request->id;
        $formBuilder = FormBuilder::find($id);
        if (!$formBuilder) {
            $formBuilder = new FormBuilder;
        }
        $formBuilder->html_content = $htmlData;
        $formBuilder->json_content = $jsonData;
        $formBuilder->name = $request->name;
        $formBuilder->save();

        return response()->json(['success' => 'Form is successfully submitted!']);
    }

    public function assignForm(Request $request)
    {
        $assignForm = new UserAssignForm;
        $assignForm->user_id = $request->user_id;
        $assignForm->form_id = $request->form_id;
        $assignForm->save();

        return back()->with('success', 'Form is successfully assigned to the user!');
    }

    public function addForm($id)
    {
        $assign = UserAssignForm::find($id);
        /*$form = FormBuilder::find($assign->form_id);
        $form->html_content = json_decode($assign->form->html_content, true);
        $form->save();*/
        return view('forms.create', compact('assign'));
    }

    public function editForm($id)
    {
        $formData = UserFormData::find($id);
        $values = json_decode($formData->values, true);
        $allValues = [];
        foreach ($values as $key => $value) {
            $allValues[$value['name']] = $value['value'];
        }
        return view('forms.edit', compact('formData', 'allValues'));
    }
    public function viewForm($id)
    {
        $formData = UserFormData::find($id);
        $values = json_decode($formData->values, true);
        $allValues = [];
        foreach ($values as $key => $value) {
            $allValues[$value['name']] = $value['value'];
        }
        return view('forms.view', compact('formData', 'allValues'));
    }

    public function updateForm(Request $request, $id)
    {
        $formData = [];

        // Loop through the request data
        foreach ($request->except('_token') as $key => $value) {
            // Check if the input is a file
            if ($request->hasFile($key)) {
                // Handle file upload
                $file = $request->file($key);
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move('uploads', $fileName);


                // Add file information to formData array
                $formData[] = [
                    'name' => $key,
                    'type' => 'file',
                    'value' => "uploads/$fileName"
                ];
            } else {
                // Add the input (name, type, value) to the formData array
                $formData[] = [
                    'name' => $key,
                    'type' => gettype($value),
                    'value' => $value
                ];
            }
        }

        $assign = UserAssignForm::find($id);

        $userFormData = $assign->formData;
        if (!$userFormData) {
            $userFormData = new UserFormData;
        }
        $userFormData->form_id = $request->form_id;
        $userFormData->user_id = $request->user_id;
        $userFormData->assign_form_id = $id;
        $userFormData->values = json_encode($formData);
        $userFormData->form_data = $assign->form->json_content;
        $userFormData->save();

        return redirect()->route('home')->with('success', 'Form is successfully submitted!');


    }

    public function deleteForm($id)
    {
        $form = FormBuilder::find($id);
        $form->delete();
        return back()->with('success', 'Form is successfully deleted!');
    }

    public function deleteAssignForm($id)
    {
        $assignForm = UserAssignForm::find($id);
        $assignForm->delete();
        return back()->with('success', 'Form is successfully deleted!');
    }
}
