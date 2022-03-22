@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong>
</div>
<div class="container-fluid">	
   <div class="row" style="margin-top: 25px;">		
      <div class="col-md-12 text-center">			
		 <h3 style="font-size: 18px;">CADASTRAR ARQUIVOS PROCESSO COTAÇÃO:</h3>		
	  </div>	
   </div>		
   @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
	@endif 
   <div class="row" style="margin-top: 25px;">		
      <div class="col-md-0 col-sm-0"></div>			
	      <div class="col-md-12 col-sm-12 text-center">			
		       <div class="accordion" id="accordionExample">				
			       <div class="card">				    
				      <a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">                        
					     Cotações - Processos Arquivos <i class="fas fa-check-circle"></i>                    
					  </a>				
				   </div>				    
				   <form action="{{\Request::route('storeArquivoCotacao'), $unidade->id}}" method="post" enctype="multipart/form-data">					
				   <input type="hidden" name="_token" value="{{ csrf_token() }}">					  
 					  <table border="0" class="table-sm" style="line-height: 1.5;" WIDTH="1020">						
					     <tr>
						  <td> ID: </td>
						  <td> <input style="width: 100px" class="form-control" type="text" id="id" name="id" value="<?php echo $processo[0]->id; ?>" readonly="true" /> </td>
						 </tr>
					     <tr>
						   <td> Processo: </td>
						   <td> <input style="width: 350px" class="form-control" type="text" id="numeroSolicitacao" name="numeroSolicitacao" value="<?php echo $processo[0]->numeroSolicitacao; ?>" readonly="true" /> </td>
						 </tr>
						 <tr>					     
						   <td> <br><br> Título: </td>						 
						   <td> <br><br> <input style="width: 450px" class="form-control" type="text" id="title" name="title" value="" required /> </td>						
						 </tr>
						 <tr>					     
						   <td> Arquivo: </td>						 
						   <td> <input style="width: 450px" class="form-control" type="file" id="file_path" name="file_path" value="" required /> </td>						
						 </tr>					  
					  </table>													
					  <table>						   
					    <tr>						     
						   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>							 
						   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="arquivosCotacoes" /> </td>							 
						   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarArquivoCotacoes" /> </td>							 
						   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>						   
						</tr>						
					  </table> <br><br>				
					  <table class="table table-sm">
						<thead class="bg-success">
						   <tr> 	
							<th scope="col" style="width: 200px">Nº Solicitação</th> 	
							<th scope="col" style="width: 200px">Pedido</th>            
							<th scope="col" style="width: 200px">Arquivo</th>       
						   </tr>         
						</thead>
						@if(!empty($processo_arquivos))
						@foreach($processo_arquivos as $processoA)
					    @if($processoA->processo_id == $processo[0]->id)
						<tbody> 	
							<th style="font-size: 12px">{{ $processo[0]->numeroSolicitacao }}</p></th> 	
							<th style="font-size: 12px">{{ $processo[0]->tipoPedido }}</th> 	
							<th style="font-size: 12px">{{ $processoA->title }}</th> 	
						</tbody>
						@endif
						@endforeach
					    @endif
					  </table> 	
					  <table>							
					    <tr>					     
						   <td align="left">						 
						     <br /><a href="{{route('cadastroCotacoes', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>					           
							 <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" /> 					     
						   </td>					    
						</tr>					  
					   </table>				  
					  </form>				
				</div>							  
			</div> 	        
		</div>    
	  </div>
	 </div>
	@endsection