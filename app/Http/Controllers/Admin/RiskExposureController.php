<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\RiskExposure;
use App\Http\Requests\CreateRiskExposureRequest;
use App\Http\Requests\UpdateRiskExposureRequest;
use Illuminate\Http\Request;



class RiskExposureController extends Controller {

	/**
	 * Display a listing of riskexposure
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $riskexposure = RiskExposure::all();

		return view('admin.riskexposure.index', compact('riskexposure'));
	}

	/**
	 * Show the form for creating a new riskexposure
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.riskexposure.create');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$riskexposure = RiskExposure::find(decrypt($id));
		
		
		$view = "view";
		return view('admin.riskexposure.show', compact('riskexposure', 'view' ));
	}


	/**
	 * Store a newly created riskexposure in storage.
	 *
     * @param CreateRiskExposureRequest|Request $request
	 */
	public function store(CreateRiskExposureRequest $request)
	{
	    
		RiskExposure::create($request->all());

		return redirect()->route('admin'.'.riskexposure.index');
	}

	/**
	 * Show the form for editing the specified riskexposure.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$riskexposure = RiskExposure::find(decrypt($id));
	    
	    
		return view('admin.riskexposure.edit', compact('riskexposure'));
	}

	/**
	 * Update the specified riskexposure in storage.
     * @param UpdateRiskExposureRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateRiskExposureRequest $request)
	{
		$riskexposure = RiskExposure::findOrFail(decrypt($id));

        

		$riskexposure->update($request->all());

		return redirect()->route('admin'.'.riskexposure.index');
	}

	/**
	 * Remove the specified riskexposure from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		RiskExposure::destroy(decrypt($id));

		return redirect()->route('admin'.'.riskexposure.index');
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
            RiskExposure::destroy($toDelete);
        } else {
            RiskExposure::whereNotNull('id')->delete();
        }

        return redirect()->route('admin'.'.riskexposure.index');
    }

}
