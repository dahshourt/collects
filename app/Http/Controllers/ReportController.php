<?php

namespace App\Http\Controllers;
use  Session;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
//use App\Http\Requests\Reports\Api\ReportRequest;
use App\Factories\Reports\ReportFactory;
use App\Factories\Banks\BankFactory;
use App\Factories\Statuses\StatusFactory;

use App\Factories\Users\UserFactory;
use App\Factories\Groups\GroupFactory;
use App\Factories\Tickets\TicketsFactory;
use Auth;
use Illuminate\Http\Request;
use Excel;
use App\Exports\CMReportExport;
use App\Exports\EntrpReportExport; 
use Redirect;


 


class ReportController extends Controller
{
    use ValidatesRequests;
    private $Report;


    function __construct(ReportFactory $Report, UserFactory $User, GroupFactory $Group,BankFactory $Bank,StatusFactory $Status,TicketsFactory $Ticket ){

        $this->Report = $Report::index();
        $this->User=$User::index();
        $this->Group=$Group::index();
        $this->Bank=$Bank::index();
        $this->Status=$Status::index();
        $this->Ticket=$Ticket::index();



    }

    public function index()
    {
        $Reports = $this->Report->getAll();
        return "gg";
    }
public function cm_report()
{
   // dd(Auth::user());
    $users=$this->User->get_all_users();
    $groups=$this->Group->get_all_groups();
    $banks=$this->Bank->get_all_banks();
    $statuses=$this->Status->get_all_statuses();
    $market_segmets=$this->Ticket->get_all_market_segments();
    $trans_types=$this->Ticket->get_all_transaction_types();
  // dd($banks);
return view('reports.cm_report',compact('trans_types','market_segmets','users','groups','banks','statuses'));
}
public function report_result( Request $request)
{

    $creator_id = $request->input('creator_id');
    $customer_name = $request->input('customer_name');
    $account = $request->input('account');
    $market_segment_id = $request->input('market_segment_id');
    $bank = $request->input('receiver_bank_id');
    $transaction_type_id=  $request->input('transaction_type_id');
    $status = $request->input('status');
    $group_id = $request->input('group_id');
	
    $tickets=$this->Ticket->ticket_report($creator_id,$customer_name,$account,$market_segment_id,$bank,$transaction_type_id,$status,$group_id);
    $account=$request->input('account');
    
    \App\Models\AdministrationLog::create([
        'user_id' => \Auth::id(),
        'category' => 'Report',
        'action' => 'Search',
        'details' => "CM Report Search: " . json_encode($request->except('_token'))
    ]);

   return view('reports.report_result',compact('tickets'));

}

public function export_report()
{
$tickets=Session::get('cmreport');
//dd($tickets);
$data=array();
foreach($tickets as $ticket)
{

$data[]=array($ticket->creator->user_name,$ticket->customer_name,
$ticket->account,
$ticket->customer_type->name,
$ticket->market_segment->name,
$ticket->bank->name,
$ticket->transaction_type->name,
$ticket->status->name,
$ticket->group->name

);


}

return Excel::download(new CMReportExport($data), 'CM_Report.xlsx');


}
public function entp_report(Request $request)
{
    
	$groupMember = $this->User->getUserGroupsMember();
    $users=$this->User->get_all_users();
    $groups=$this->Group->get_all_groups();
    $banks=$this->Bank->get_all_banks();
    $statuses=$this->Status->get_all_statuses();
    $market_segmets=$this->Ticket->get_all_market_segments();
    $trans_types=$this->Ticket->get_all_transaction_types();
  // dd($banks);
return view('reports.entrp_report',compact('trans_types','market_segmets','users','groups','banks','statuses','groupMember'));
} 
public function entrp_report_result( Request $request)
{

    $created_at = $request->input('created_at');
	$end_created_at = $request->input('end_created_at');
    $customer_name = $request->input('customer_name');
    $bank_transaction_date = $request->input('bank_transaction_date');
    $transaction_amount = $request->input('transaction_amount');
    $ticket_num = $request->input('ticket_num');
    $account=$request->input('account');
    $transaction_type_id=  $request->input('transaction_type_id');
    $status = $request->input('status');
    $add_on_oracle_date = $request->input('add_on_oracle_date');
    $creator_name_id = $request->input('creator_name_id');
    
    $tickets=$this->Ticket->ticket_entrp_report
    ($created_at,$customer_name,$bank_transaction_date,$transaction_amount,
    $ticket_num,$account,$transaction_type_id,$status,$add_on_oracle_date,$end_created_at,$creator_name_id);

    \App\Models\AdministrationLog::create([
        'user_id' => \Auth::id(),
        'category' => 'Report',
        'action' => 'Search',
        'details' => "Enterprise Report Search: " . json_encode($request->except('_token'))
    ]);


   return view('reports.entrp_report_result',compact('tickets',
       'created_at',
       'end_created_at',
       'customer_name',
       'bank_transaction_date',
       'transaction_amount',
       'ticket_num',
       'account',
       'transaction_type_id',
       'status',
       'add_on_oracle_date',
       'creator_name_id'
       )
   );

}
public function export_entrp_report_result(Request $request)
{
     
     $tickets = $this->Ticket->ticket_entrp_report
    (
        $request->input('created_at'),
        $request->input('customer_name'),
        $request->input('bank_transaction_date'),
        $request->input('transaction_amount'),
        $request->input('ticket_num'),
        $request->input('account'),
        $request->input('transaction_type_id'),
        $request->input('status'),
        $request->input('add_on_oracle_date'),
        $request->input('end_created_at'),
        $request->input('creator_name_id'),
 
    );
    
        $data = array();
        foreach ($tickets as $key =>  $ticket) {
                $account = null;
                $amount = null;
                if(! empty($ticket['ticket_multiple_settlements'][0]['account']) AND ! empty($ticket['ticket_multiple_settlements'][0]['amount']))
                {
                    $account = $ticket['ticket_multiple_settlements'][0]['account'];
                    $amount = $ticket['ticket_multiple_settlements'][0]['amount'];
                }
            $data[] = array(
                $ticket->id,
                $ticket->created_at,
                $ticket->bank_transaction_date,
                $ticket->bank->name,
                $ticket->transaction_amount,
                $ticket->account,
                $ticket->transaction_type->name,
                preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $ticket->customer_name),
                $ticket->status->name,
                $ticket->group->name,
                $ticket->market_segment->name,
                $ticket->cheque_number,
                $ticket->add_on_oracle_date,
                $account,
                $amount
            );
             
            foreach($ticket->ticket_multiple_settlements as $key => $value)
            {
                if($key > 0)
                {
                    $data[] = array(
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    $value['account'],
                    $value['amount']
                    );
                }   
            
            }
        }
        
