<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;

class ProdutoController extends Controller
{
    function telaCadastro(){
         
	    	return view("cadastro_produto");
	       
    }

    function adicionar(Request $req){

        	$descricao = $req->input('descricao');
	    	$nome = $req->input('nome');
	    	$preco = $req->input('preco');
	    	$unidade_venda = $req->input('unidade_venda');
	    
	    	$produto = new Produto();
	    	$produto->descricao = $descricao;
	    	$produto->nome = $nome;
	    	$produto->preco = $preco;
	    	$produto->unidade_venda = $unidade_venda;
	    	
	    	if ($produto->save()){
	    		$msg = "$nome cadastrado com sucesso.";
	    	}else{
	    		$msg = "Produto não foi cadastrado.";
	    	}

	    	return view("retorno", [ "mensagem" => $msg ]);
	   
    }
}
