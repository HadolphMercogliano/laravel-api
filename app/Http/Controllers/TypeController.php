<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      $sort = (!empty($sort_request = $request->get('sort'))) ? $sort_request : "updated_at";
      $order = (!empty($order_request = $request->get('order'))) ? $order_request : "DESC";
      $types = Type::orderBy($sort, $order)->paginate(10)->withQueryString();
      
      return view('admin.types.index', compact('types','sort', 'order'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      $type = new Type(); 
      return view('admin.types.create', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $data = $this->validation($request->all());
      $type = new Type;        
        $type->fill($data);
        $type->save();

        return to_route('admin.types.show', $type)
                ->with('message_type', 'alert-success')
                ->with('message_content', 'Tipologia aggiunta correttamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
      return view('admin.types.show', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
       return view('admin.types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
      $data = $this->validation($request->all());
      $type->update($data);     

      return to_route('admin.types.show', $type)
              ->with('message_type', 'alert-success')
              ->with('message_content', 'Tipologia modificata correttamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
      $type_id = $type->id;
      $type->delete();
      return to_route('admin.types.index')
            ->with('message_type', 'alert-danger')
            ->with('message_content', "Tipologia $type_id eliminata definitivamente");
    }

    private function validation($data) {
     $validator = Validator::make(
        $data,
        [
          'label' => 'required|string|max:20',
          'color' => 'required|string|size:7',
        ],
        [
          'label.required' => 'La label è obbligatoria',
          'label.string' => 'La label deve essere una stringa',
          'label.max' => 'La label essere di massimo 20 caratteri',
          'color.required' => 'Il colore è obbligatorio',
          'color.string' => 'Il colore deve essere una stringa',
          'color.size' => 'il colore deve essere un hex di 7 caratteri (es: #123456)',
        ]
        )->validate();
        return $validator;
    }
}