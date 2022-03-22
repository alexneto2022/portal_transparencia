@extends('layouts.app')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade[0]->name}}</strong>
</div>
<div class="container-fluid">	
   <div class="row" style="margin-top: 25px;">		
      <div class="col-md-12 text-center">			
		 <h3 style="font-size: 18px;">CADASTRAR ARQUIVOS DE ORDEM DE COMPRA:</h3>		
	  </div>	
   </div>		
   @if ($errors->any())
			<div class="alert alert-success">
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
					     Ordem de Compra - Processos Arquivos <i class="fas fa-check-circle"></i>                    
					  </a>				
				   </div>				    
				   <form action="{{route('storeArquivoOrdemCompra', array($unidade[0]->id, $processos[0]->id))}}" method="post" enctype="multipart/form-data">					
				   <input type="hidden" name="_token" value="{{ csrf_token() }}">					  
 					  <table border="0" style="margin-left: 320px;" class="table-sm" style="line-height: 1.5;" WIDTH="1020">						
					     <tr>
						  <th> ID: </th>
						  <td> <input style="width: 180px" class="form-control" type="text" id="id" name="id" value="<?php echo $processos[0]->id; ?>" readonly="true" /> </td>
						 </tr>
					     <tr>
						   <th> Processo: </th>
						   <td> <input style="width: 180px" class="form-control" type="text" id="numeroSolicitacao" name="numeroSolicitacao" value="<?php echo $processos[0]->numeroSolicitacao; ?>" readonly="true" /> </td>
						 </tr>
						 <table class= "table-sm" style= "margin-left: 90px;">
						 <tr>
						

						   <td> <br><br> <input style="width: 200px" class="form-control" type="text" id="title1" name="title1"  placeholder="Título"/> </td>						
						   <td> <br><br> <input style="width: 200px" class="form-control" type="text" id="title2" name="title2"  placeholder="Título"/> </td>						
						   <td> <br><br> <input style="width: 200px" class="form-control" type="text" id="title3" name="title3"  placeholder="Título"/> </td>						
						   <td> <br><br> <input style="width: 200px" class="form-control" type="text" id="title4" name="title4"  placeholder="Título"/> </td>						
						   <td> <br><br> <input style="width: 200px" class="form-control" type="text" id="title5" name="title5"  placeholder="Título"/> </td>						
					 
						
						</tr>
						 <tr>	
				     
						   <td> <input style="width: 200px" class="form-control-file" type="file" id="file_path_1" name="file_path_1"   /> </td>						
						   <td> <input style="width: 200px" class="form-control-file" type="file" id="file_path_2" name="file_path_2"   /> </td>						
						   <td> <input style="width: 200px" class="form-control-file" type="file" id="file_path_3" name="file_path_3"   /> </td>	
						   <td> <input style="width: 200px" class="form-control-file" type="file" id="file_path_4" name="file_path_4"   /> </td>											
						   <td> <input style="width: 200px" class="form-control-file" type="file" id="file_path_5" name="file_path_5"   /> </td>						
						
						</tr>
						 <tr>
							
						</tr>
</table>					  	
					  </table>	
					  <table style="margin-left: 545px;" class="table-sm">							
					    <tr>					     
						   <td align="left">						 
						     <br /><a href="{{route ('transparenciaOrdemCompra', $unidade[0]->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="padding:8px; width:80px; margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>					           
							 <input type="submit" class="btn btn-success btn-sm" style="padding:8px; margin-top: 10px; width:80px" value="Salvar" id="Salvar" name="Salvar" /> 					     
						   </td>					    
						</tr>					  
					   </table>													
					  <table>						   
					    <tr>						     
						   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade[0]->id; ?>" /></td>							 
						   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="arquivos_oc" /> </td>							 
						   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="novos_arquivos_oc" /> </td>							 
						   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>						   
						</tr>						
					  </table> <br><br>	
					  <table class="table table-sm">
						<thead class="bg-success">
						   <tr> 	
							<th scope="col" style="width: 200px">Nº Solicitação</th> 	
							<th scope="col" style="width: 200px">Arquivo</th>       
						   </tr>         
						</thead>
						@if(!empty($processo_arquivos))
							@foreach($processo_arquivos as $processoA)
								@if($processoA->processo_id == $processos[0]->id)
								<tbody> 	
									<th style="font-size: 12px">{{ $processos[0]->numeroSolicitacao }}</p></th> 	
									<th style="font-size: 12px">{{ $processoA->title }}</th> 	
								</tbody>
								@endif
							@endforeach
					    @endif
					  </table> 					  
					  </form>				
				</div>							  
			</div> 	        
		</div>    
	  </div>
	 </div>
	@endsection