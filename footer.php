<footer>
  <div class="col-xs-12 rodape">
  <div class="col-sm-6" id="uemg-footer">
    <h3 class='rodape-titulo'>UEMG Frutal</h3>
    <p style="font-size: 17px; margin-bottom: 6px;"><span class='
icon glyphicon glyphicon-map-marker'></span> Endereço</p>
    <p class='rodape-info'>Av. Professor Mário Palmerio, 1001 - Bairro Universitário</p>
    <p style="font-size: 17px; margin-bottom: 6px;"><span class='
icon glyphicon glyphicon-earphone'></span> Contato</p>
    <p class='rodape-info'>Telefone: (34) 3423-2700</p>
    <p class='rodape-info'>FAX: (34) 3423-2727</p>
    <p class='rodape-info'>E-mail: diretoria.frutal@uemg.br</p>
    <p style="font-size: 17px; margin-bottom: 6px;"><span class='
icon glyphicon glyphicon-link'></span> Portal</p>
    <p class='rodape-info'><a href="http://frutal.uemg.br" target="_blank">UEMG Unidade Frutal</a></p>
  </div>
    <div class="col-sm-6">
      <h3 class='rodape-titulo'>NUPSI</h3>
      <p style="font-size: 17px; margin-bottom: 6px;"><span class='
icon glyphicon glyphicon-map-marker'></span> Endereço</p>
      <p class='rodape-info'>Bloco A, piso 2</p>

      <p style="font-size: 17px; margin-bottom: 6px;"><span class='
icon glyphicon glyphicon-earphone'></span> Contato</p>
      <p class="rodape-info">Ramal: 2772</p>
      <p class="rodape-info">E-mail: nupsi.frutal@uemg.br</p>
    </div>
  </div>
</footer>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/public/frameworks/bootstrap/js/bootstrap.min.js"></script>

<script>
  $(document).ready(function (){
    $("#janela").on('show.bs.modal', function(e){
      $("nav").css("padding-right", "16px");
    });
    
    $("#janela").on('hidden.bs.modal', function(e){
        $("nav").removeAttr('style');
    });
  });
</script>