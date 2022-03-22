@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CADASTRAR REPASSES RECEBIDOS:</h3>
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
		<div class="col-md-2 col-sm-0"></div>
		<div class="col-md-8 col-sm-8 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                        Repasses: <i class="fas fa-check-circle"></i>
                    </a>
                </div>
					<p>
					<form action="{{\Request::route('store'), $unidade->id}}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					 <table>
					  <tr>
					   <td> Mês: </td>
					   <td> &nbsp; </td>
					   <td>
						<select id="mes" name="mes" class="form-control">
						 <option id="mes" name="mes" value="janeiro">Janeiro</option>
						 <option id="mes" name="mes" value="feveiro">Fevereiro</option>
						 <option id="mes" name="mes" value="marco">Março</option>
						 <option id="mes" name="mes" value="abril">Abril</option>
						 <option id="mes" name="mes" value="maio">Maio</option>
						 <option id="mes" name="mes" value="junho">Junho</option>
						 <option id="mes" name="mes" value="julho">Julho</option>
						 <option id="mes" name="mes" value="agosto">Agosto</option>
						 <option id="mes" name="mes" value="setembro">Setembro</option>
						 <option id="mes" name="mes" value="outubro">Outubro</option>
						 <option id="mes" name="mes" value="novembro">Novembro</option>
						 <option id="mes" name="mes" value="dezembro">Dezembro</option>
						 </select>
					   </td>
					  </tr>
					  <tr>
					   <td> Ano: </td>
					   <td> &nbsp; </td>
					  <td> <select id="ano" name="ano" class="form-control">
						 <option value="2015" id="ano" name="ano">2015</option>
						 <option value="2016" id="ano" name="ano">2016</option>
						 <option value="2017" id="ano" name="ano">2017</option>
						 <option value="2018" id="ano" name="ano">2018</option>
						 <option value="2019" id="ano" name="ano">2019</option>
						 <option value="2020" id="ano" name="ano">2020</option>
						 <option value="2021" id="ano" name="ano">2021</option>
						 <option value="2022" id="ano" name="ano">2022</option>
						 <option value="2023" id="ano" name="ano">2023</option>
						 <option value="2024" id="ano" name="ano">2024</option>
						 <option value="2025" id="ano" name="ano">2025</option>					  
						</td>
						</tr>
					  <tr>
					   <td> Contratado: </td>
					   <td> &nbsp; </td>
					   <td> <input class="form-control" type="number" step="any" id="contratado" name="contratado" value="" required />  </td>
					  </tr>
					  <tr>
					   <td> Recebido: </td>
					   <td> &nbsp; </td>
					   <td> <input class="form-control" type="number" step="any" id="recebido" name="recebido" value="" required />  </td>
					  </tr>
					  <tr>
					   <td> Desconto: </td>
					   <td> &nbsp; </td>
					   <td> <input class="form-control" type="number" step="any" id="desconto" name="desconto" value="" required />  </td>
					  </tr>
					 </table>
					 
					 <table>
					   <tr>
						 <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
						 <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="repasses" /> </td>
						 <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarRepasses" /> </td>
						 <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
					   </tr>
					 </table>
					 
					 <table>
					  <tr>
						<td> 
						  <br/><a href="{{route('repasseCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
						  <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
						</td>
					  </tr>
					 </table>
					</form>
				   </p>
			</div>
		</div>
	</div>
</div>
@endsection