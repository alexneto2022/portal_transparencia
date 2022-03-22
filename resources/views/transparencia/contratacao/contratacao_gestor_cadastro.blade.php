@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong>
</div>
<div class="container-fluid">	
   <div class="row" style="margin-top: 25px;">		
      <div class="col-md-12 text-center">			
		 <h3 style="font-size: 18px;">CADASTRAR GESTOR:</h3>		
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
					     Gestor: <i class="fas fa-check-circle"></i>                    
					  </a>				
				   </div>				    
				   <form action="{{\Request::route('storeGestor'), $unidade->id}}" method="post">					
				   <input type="hidden" name="_token" value="{{ csrf_token() }}">					  
 					  <table border="0" class="table-sm" style="line-height: 1.5;" WIDTH="1020">						
					     <tr>					     
						   <td> Nome: </td>						 
						   <td> <input style="width: 450px" class="form-control" type="text" id="nome" name="nome" value="" required /> </td>						
						 </tr>
						 <tr>					     
						   <td> E-mail: </td>						 
						   <td> <input style="width: 450px" class="form-control" type="email" id="email" name="email" value="" required /> </td>						
						 </tr>
					  </table>													
					  <table>						   
					    <tr>						     
						   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>							 
						   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="Gestor" /> </td>							 
						   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="vincularGestor" /> </td>							 
						   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>						   
						</tr>						
					  </table>											  
					  <table>							
					    <tr>					     
						   <td align="left">						 
						     <br /><a href="{{route('responsavelCadastro', array($unidade->id, $id))}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>					           
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