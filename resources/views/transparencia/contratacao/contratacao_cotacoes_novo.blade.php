@extends('navbar.default-navbar')
@section('content')
<script type="text/javascript">
    function mudar(valor) {
		var status = document.getElementById('proccess_name').value;  
        if(status == "COVID"){ 
            document.getElementById('proccess_name2').disabled = false;
        } else {
            document.getElementById('proccess_name2').disabled = true;
        }
    }
</script>
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">	
  <div class="row" style="margin-top: 25px;">		
    <div class="col-md-12 text-center">			
	  <h3 style="font-size: 18px;">CADASTRAR CONTRATAÇÕES:</h3>		
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
			  Cotações <i class="fas fa-check-circle"></i>                    
			</a>				
		  </div>				    
		  <form action="{{\Request::route('storeCotacoes'), $unidade->id}}" method="post" enctype="multipart/form-data">					
		    <input type="hidden" name="_token" value="{{ csrf_token() }}">					  
			  <table border="0" class="table-sm" style="line-height: 1.5;" WIDTH="1020">						
			    <tr>						 
				  <td> Processo de Cotações: </td>						 
				  <td> 		
				  <select style="width: 500px" class="form-control" id="proccess_name" name="proccess_name" onchange="mudar('sim')">							 
					<option value="PROCESSO 001/2020 - PROJETO GERADOR A DIESEL">PROCESSO 001/2020 - PROJETO GERADOR A DIESEL</option>							 
					<option value="PROCESSO REFORMA CENTRO DE PARTO NORMAL">PROCESSO REFORMA CENTRO DE PARTO NORMAL</option>							 
					<option value="PROCESSO DE SELEÇÃO TRS HOSPITALAR">PROCESSO DE SELEÇÃO TRS HOSPITALAR</option>							 
					<option value="MAPA DE COTAÇÕES">MAPA DE COTAÇÕES</option>
					<option value="COVID">COVID</option>
				  </select>	
				  </td>						
				</tr>
				<tr>						 
				  <td> Mês/Ano: </td>						 
				  <td> 		
				  <select style="width: 300px" class="form-control" id="proccess_name2" name="proccess_name2" disabled="true">							 
					<option id="proccess_name2" name="proccess_name2" value="Janeiro2021">Janeiro/2021</option>							 
					<option id="proccess_name2" name="proccess_name2" value="Fevereiro2021">Fevereiro/2021</option>							 
					<option id="proccess_name2" name="proccess_name2" value="Março2021">Março/2021</option>							 
					<option id="proccess_name2" name="proccess_name2" value="Abril2021">Abril/2021</option>
					<option id="proccess_name2" name="proccess_name2" value="Maio2021">Maio/2021</option>
					<option id="proccess_name2" name="proccess_name2" value="Junho2021">Junho/2021</option>
					<option id="proccess_name2" name="proccess_name2" value="Julho2021">Julho/2021</option>
					<option id="proccess_name2" name="proccess_name2" value="Agosto2021">Agosto/2021</option>
					<option id="proccess_name2" name="proccess_name2" value="Setembro2021">Setembro/2021</option>
					<option id="proccess_name2" name="proccess_name2" value="Outubro2021">Outubro/2021</option>
					<option id="proccess_name2" name="proccess_name2" value="Novembro2021">Novembro/2021</option>
					<option id="proccess_name2" name="proccess_name2" value="Dezembro2021">Dezembro/2021</option>
				  </select>	
				  </td>						
				</tr>						
				<tr>					     
				  <td> Arquivo: </td>						 
				  <td> <input style="width: 450px" class="form-control" type="file" id="file_path" name="file_path" value="" required /> </td>						
				</tr>					  
			  </table>													
			  <table>						   
			    <tr>						     
				  <td> <input hidden type="text" class="form-control" id="validar" name="validar" value="1"> </td>
				  <td> <input type="hidden" id="ordering" name="ordering" value="0" /> </td>							 
				  <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>							 
				  <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="contratacaoCotacoes" /> </td>							 
				  <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarContratacaoCotacoes" /> </td>							 
				  <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>						   
				</tr>						
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
@endsection