<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
</tr>
</table>
</table>
</div>
<div class="mt-4 text-start">
    <h6> Deseja realmente Excluir este Relatório Assistencial?? </h6>
</div>
<table>
    <tr>
        <td align="left">
            <a href="{{route('assistencialCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
            <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Excluir" id="Excluir" name="Excluir" />
        </td>
    </tr>
</table>
</form>
</div>
</div>
@endsection