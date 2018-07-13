<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\RiskTreatmentOptions;
use App\Http\Requests\CreateRiskTreatmentOptionsRequest;
use App\Http\Requests\UpdateRiskTreatmentOptionsRequest;
use Illuminate\Http\Request;



class RiskTreatmentOptionsController extends Controller {

	/**
	 * Display a listing of risktreatmentoptions
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $risktreatmentoptions = RiskTreatmentOptions::all();

		return view('admin.risktreatmentoptions.index', compact('risktreatmentoptions'));
	}

	/**
	 * Show the form for creating a new risktreatmentoptions
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.risktreatmentoptions.create');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$risktreatmentoptions = RiskTreatmentOptions::find(decrypt($id));
		
		
		$view = "view";
		return view('admin.risktreatmentoptions.show', compact('risktreatmentoptions', 'view' ));
	}


	/**
	 * Store a newly created risktreatmentoptions in storage.
	 *
     * @param CreateRiskTreatmentOptionsRequest|Request $request
	 */
	public function store(CreateRiskTreatmentOptionsRequest $request)
	{
	    
		RiskTreatmentOptions::create($request->all());

		return redirect()->route('admin'.'.risktreatmentoptions.index');
	}

	/**
	 * Show the form for editing the specified risktreatmentoptions.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$risktreatmentoptions = RiskTreatmentOptions::find(decrypt($id));
	    
	    
		return view('admin.risktreatmentoptions.edit', compact('risktreatmentoptions'));
	}

	/**
	 * Update the specified risktreatmentoptions in storage.
     * @param UpdateRiskTreatmentOptionsRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateRiskTreatmentOptionsRequest $request)
	{
		$risktreatmentoptions = RiskTreatmentOptions::findOrFail(decrypt($id));

        

		$risktreatmentoptions->update($request->all());

		return redirect()->route('admin'.'.risktreatmentoptions.index');
	}

	/**
	 * Remove the specified risktreatmentoptions from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		RiskTreatmentOptions::destroy(decrypt($id));

		return redirect()->route('admin'.'.risktreatmentoptions.index');
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
            RiskTreatmentOptions::destroy($toDelete);
        } else {
            RiskTreatmentOptions::whereNotNull('id')->delete();
        }

        return redirect()->route('admin'.'.risktreatmentoptions.index');
    }

}
