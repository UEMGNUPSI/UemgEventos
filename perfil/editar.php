<form class="modal fade" id="edit" method="post" action="atualiza_usuario.php">
    <section class="modal-dialog">
        <div class="modal-content">
            <div id="Logar" class="tab">
                <div class="modal-header" style="margin-top: 15px;">
                    <button class="close" data-dismiss="modal" style="margin-right: 15px"><span>&times;</span></button>
                    <h4 class="modal-title"><span id="icon-login" class="glyphicon glyphicon-user" style="padding-right: 8px; margin-left: 15px;"></span>Editar Conta</h4>
                </div>

                <div class="modal-body">
                    <?php if(!empty($_SESSION['ra'])){?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nome">Nome: </label>
                            <input type="text" name="nome" maxlength="36" placeholder="Máx: 36 caracteres" class="form-login">
                        </div>
                        <div class="form-group">
                            <label for="email">E-Mail: </label>
                            <input type="email" name="email" placeholder="Ex: exemplo@exemplo.com" class="form-login">
                        </div>
                        <div class="form-group">
                            <label for="senha">Senha: </label>
                            <input type="password" name="senha" maxlength="20" placeholder="De 5 a 20 caracteres" class="form-login" pattern=".{5,20}">
                        </div>
                        <div class="form-group">
                            <label for="email">CPF: </label>
                            <input type="number" name="cpf" placeholder="Apenas números" class="form-login">
                        </div>
                        <div class="form-group">
                            <label for="ra">R.A.: </label>
                            <input type="number" name="ra" placeholder="Apenas números" class="form-login" maxlength="7" pattern=".{5,20}">
                        </div>
                    </div>
                        
                    <div class="col-md-6">       
                        <div class="form-group">
                            <label for="nasc">Data de nascimento: </label>
                            <input type="date" id="nasc" name="nasc" class="form-login">
                        </div>
                        <div class="form-group">
                            <label>Curso: </label>
                            <select class="form-login" name="curso">
                                <option disabled selected style="display: none;" value="">Selecione</option>
                                <?php 
                                $sql = "SELECT titulo, id FROM cursos";

                                $resultado_id = mysqli_query($link, $sql);

                                if($resultado_id){
                                    while($curso = mysqli_fetch_array($resultado_id)){

                                    echo "<option value='".$curso['id']."'>".$curso['titulo']."</option>";

                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tel">Telefone: </label>
                            <input type="number" id="tel" name="tel" placeholder="Apenas números. Não se esqueça do ddd." class="form-login">
                        </div>
                            
                        <div class="form-group">
                            <label for="cnpj">CNPJ: </label>
                            <input type="number" id="cnpj" name="cnpj" placeholder="Apenas números" class="form-login">
                        </div>
                        <div class="form-group">
                            <label for="ano">Ano de ingressão na faculdade: </label>
                            <input type="number" id="ano" name="ano" placeholder="Ex: 2017" class="form-login" min="2000" max="2017">
                        </div>

                    </div>
                    <?php }else{ ?>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="nome">Nome: </label>
                        <input type="text" name="nome" maxlength="36" class="form-login" placeholder="Máx: 36 caracteres">
                        </div>
                        <div class="form-group">
                        <label for="email">E-Mail: </label>
                        <input type="email" name="email" placeholder="Ex: exemplo@exemplo.com" class="form-login">
                        </div>
                        <div class="form-group">
                        <label for="email">CPF: </label>
                        <input type="number" name="cpf" placeholder="Apenas números" class="form-login">
                        </div>
                        <div class="form-group">
                            <label for="senha">Senha: </label>
                            <input type="password" name="senha" placeholder="De 5 a 20 caracteres" class="form-login" maxlength="20" pattern=".{5,20}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nasc">Data de nascimento: </label>
                            <input type="date" id="nasc" name="nasc" class="form-login">
                        </div>
                        <div class="form-group">
                            <label for="tel">Telefone: </label>
                            <input type="number" id="tel" name="tel" placeholder="Apenas números. Não se esqueça do ddd." class="form-login">
                        </div>
                        <div class="form-group">
                            <label for="instituicao">Instituição: </label>
                            <input type="text" id="instituicao" name="instituicao" placeholder="Máx: 45 caracteres" maxlength="45" class="form-login">
                        </div>
                        <div class="form-group">
                            <label for="cnpj">CNPJ: </label>
                            <input type="number" id="cnpj" name="cnpj" placeholder="Apenas números" class="form-login">
                        </div>
                    </div>
                    <?php } ?>
                </div>
                    
                </div>
                <!-- rodape -->
                <div class="modal-footer">

                    <div class="col-md-12" style="margin-top: 12px; padding: 0 15px">
                        <button class="btn btn-cadastrar" style="margin-bottom: 10px; color: #ecf8ef; float: left" type="submit"><span class="glyphicon glyphicon-floppy-disk" style="padding-right: 2px"></span> Salvar</button>
                    </div>
            </div>
        </div>
    </section>  
</form>