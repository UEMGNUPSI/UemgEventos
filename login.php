<script type="text/javascript">
  function submeter(formulario,e)
  {
    var keycode;
    if (window.event) keycode = window.event.keyCode;
    else if (e) keycode = e.which;
    else return true;

    if (keycode == 13)
    {
      formulario.form.submit();
      return false;
    }
    else
      return true;
  }
</script>

<form class="modal fade" id="janela" method="post" <?php echo "action='dao/user/validar_acesso.php?l=".base64_encode($_SERVER['REQUEST_URI'])."'"; ?> style="padding: 0 !important;">
  <div class="modal-dialog" id='teste'>

    <div class="modal-content">
      
      <div id="Logar" class="tab">

        <div class="modal-header bg-blue text-white">
          <button class="close" data-dismiss="modal"><span>&times;</span></button>
          <h4 class="modal-title"><span id="icon-login" class="glyphicon glyphicon-log-in" style="padding-right: 8px"></span>Efetuar Login</h4>


        </div>

        <div class="modal-body">
            
            <div class="col-md-6" style="margin-bottom: 5px;">
                <div class="form-group">
                    <label for="email"><span id="icon-email-pass" class="glyphicon glyphicon-envelope"></span> E-mail</label>
                    <input id='email' type="text" class="form-login" id="campo_usuario" name="usuario" style="text-transform: lowercase;" onkeypress="submeter(this,event)"/>

                </div>

                  <div class="form-group">
                    <label for="senha"><span id="icon-email-pass" class="glyphicon glyphicon-lock"></span> Senha</label>
                    <input id='senha' type="password" class="form-login red" id="campo_senha" name="senha" maxlength="20" onkeypress="submeter(this,event)" />

                  </div>
                  <div style="margin-bottom: 1rem; font-size: 14px;"><a <?php echo "href='recuperar_senha.php?l=".base64_encode($_SERVER['REQUEST_URI'])."'"; ?>>Esqueci minha senha</a></div>
            </div>
          
            <div id="div-info" class="col-md-6">
                <p class="middleY">Para se inscrever em atividade basta criar uma conta <b>totalmente gratuita</b>.</p>
            </div>
          
        </div>
          
      </div>

      <!-- rodape -->
      <div class="modal-footer">
          <div class="col-md-12">
            <a href="cadastro.php" id="btn-cadastrar" class="btn-custom btn-logar" style="float: left;" >Cadastrar</a>
            
            <button class="btn-custom btn-cancelar" data-dismiss="modal" style="float: right;">Cancelar</button>
            <button id="logar" class="btn-custom btn-logar" type="submit" style="float: right;">Entrar</button>
          </div>
        
      </div>

    </div>
  </div>
</form>