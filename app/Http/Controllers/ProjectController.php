<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
   // all projects
    public function index()
    {
        $projects = Project::all()->toArray();
        return array_reverse($projects);
    }

    // add project
    public function add(Request $request)
    {
        $project = new Project([
            'name' => $request->input('name'),
            'client' => $request->input('client'),
            'client_addr' => $request->input('client_addr'),
            'progress' => 0,
            'deadline' => $request->input('deadline'),
            'total_price' => $request->input('total_price'),
            'description' => $request->input('description'),
        ]);
        $project->save();

        return response()->json('The project successfully added');
    }

    // edit project
    public function edit($id)
    {
        $project = Project::find($id);
        return response()->json($project);
    }

    // update project
    public function update($id, Request $request)
    {
        $project = Project::find($id);
        $project->update($request->all());

        return response()->json('The project successfully updated');
    }

    // delete project
    public function delete($id)
    {
        $project = Project::find($id);
        $project->delete();

        return response()->json('The project successfully deleted');
    }
}
