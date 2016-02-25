	<div class='footer'>
		
		&copy; <?php echo date('Y');?>
	</div>
	<span style='float:right;'><a href='hindamine.zip'>Laealla</a></span>
		</div>
		
<script>
	$(function() {
		$('#closeMessage').click(function() {
				$('#message').slideUp('slow');
				setTimeout(function(){
					window.location = './';
					},1000)
			
		});
	});
	
</script>
	</body>
</html>
