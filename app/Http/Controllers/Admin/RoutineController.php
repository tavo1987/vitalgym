<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateRoutineRequest;
use Illuminate\Support\Facades\Input;
use App\VitalGym\Entities\Routine;
use App\VitalGym\Entities\Level;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class RoutineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routines = Routine::with('level')->filter(request())->orderByDesc('created_at')->paginate();

        return view('admin.routines.index', compact('routines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levels = Level::all();
        return view('admin.routines.create',compact('levels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRoutineRequest $request)
    {
        $routine = new Routine;
        $routine->level_id = $request->get('level_id');
        $routine->name = $request->get('name');
        $routine->description = $request->get('description');
        $routine->file = $request->hasFile('file') ? $request->file('file')->store('files', 'public') : 'files/routines-files';

        $routine->save();

        return redirect()->route('routines.index')->with(['message' => 'Rutina guardada con éxito', 'alert-type' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $routine = Routine::with('level')->findOrFail($id);
        return view('admin.routines.show',compact('routine'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function downloadFile(Routine $routine)
    {
        return Storage::download($routine->file);
    }
}
