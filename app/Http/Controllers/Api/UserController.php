<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserLogs;

class UserController extends Controller
{
    public function __construct(User $user)  
    {
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ['data' => $this->user->get()];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $userData = $request->all();
            $this->user->create($userData);

            return response()->json(['msg' => 'Usuário criado com sucesso!'], 201);

        } catch (\Exeption $e) {
            if(config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010));
            }
            return response()->json(ApiError::errorMessage('Houve um erro ao realizar esta operação', 1010));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $id)
    {
        $user_logs = $id->logs();
        $data = [
            'data' => $id, 
            'logs' => $user_logs->paginate(5)
        ];
        return response()->json($data);
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
        try {

            $userData = $request->all();
            $user     = $this->user->find($id);

            $user->update($userData);

            return response()->json(['msg' => ['Usuário atualizado com sucesso!']], 201);

        } catch (\Exeption $e) {
            if(config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010));
            }
            return response()->json(ApiError::errorMessage('Houve um erro ao realizar esta operação', 1010));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(User $id)
    {
        try {

            if($id){
                $id->delete();
                return response()->json(['data' => ['Usuário ' . $id->name . ' removido com sucesso!']], 200);
            }
            
            return response()->json(['data' => ['Este usuário não existe ou já foi removido.']]);
            

        } catch (\Exeption $e) {
            if(config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010));
            }

            return response()->json(ApiError::errorMessage('Houve um erro ao realizar esta operação', 1010));
        }
    }

    public function restore($id)
    {
        
        try {

            $id = User::onlyTrashed()->where([
                'id' => $id
            ])->first();
            if($id){
                $id->restore();
                return response()->json(['data' => ['Usuário ' . $id->name . ' restaurado com sucesso!']], 200);
            }
            
            return response()->json(['data' => ['Este usuário não existe ou já foi restaurado.']]);

        } catch (\Exeption $e) {
            if(config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010));
            }
            return response()->json(ApiError::errorMessage('Houve um erro ao realizar esta operação', 1010));
        }
    }

    public function forceDelete($id)
    {
        try {
            
            $id = User::onlyTrashed()->where([
                'id' => $id
            ])->first();
            if($id){

                $id->forceDelete();
                return response()->json(['data' => ['Usuário ' . $id->name . ' removido permanentemente com sucesso!']], 200);
            }
            return reponse()->json(['data' => ['Somente usuários que estão na "lixeira" podem ser excluídos permanentemente.']]);
            

        } catch (\Exeption $e) {
            if(config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010));
            }
            return response()->json(ApiError::errorMessage('Houve um erro ao realizar esta operação', 1010));
        }
    }
}
