<div class="modal fade" id="certificados">
			<div class="modal-dialog">

			    <div class="modal-content">
			      
			      <div class="tab">

			        <div class="modal-header" style="margin-top: 15px;">
			          <button class="close" data-dismiss="modal" style="margin-right: 15px"><span>&times;</span></button>
			          <h4 class="modal-title"><span id="icon-login" class="glyphicon glyphicon-certificate" style="padding-right: 8px; margin-left: 15px;"></span>Certificados</h4>
			        </div>

			        <div class="modal-body">
			            <table class="table table-hover table-striped" style="margin-top: 30px">
						<tr>
							<th>Evento</th>
							<th width="17%">Baixar</th>
						</tr>

						<?php 

						$sql = "SELECT e.id, e.titulo FROM eventos e INNER JOIN certificados c ON e.id = c.evento INNER JOIN usuarios u ON c.usuario = u.id WHERE u.id = ".$_SESSION['id'];

						$restul_certificados = mysqli_query($link, $sql);


						$rows = mysqli_num_rows($restul_certificados);

						if($rows > 0){
							while($certificados = mysqli_fetch_array($restul_certificados, MYSQLI_ASSOC)){

								echo '<tr>
										<td style="padding-left:12px">'.$certificados['titulo'].'</td>
										<td style="padding: 0 12px;position: relative; bottom: 10px;"><a target="_blank" tittle="Clique para se desinscrever!" class="btn-custom btn-inscreva" href="certificado.php?ide='.$certificados['id'].'"><span class="glyphicon glyphicon-share-alt" style="padding-right: 6px"></span> Gerar</a></td>
									  </tr>';
							}
						}
						else{
							echo "<tr><td align='center' colspan='4' style='padding: 16px'>Você ainda não possui nenhum certificado!</td></tr>";
						}

						?>

					</table>
			        </div>
			          
			      </div>
			      <!-- rodape -->
			      <div class="modal-footer">

			      </div>

			    </div>
			  </div>
		</div>