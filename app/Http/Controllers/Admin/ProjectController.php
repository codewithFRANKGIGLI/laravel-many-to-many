<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Str;
// validator
use Illuminate\Support\Facades\Validator;
// rule
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\Type;
use App\Models\Technology;

use function PHPSTORM_META\type;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        $types = Type::all();

        return view('admin.projects.index', compact('projects', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validation
        $request->validate([
            'name' => 'required|min:5|max:250|unique:projects,name',
            'client_name' => 'nullable|min:5',
            'cover_img' => 'nullable|image|max:256',
            'summary' => 'nullable|min:20',
            'type_id' => 'nullable|exists:types,id',
            'technologies' => 'exists:technologies,id',
        ]);
        
        $formData = $request->all();

        // Solo se l'utente ha caricato la cover image
        // if(isset($formData['cover_image'])) {
        if ($request->hasFile('cover_img')) {
            // Upload del file nella cartella pubblica
            $img_path = Storage::disk('public')->put('project_imgs', $formData['cover_img']);
            // Salvare nella colonna cover_image del db il path all'immagine caricata
            $formData['cover_img'] = $img_path;
        }


        $newProject = new Project();
        $newProject->slug = Str::slug($formData['name'], '-');
        $newProject->fill($formData);
        $newProject->save();

        if($request->has('technologies')) {
            $newProject->technologies()->attach($formData['technologies']);
        }

        return redirect()->route('admin.projects.show', ['project' => $newProject->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        // mostriamo le technologies
        $technologies = $project->technologies;
        return view('admin.projects.show', compact('project', 'technologies'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.edit', compact('project','types','technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => ['required', 'min:5', 'max:250', Rule::unique('projects')->ignore($project)],
            'client_name' => 'nullable|min:5',
            'cover_img' => 'nullable|image|max:256',
            'type_id' => 'nullable|exists:types,id',
            'technologies' => 'exists:technologies,id'
        ]);
        $formData = $request->all();

        // Se l'utente ha caricato una nuova immagine
        if ($request->hasFile('cover_img')) {
            // Se avevo già un'immagine caricata la cancello
            if ($project->cover_img) {
                Storage::delete($project->cover_img);
            }

            // Upload del file nella cartella pubblica
            $img_path = Storage::disk('public')->put('project_imgs', $formData['cover_img']);
            // Salvare nella colonna cover_image del db il path all'immagine caricata
            $formData['cover_img'] = $img_path;
        }

        $project->slug = Str::slug($formData['name'], '-');
        $project->update($formData);

        // technologies management con if
        if($request->has('technologies')) {
            $project->technologies()->sync($formData['technologies']);
        } else {
            $project->technologies()->sync([]);
        }
        // return redirect()->route('admin.projects.show', ['project' => $project->id]);
        return redirect()->route('admin.projects.show', ['project' => $project->slug])->with('message', $project->name . ' successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        // return redirect()->route('admin.projects.index');
        return redirect()->route('admin.projects.index')->with('message', $project->name . ' successfully deleted.');
    }
}
