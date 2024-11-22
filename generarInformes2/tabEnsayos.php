				<p class="blanco" >&nbsp;</p>
				<?php 
				$letraItem++;
				echo '<p class="blancoSubTitulos">';
					echo '<span style="text-decoration:underline;"><b>'.$letraItem.'.- Resultados de '.utf8_decode($rowEns['Ensayo']).':</b></span>';
				echo '</p>';
				$i=1;
				?>

				<p class="blanco" >&nbsp;</p>

				<!-- <p style="text-indent: 60px; line-height:15pt;" align="justify"> -->
				<p class="txtEnsayos">
					<?php echo utf8_decode(stripcslashes(nl2br($rowEns['txtIntroduccion']))); ?>
				</p>
				
				<p class="blanco" >&nbsp;</p>
