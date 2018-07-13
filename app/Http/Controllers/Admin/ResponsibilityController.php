<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Responsibility;
use App\Http\Requests\CreateResponsibilityRequest;
use App\Http\Requests\UpdateResponsibilityRequest;
use Illuminate\Http\Request;



class ResponsibilityController extends Controller {

	/**
	 * Display a listing of responsibility
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $responsibility = Responsibility::all();

		return view('admin.responsibility.index', compact('responsibility'));
	}

	/**
	 * Show the form for creating a new responsibility
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.responsibility.create');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$responsibility = Responsibility::find(decrypt($id));
		
		
		$view = "view";
		return view('admin.responsibility.show', compact('responsibility', 'view' ));
	}


	/**
	 * Store a newly created responsibility in storage.
	 *
     * @param CreateResponsibilityRequest|Request $request
	 */
	public function store(CreateResponsibilityRequest $request)
	{
	    
		Responsibility::create($request->all());

		return redirect()->route('admin'.'.responsibility.index');
	}

	/**
	 * Show the form for editing the specified responsibility.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$responsibility = Responsibility::find(decrypt($id));
	    
	    
		return view('admin.responsibility.edit', compact('responsibility'));
	}

	/**
	 * Update the specified responsibility in storage.
     * @param UpdateResponsibilityRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateResponsibilityRequest $request)
	{
		$responsibility = Responsibility::findOrFail(decrypt($id));

        

		$responsibility->update($request->all());

		return redirect()->route('admin'.'.responsibility.index');
	}

	/**
	 * Remove the specified responsibility from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Responsibility::destroy(decrypt($id));

		return redirect()->route('admin'.'.responsibility.index');
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
            Responsibility::destroy($toDelete);
        } else {
            Responsibility::whereNotNull('id')->delete();
        }

        return redirect()->route('admin'.'.responsibility.index');
    }

}
