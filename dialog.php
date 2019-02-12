<?php
	function dialog($tipo, $msg){
		echo "<dialog class='dialog-{$tipo}'>";
			echo "<header>";
				echo "<button type='button' class='close-dialog close' style='padding-right: 10px;'>&times;</button>";
				if($tipo === "success")
					echo "<h4 style='font-weight: 700'><span class='glyphicon glyphicon-ok-sign'></span> Sucesso!</h4>";
				if($tipo === "alert")
				echo "<h4 style='font-weight: 700'><span class='glyphicon glyphicon-warning-sign'></span> Ops!</h4>";
				if($tipo === "erro")
					echo "<h4 style='font-weight: 700'><span class='glyphicon glyphicon-warning-sign'></span> Ops!</h4>";
			echo "</header>";
			echo "<p>{$msg}</p>";
		echo "</dialog>";
		
		if(isset($_SESSION['success']))
			unset($_SESSION['success']);
		
		if(isset($_SESSION['erro']))
			unset($_SESSION['erro']);
	}
?>

<script>
	window.addEventListener("load", function(){
		$("dialog").animate({
			left: "0"
		}, 600);
		
		$(".close-dialog").click(function(){
			$("dialog").animate({
				left: "-100%"
			}, 400);
		});
	});
</script>