@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
    <div class="row" style="margin-bottom: 25px; margin-top: 25px;">
        <div class="col-md-12 text-center">
            <h5  style="font-size: 18px;">VISUALIZAR RELATÓRIO ASSISTENCIAL:</h5>
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
		<div class="col-md-1 col-sm-0"></div>
		<div class="col-md-20 col-sm-18 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						RELATÓRIO ASSISTENCIAL: <i class="fas fa-check-circle"></i>
					</a>				
				</div>
					<form action="" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<table class="form-control"> <br />
						 <tr>
						 <td> Ano de Referência: </td>
						  <td> &nbsp; </td>
						  <td> <input type="text" id="ano_ref" name="ano_ref" value="<?php echo $anosRef[0]->ano_ref; ?>" readonly="true" class="form-control" style="width: 100px" required value="" /> </td>
						  <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						    <a class="text-success" href="{{route('exportAssistencialMensal',['id'=> $unidade->id, 'year'=> $anosRef[0]->ano_ref])}}" title="Download"><img src="{{asset('img/csv.png')}}" alt="" width="60"></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a class="text-danger" href="{{route('assistencialPdf',['id'=> $unidade->id, 'year'=> $anosRef[0]->ano_ref])}}" title="Download"><img src="{{asset('img/pdf.png')}}" alt="" width="60"></a> </td>
						 </tr>
						</table>
						
						<table class="table table-sm ">

						<thead class="bg-success">

							<tr>
								<th scope="col">Descrição</th>
								<th scope="col">Meta Contratada/Mês</th>
								<th scope="col">Janeiro</th>
								<th scope="col">Fevereiro</th>
								<th scope="col">Março</th>
								<th scope="col">Abril</th>
								<th scope="col">Maio</th>
								<th scope="col">Junho</th>
								<th scope="col">Julho</th>
								<th scope="col">Agosto</th>
								<th scope="col">Setembro</th>
								<th scope="col">Outubro</th>
								<th scope="col">Novembro</th>
								<th scope="col">Dezembro</th>
							</tr>

						</thead>

						@foreach($anosRef as $aRef)

						<tbody>
							<tr>
							  <th> <input type="text" id="desc" name="desc" value="<?php echo $aRef->descricao; ?>" title="<?php echo $aRef->descricao; ?>" class="form-control" style="width: 100px" readonly="true" /></td>
							  <th> <input type="text" id="met" name="met" value="<?php echo $aRef->meta; ?>" title="<?php echo $aRef->meta; ?>" class="form-control" style="width: 100px" readonly="true" /> </td>
							  <th> <input type="text" id="jan" name="jan" value="<?php echo $aRef->janeiro; ?>" title="<?php echo $aRef->janeiro; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <input type="text" id="fev" name="fev" value="<?php echo $aRef->fevereiro; ?>" title="<?php echo $aRef->fevereiro; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <input type="text" id="mar" name="mar" value="<?php echo $aRef->marco; ?>" title="<?php echo $aRef->marco; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <input type="text" id="abr" name="abr" value="<?php echo $aRef->abril; ?>" title="<?php echo $aRef->abril; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <input type="text" id="mai" name="mai" value="<?php echo $aRef->maio; ?>" title="<?php echo $aRef->maio; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <input type="text" id="jun" name="jun" value="<?php echo $aRef->junho; ?>" title="<?php echo $aRef->junho; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <input type="text" id="jul" name="jul" value="<?php echo $aRef->julho; ?>" title="<?php echo $aRef->julho; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <input type="text" id="ago" name="ago" value="<?php echo $aRef->agosto; ?>" title="<?php echo $aRef->agosto; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <input type="text" id="set" name="set" value="<?php echo $aRef->setembro; ?>" title="<?php echo $aRef->setembro; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <input type="text" id="out" name="out" value="<?php echo $aRef->outubro; ?>" title="<?php echo $aRef->outubro; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <input type="text" id="nov" name="nov" value="<?php echo $aRef->novembro; ?>" title="<?php echo $aRef->novembro; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <input type="text" id="dez" name="dez" value="<?php echo $aRef->dezembro; ?>" title="<?php echo $aRef->dezembro; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							</tr>

						</tbody>	

						@endforeach
						<table>
						<tr>
						<td align="left">
							<a href="{{route('transparenciaAssistencial', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			            </td>
						</tr>
						</table>
					</form>
			</div>
        </div>
		<div class="col-md-1 col-sm-0"></div>
    </div>
</div>
@endsection