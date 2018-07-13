<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Risks;
use App\Http\Requests\CreateRisksRequest;
use App\Http\Requests\UpdateRisksRequest;
use Illuminate\Http\Request;

use App\RiskCategory;
use App\RiskLikelihood;
use App\RiskConsequence;
use App\RiskExposure;


class RisksController extends Controller {

	/**
	 * Display a listing of risks
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $risks = Risks::all();

		return view('admin.risks.index', compact('risks'));
	}

	/**
	 * Show the form for creating a new risks
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $riskcategory = RiskCategory::pluck("sTitle", "id")->prepend('Please select', 0);
$risklikelihood = RiskLikelihood::pluck("sTitle", "id")->prepend('Please select', 0);
$riskconsequence = RiskConsequence::pluck("sTitle", "id")->prepend('Please select', 0);
$riskexposure = RiskExposure::pluck("sTitle", "id")->prepend('Please select', 0);

	    
	    return view('admin.risks.create', compact("riskcategory", "risklikelihood", "riskconsequence", "riskexposure"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$risks = Risks::find(decrypt($id));
		$riskcategory = RiskCategory::pluck("sTitle", "id")->prepend('Please select', 0);
$risklikelihood = RiskLikelihood::pluck("sTitle", "id")->prepend('Please select', 0);
$riskconsequence = RiskConsequence::pluck("sTitle", "id")->prepend('Please select', 0);
$riskexposure = RiskExposure::pluck("sTitle", "id")->prepend('Please select', 0);

		
		$view = "view";
		return view('admin.risks.show', compact('risks', "riskcategory", "risklikelihood", "riskconsequence", "riskexposure", 'view' ));
	}


	/**
	 * Store a newly created risks in storage.
	 *
     * @param CreateRisksRequest|Request $request
	 */
	public function store(CreateRisksRequest $request)
	{
	    
		Risks::create($request->all());

		return redirect()->route('admin'.'.risks.index');
	}

	/**
	 * Show the form for editing the specified risks.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$risks = Risks::find(decrypt($id));
	    $riskcategory = RiskCategory::pluck("sTitle", "id")->prepend('Please select', 0);
$risklikelihood = RiskLikelihood::pluck("sTitle", "id")->prepend('Please select', 0);
$riskconsequence = RiskConsequence::pluck("sTitle", "id")->prepend('Please select', 0);
$riskexposure = RiskExposure::pluck("sTitle", "id")->prepend('Please select', 0);

	    
		return view('admin.risks.edit', compact('risks', "riskcategory", "risklikelihood", "riskconsequence", "riskexposure"));
	}

	/**
	 * Update the specified risks in storage.
     * @param UpdateRisksRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateRisksRequest $request)
	{
		$risks = Risks::findOrFail(decrypt($id));

        

		$risks->update($request->all());

		return redirect()->route('admin'.'.risks.index');
	}

	/**
	 * Remove the specified risks from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Risks::destroy(decrypt($id));

		return redirect()->route('admin'.'.risks.index');
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
            Risks::destroy($toDelete);
        } else {
            Risks::whereNotNull('id')->delete();
        }

        return redirect()->route('admin'.'.risks.index');
    }

}
