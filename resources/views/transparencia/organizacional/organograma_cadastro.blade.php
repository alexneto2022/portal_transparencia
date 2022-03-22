@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">ORGANOGRAMA</h5>
		</div>
	</div>	
	<div class="row"> 
			<div class="col-md-12">
				<p align="right"><a href="{{route('organogramaNovo', $unidade->id)}}" class="btn btn-dark btn-sm" style="color: #FFFFFF;"> Novo <i class="fas fa-check"></i> </a></p>
			</div>
			<table class="table table-sm ">
				<thead class="bg-success">
					<tr>
						<th scope="col">Título</th>
						<th scope="col">Arquivo</th>
						<th scope="col">Excluir</th>
					</tr>
				</thead>
				<tbody>
					<tr>
					    <td style="fonr-size: 15px;">Organograma do HCP Gestão:</td>
						<td style="font-size: 15px;"></td>
						<td style="font-size: 15px;"><a class="btn btn-danger btn-sm" href="{{route('organogramaExcluir', $unidade->id)}}" ><i class="fas fa-times-circle"></i></td> 
					</tr>
				</tbody>
		</table>
	</div>
</div>

@endsection