<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\RiskConsequence;
use App\Http\Requests\CreateRiskConsequenceRequest;
use App\Http\Requests\UpdateRiskConsequenceRequest;
use Illuminate\Http\Request;



class RiskConsequenceController extends Controller {

	/**
	 * Display a listing of riskconsequence
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $riskconsequence = RiskConsequence::all();

		return view('admin.riskconsequence.index', compact('riskconsequence'));
	}

	/**
	 * Show the form for creating a new riskconsequence
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.riskconsequence.create');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$riskconsequence = RiskConsequence::find(decrypt($id));
		
		
		$view = "view";
		return view('admin.riskconsequence.show', compact('riskconsequence', 'view' ));
	}


	/**
	 * Store a newly created riskconsequence in storage.
	 *
     * @param CreateRiskConsequenceRequest|Request $request
	 */
	public function store(CreateRiskConsequenceRequest $request)
	{
	    
		RiskConsequence::create($request->all());

		return redirect()->route('admin'.'.riskconsequence.index');
	}

	/**
	 * Show the form for editing the specified riskconsequence.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$riskconsequence = RiskConsequence::find(decrypt($id));
	    
	    
		return view('admin.riskconsequence.edit', compact('riskconsequence'));
	}

	/**
	 * Update the specified riskconsequence in storage.
     * @param UpdateRiskConsequenceRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateRiskConsequenceRequest $request)
	{
		$riskconsequence = RiskConsequence::findOrFail(decrypt($id));

        

		$riskconsequence->update($request->all());

		return redirect()->route('admin'.'.riskconsequence.index');
	}

	/**
	 * Remove the specified riskconsequence from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		RiskConsequence::destroy(decrypt($id));

		return redirect()->route('admin'.'.riskconsequence.index');
	}

    /**
     * Mass delete function from index page
     * @param Request $request
     *
     * @return mixed
     */
    public function massDelete(Request $request)
    {
        if ($request->get('toDelete') != 'mass') {
            $toDelete = json_decode($request->get('toDelete'));

            foreach($toDelete as $row){
            	$toDelete[$row] = decrypt($row);
            }
            RiskConsequence::destroy($toDelete);
        } else {
            RiskConsequence::whereNotNull('id')->delete();
        }

        return redirect()->route('admin'.'.riskconsequence.index');
    }

}
