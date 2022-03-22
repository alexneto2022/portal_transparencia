@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 20px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 15px;"><strong>DESPESAS COM PESSOAL</strong></h3>
			<h3 style="font-size: 12px;"></h3>
		</div>
	</div>
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-0 col-sm-0"></div>
		<div class="col-md-12 col-sm-12">

			<form style="font-size: 12px;">
				<div class="form-row" >
					<div class="form-group col-md-2">
						<label for="inputEmail4">Ano de referência:</label>
						<select type="text" class="form-control form-control-sm" style="font-size: 12px;">
							<option>Selecione o ano</option>
							<option value="2010">2010</option>
							<option value="2011">2011</option>
							<option value="2012">2012</option>
							<option value="2013">2013</option>
							<option value="2014">2014</option>
							<option value="2015">2015</option>
							<option value="2016">2016</option>
							<option value="2017">2017</option>
							<option value="2018">2018</option>
							<option value="2019">2019</option>
							<option value="2020">2020</option>
						</select>
					</div>
					<div class="form-group col-md-6">
						<label for="inputEmail4">Unidade de referência:</label>
						<select type="text" class="form-control form-control-sm" style="font-size: 12px;">
							<option >Selecione a unidade</option>
							@foreach($unidadesMenu as $unidade)
							<option >{{$unidade->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-md-4">
						<label for="inputEmail4">Area de ocupacão:</label>
						<div class="form-check">
							<input class="form-check-input form-control-sm" type="checkbox" id="inlineCheckbox1" value="option1">
							<label class="form-check-label" for="inlineCheckbox1">Médico</label>
						</div>
						<div class="form-check">
							<input class="form-check-input form-control-sm" type="checkbox" id="inlineCheckbox2" value="option2">
							<label class="form-check-label" for="inlineCheckbox2">Outros profissionais de saúde</label>
						</div>
						<div class="form-check">
							<input class="form-check-input form-control-sm" type="checkbox" id="inlineCheckbox3" value="option3">
							<label class="form-check-label" for="inlineCheckbox3">Administrativo</label>
						</div>
					</div>
				</div>
			</form>

		</div>
		<div class="col-md-0 col-sm-0"></div>
	</div>

</div>
@endsection