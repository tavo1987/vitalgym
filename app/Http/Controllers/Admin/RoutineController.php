<?php

namespace App\Http\Controllers\Admin;

use File;
use Illuminate\Http\Request;
use App\VitalGym\Entities\Level;
use App\VitalGym\Entities\Routine;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CreateRoutineFormRequest;

class RoutineController extends Controller
{
    public function index()
    {
        $routines = Routine::with('level')->orderByDesc('created_at')->paginate();

        return view('admin.routines.index', compact('routines'));
    }

    public function create()
    {
        $levels = Level::all();

        return view('admin.routines.create', compact('levels'));
    }

    public function store(CreateRoutineFormRequest $request)
    {
        Routine::create([
            'level_id' => $request->get('level_id'),
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'file' => $request->file('file')->store('files'),
        ]);

        return redirect()->route('admin.routines.index')->with(['message' => 'Rutina guardada con éxito', 'alert-type' => 'success']);
    }

    public function show($routineId)
    {
        $routine = Routine::with('level')->findOrFail($routineId);

        return view('admin.routines.show', compact('routine'));
    }

    public function edit($routineId)
    {
        //
    }

    public function update(Request $request, $routineId)
    {
        //
    }

    public function destroy($routineId)
    {
        $routine = Routine::findOrFail($routineId);
        Storage::delete($routine->file);
        $routine->delete();

        return redirect()->route('admin.routines.index')->with(['message' => 'Rutina Eliminada con éxito', 'alert-type' => 'success']);
    }

    public function downloadFile($routineId)
    {
        $routine = Routine::findOrFail($routineId);

        if ($routine->file) {
            $extension = File::extension($routine->file);
            $fileName = str_slug($routine->name).'.'.$extension;

            return Storage::download($routine->file, $fileName);
        }

        return redirect()->back()->with(['message' => 'El archivo no se econtró', 'alert-type' => 'error']);
    }
}
