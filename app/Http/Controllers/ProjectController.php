<?php

namespace App\Http\Controllers;

use App\Mail\PublishedProjectMail;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     */
    public function index(Request $request)
    {
      $sort = (!empty($sort_request = $request->get('sort'))) ? $sort_request : "updated_at";
      $order = (!empty($order_request = $request->get('order'))) ? $order_request : "DESC";
      $projects = Project::orderBy($sort, $order)->paginate(10)->withQueryString();

      return view('admin.projects.index', compact('projects','sort', 'order'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      $types = Type::all();
      $technologies = Technology::all();

      return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $data = $this->validation($request->all());
        
        if(Arr::exists($data, 'link')) {
          $path = Storage::put('projectImages', $data['link']);
          $data['link'] = $path;
        }
        
        
        $project = new Project;        
        $project->fill($data);
        $project->save();
        if(Arr::exists($data, "technologies")) $project->technologies()->attach($data["technologies"]);
        
        if($project->is_published){
          $mail = new PublishedProjectMail($project);
          $user_email = Auth::user()->email;
          Mail::to($user_email)->send($mail);
        }
        
        return to_route('admin.projects.show', $project)
                ->with('message_type', 'alert-success')
                ->with('message_content', 'Progetto aggiunto correttamente');
    }

    /**
     * Display the specified resource.
     */
    public function show( Project $project)
    {
      return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( Project $project)
    {
      $types = Type::all();
      $technologies = Technology::all();
      $project_technologies = $project->technologies->pluck('id')->toArray();
      return view('admin.projects.edit', compact('project', 'types', 'technologies', 'project_technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
      $initial_state = $project->is_published;
      $data = $this->validation($request->all());
      if (!$request->is_published) {
        $data['is_published'] = 0;
      }

      if(Arr::exists($data, 'link')) {
        if($project->link) Storage::delete($project->link);
          $path = Storage::put('projectImages', $data['link']);
          $data['link'] = $path;
      }


      
      $project->update($data);
      
      if($initial_state != $project->is_published) {
        $mail = new PublishedProjectMail($project);
        $user_email = Auth::user()->email;
        Mail::to($user_email)->send($mail);
      }

      if(Arr::exists($data, "technologies"))
      $project->technologies()->sync($data['technologies']);
      else
      $project->technologies()->detach();
      
      
      
      return redirect()->route('admin.projects.show', $project)
            ->with('message_type', 'alert-success')
            ->with('message_content', 'Progetto modificato correttamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
      $project_id = $project->id;

      $project->technologies()->detach();
      $project->delete();

      return to_route('admin.projects.index')
            ->with('message_type', 'alert-danger')
            ->with('message_content', "Progetto $project_id spostato nel cestino");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function forceDelete(Int $id)
    {
      $project = Project::where('id', $id)->onlyTrashed()->first();

      if($project->link) Storage::delete($project->link);
      
      $project->forceDelete();

      return to_route('admin.projects.trash')
            ->with('message_type', 'alert-danger')
            ->with('message_content', "Progetto $id eliminato correttamente");
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Int $id)
    {
      $project = Project::where('id', $id)->onlyTrashed()->first();      
      $project->restore();

      return to_route('admin.projects.index')
            ->with('message_type', 'alert-success')
            ->with('message_content', "Progetto $id ripristinato");
    }

    /**
     * Display a listing of the trashed resources.
     * @param  \Illuminate\Http\Request  $request
     */
    public function trash(Request  $request) {

      $sort = (!empty($sort_request = $request->get('sort'))) ? $sort_request : "updated_at";
      $order = (!empty($order_request = $request->get('order'))) ? $order_request : "DESC";
      $projects = Project::onlyTrashed()->orderBy($sort, $order)->paginate(10)->withQueryString();
      return view('admin.projects.trash', compact('projects', 'sort', 'order'));
    }
    
    private function validation($data) {
     $validator = Validator::make(
        $data,
        [
          'title' =>'required|string',
          'description' =>'required|string',
          'link' =>'image|mimes: jpg, png, jpeg',
          'is_published' =>'boolean',
          'type_id' => 'nullable|exists:types,id',
          'technologies' => 'nullable|exists:technologies,id'
        ],
        [
          'title.required' => 'Il nome del progetto è obbligatorio',
          'title.string' => 'Il nome del progetto deve essere una stringa',

          'description.required' => 'La descrizione del progetto è obbligatoria',
          'description.string' => 'La descrizione del progetto deve essere una stringa',

          'link.image' => 'Il file caricato deve essere un immagine',
          'link.mimes' => 'le estenzioni dei file accettate sono: jpg, png, jpeg.',
          'is_published.boolean' => 'Il valore deve essere un booleano',
          'type_id.exists' => 'Il valore nel tipo non è valido',

          'technologies.exists' => 'Il tipo di tecnologia selezionata non esiste'
        ]
        )->validate();
        return $validator;
    }
}