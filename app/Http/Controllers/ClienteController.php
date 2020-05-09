<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use Auth;
class ClienteController extends Controller
{
     function telaCadastro(){
        
    	return view("cadastro_clientes");
        
    }

    function telaAlteracao($id){
       
        $usuario = Usuario::find($id);

        return view("tela_alterar_cliente", [ "u" => $usuario ]);
        
    }

    function alterar(Request $req, $id){
       
        $usuario = Usuario::find($id);

        $nome = $req->input('nome');
        $endereco = $req->input('endereco');
        $cep = $req->input('cep');
        $cidade = $req->input('cidade');
        $estado = $req->input('estado');
    
        $usuario->nome = $nome;
        $usuario->endereco = $endereco;
        $usuario->cep = $cep;
        $usuario->cidade = $cidade;
        $usuario->estado = $estado;

        if ($usuario->save()){
            $msg = "Cliente $nome alterado com sucesso.";
        } else {
            $msg = "Cliente não foi alterado.";
        }

        return view("retorno", [ "mensagem" => $msg]);
        
    }

    function excluir($id){
        
        

        $usuario = Usuario::find($id);

        foreach ($usuario->vendas as $v){
            $v->delete();
        }

        if ($usuario->delete()){
            $msg = "Cliente $id excluído com sucesso.";
        } else {
            $msg = "Cliente não foi excluído.";
        }

        return view("retorno", [ "mensagem" => $msg]);
        
    }

    function adicionar(Request $req){
        
    	$nome = $req->input('nome');
    	$endereco = $req->input('endereco');
    	$cep = $req->input('cep');
    	$cidade = $req->input('cidade');
    	$estado = $req->input('estado');
    
    	$usuario = new Usuario();
    	$usuario->nome = $nome;
    	$usuario->endereco = $endereco;
    	$usuario->cep = $cep;
    	$usuario->cidade = $cidade;
    	$usuario->estado = $estado;
    	
    	if ($usuario->save()){
    		$msg = "Usuário $nome cadastrado com sucesso.";
    	}else{
    		$msg = "Usuário não foi cadastrado.";
    	}

    	return view("retorno", [ "mensagem" => $msg ]);
        
    }

    function listar(){    
            $usuarios = Usuario::all();
            return view("lista", [ "us" => $usuarios ]);
    }
}
 