        return Excel::download(new EntrpReportExport($data), 'Entrpise Report Export.xlsx');
}
public function export_entrp_report()
{
    $tickets=Session::get('cashreport');
    //dd($tickets);
$data=array();
foreach($tickets as $ticket)
{

$data[]=array($ticket->created_at,$ticket->bank_transaction_date,
$ticket->transaction_amount,
$ticket->account,

$ticket->id,

$ticket->transaction_type->name,
$ticket->customer_name,

$ticket->status->name,

);


}

return Excel::download(new EntrpReportExport($data), 'Entrp_Report.xlsx');


}
public function collection_report()
{
   // dd(Auth::user());
    $users=$this->User->get_all_users();
    $groups=$this->Group->get_all_groups();
    $banks=$this->Bank->get_all_banks();
    $statuses=$this->Status->get_all_statuses();
    $market_segmets=$this->Ticket->get_all_market_segments();
    $trans_types=$this->Ticket->get_all_transaction_types();
  // dd($banks);
return view('reports.collection_report',compact('trans_types','market_segmets','users','groups','banks','statuses'));
}
public function cash_report()
{
   // dd(Auth::user());
    $users=$this->User->get_all_users();
    $groups=$this->Group->get_all_groups();
    $banks=$this->Bank->get_all_banks();
    $statuses=$this->Status->get_all_statuses();
    $market_segmets=$this->Ticket->get_all_market_segments();
    $trans_types=$this->Ticket->get_all_transaction_types();
  // dd($banks);
return view('reports.cash_report',compact('trans_types','market_segmets','users','groups','banks','statuses'));
}
public function cash_report_result( Request $request)
{

    $confirmation_date = $request->input('confirmation_date');
    $transaction_type_id = $request->input('transaction_type_id');
    $market_segment_id = $request->input('market_segment_id');
    $transaction_amount = $request->input('transaction_amount');
    $customer_name = $request->input('customer_name');
    $cheque_number = $request->input('cheque_number');
    $bank=$request->input('receiver_bank_id');
    $account=$request->input('account');
    $status = $request->input('status');
    $group_id=$request->input('group_id');

    $tickets=$this->Ticket->ticket_cash_report
    ($confirmation_date,$transaction_type_id,$market_segment_id,
    $transaction_amount,
    $customer_name,$cheque_number,$bank,$account,$status,$group_id);
//dd($tickets);

    \App\Models\AdministrationLog::create([
        'user_id' => \Auth::id(),
        'category' => 'Report',
        'action' => 'Search',
        'details' => "Cash Report Search: " . json_encode($request->except('_token'))
    ]);

   return view('reports.cash_report_result',compact('tickets'));

}
}
