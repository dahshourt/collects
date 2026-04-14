<?php

namespace App\Http\Controllers\Workflows;

use App\Http\Controllers\Controller;
use App\traits\LogsActivity;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\workflow;
use App\Models\Status;
use App\Models\group;
use App\Models\transaction_type;

use App\Http\Requests\Workflows\EditRequest;
use App\Http\Requests\Workflows\StoreRequest;
use Illuminate\Http\Request;

class WorkflowController extends Controller
{
    use ValidatesRequests, LogsActivity;

    private $model;
    private $allowedUsers = [
        'walid.dahshour',
        'sara.mostafa',
        'Ahmed.O.Hasan',
        'ahmed.elfeel',
        'Mahmoud.bastawisy',
    ];

    function __construct()
    {
        $this->model = new workflow;
        $this->view  = 'workflows';
        $view        = 'workflows';
        $route       = 'workflows';
        $title       = 'workflows';
        $form_title  = 'Workflow';
        view()->share(compact('view', 'route', 'title', 'form_title'));
    }

    private function isAllowedUser()
    {
        $user = \Auth::user();
        return in_array($user->user_name, $this->allowedUsers);
    }

    public function index()
    {
        $collection = $this->model->all();
        $this->writeLog('Workflow', 'Viewed workflow rules list', 'View', 'Workflow Management');
        return view("$this->view.index", compact('collection'));
    }

    public function create()
    {
        $statuses          = Status::all();
        $groups            = group::all();
        $transaction_types = transaction_type::all();
        return view("$this->view.create", compact('statuses', 'groups', 'transaction_types'));
    }

    public function store(StoreRequest $request)
    {
        $this->model->create($request->except('_token'));

        $this->writeLog(
            'Workflow',
            'Created new workflow rule | ' . $this->formatRequestDetails($request->except('_token')),
            'Create',
            'Workflow Management'
        );

        return redirect()->back()->with('status', 'Created Successfully');
    }

    public function show($id)
    {
        $row  = $this->model->find($id);
        $show = 'disabled';
        $this->writeLog('Workflow', 'Viewed workflow rule ID: ' . $id, 'View', 'Workflow Management');
        return view("$this->view.show", compact('row', 'show'));
    }

    public function edit($id)
    {
        $row               = $this->model->find($id);
        $statuses          = Status::all();
        $groups            = group::all();
        $transaction_types = transaction_type::all();
        $this->writeLog('Workflow', 'Opened edit form for workflow rule ID: ' . $id, 'View', 'Workflow Management');
        return view("$this->view.edit", compact('row', 'statuses', 'groups', 'transaction_types'));
    }

    public function update(EditRequest $request, $id)
    {
        $this->model->where('id', $id)->update($request->except('_token', '_method', 'id'));

        $this->writeLog(
            'Workflow',
            'Updated workflow rule ID: ' . $id . ' | Changed fields: '
                . $this->formatRequestDetails($request->except(['_token', '_method', 'id'])),
            'Update',
            'Workflow Management'
        );

        return redirect()->back()->with('status', 'Updated Successfully');
    }

    public function destroy(Request $request, $id)
    {
        if (!$this->isAllowedUser()) {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        if ($request->ajax()) {
            $workflow = $this->model->find($id);

            if ($workflow) {
                $workflowName = $workflow->name ?? $id;
                $workflow->delete();

                $this->writeLog(
                    'Workflow',
                    'Deleted workflow rule ID: ' . $id . ' | Name: ' . $workflowName,
                    'Delete',
                    'Workflow Management'
                );

                return response()->json(['msg' => 'Deleted successfully', 'status' => 'success']);
            } else {
                return response()->json(['msg' => 'Workflow not found', 'status' => 'failed']);
            }
        }

        return redirect()->route('workflows.index')->with('error', 'Invalid request');
    }
}
