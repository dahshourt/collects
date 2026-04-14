<?php

namespace App\Http\Controllers\Workflows;

use App\Http\Controllers\Controller;
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
    use ValidatesRequests;
    private $model;
    private $allowedUsers = [
       'walid.dahshour',
        'sara.mostafa',
        'Ahmed.O.Hasan',
        'ahmed.elfeel',
        'Mahmoud.bastawisy',
    ];
    function __construct(){
        
        $this->model = new workflow;
        $this->view = 'workflows';
        $view = 'workflows';
        $route = 'workflows';
        $title = 'workflows';
        $form_title = 'Workflow';
        view()->share(compact('view','route','title','form_title'));
        
    }
    private function isAllowedUser()
    {
      
        $user = \Auth::user();
     
        return in_array($user->user_name, $this->allowedUsers);
    }
    public function index()
    {
        $collection = $this->model->all();
        return view("$this->view.index",compact('collection'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
        //
		$statuses = Status::all();
		$groups = group::all();
		$transaction_types = transaction_type::all();
        return view("$this->view.create",compact('statuses','groups','transaction_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        //
        // $request->persist();
        $this->model->create($request->except('_token'));
        
        \App\Models\AdministrationLog::create([
            'user_id' => \Auth::id(),
            'category' => 'Workflow',
            'action' => 'Create',
            'details' => "Created a new workflow rule"
        ]);

        return redirect()->back()->with('status' , 'Created Successfully' );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $row = $this->model->find($id);
        $show = "disabled";
        return view("$this->view.show",compact('row','show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     
        $row = $this->model->find($id);
		$statuses = Status::all();
		$groups = group::all();
		$transaction_types = transaction_type::all();
        return view("$this->view.edit",compact('row','statuses','groups','transaction_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditRequest $request, $id)
    {
        // $request->persist($id);
        $this->model->where('id', $id)->update($request->except('_token','_method','id'));

        \App\Models\AdministrationLog::create([
            'user_id' => \Auth::id(),
            'category' => 'Workflow',
            'action' => 'Update',
            'details' => "Updated workflow rule ID: {$id}"
        ]);

        return redirect()->back()->with('status' , 'Upated Successfully' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
       
        // Check if the user is allowed to delete
        if (!$this->isAllowedUser()) {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        // Handle the deletion if it's an AJAX request
        if ($request->ajax()) {
          
            // Find the workflow by ID and delete it
            $workflow = $this->model->find($id);
    
            if ($workflow) {
                $workflow->delete();
                return response()->json(['msg' => 'Deleted successfully', 'status' => 'success']);
            } else {
                return response()->json(['msg' => 'Workflow not found', 'status' => 'failed']);
            }
        }
    
        // If not an AJAX request, redirect or handle accordingly
        return redirect()->route('workflows.index')->with('error', 'Invalid request');
    }
    
    
    

}
