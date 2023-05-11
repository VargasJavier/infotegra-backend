<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


class RegistrosController extends Controller
{
    public function index(){

        try {

            if(DB::table('characters')->exists()) return false;
            for ($i = 1; $i <= 5; $i++) {
                $response = Http::get('https://rickandmortyapi.com/api/character?page='.$i);
                $data = $response->json();
                $characters = $data["results"];

                foreach ($characters as $characterData) {
                    $character = new Character();
                    $character->id = $characterData['id'];
                    $character->name = $characterData['name'];
                    $character->status = $characterData['status'];
                    $character->species = $characterData['species'];
                    $character->type = $characterData['type'];
                    $character->gender = $characterData['gender'];
                    $character->origin = $characterData['origin'];
                    $character->image = $characterData['image'];
                    $character->save();
                }
            }

            return true;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function countCharacters(){
        try {
            return DB::table('characters')->count();
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public function getCharactersFromDatabase(){
        try {
            $characters = Character::all();
            return $characters;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public function getCharacterFromId($id){
        try {
            return Character::find($id);
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public function getCharactersFromPage(){
        try {
            $page = request()->get('pagina', 1);
            return Character::orderBy('id', 'asc')->paginate(20, ['*'], 'pagina', $page);
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public function updateCharacter(Request $datos, $id){
        $registro = Character::find($id);

        if (!$registro) {
           return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $registro->name = $datos->input('name');
        $registro->species = $datos->input('species');
        $registro->status = $datos->input('status');
        $registro->image = $datos->input('image');
        $registro->origin = $datos->input('origin');
        $registro->type = $datos->input('type');
        $registro->gender = $datos->input('gender');

        $registro->save();

        return response()->json(['mensaje' => 'Registro actualizado correctamente'], 200);
    }

    public function update(Request $request) {

        $registro = Character::find($request->id);

        if (!$registro) {
        return false;
        }

        $registro->name = $request->name;
        $registro->species = $request->species;
        $registro->status = $request->status;
        $registro->image = $request->image;
        $registro->origin = $request->origin;
        $registro->type = $request->type;
        $registro->gender = $request->gender;

        if($registro->save()){
            return true;
        }
        return false;

    }
}
