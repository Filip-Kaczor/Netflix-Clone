<?php
    if(isset($_GET ['id'])&&isset($_GET ['name'])) {
        $categoryId = $_GET ['id'];
    }
    else {
        header("Location: ".$indexUrl);
    }

    require_once("includes/header.php");

	$Q = mysqli_query($con, "SELECT * FROM categories WHERE id='$categoryId'");
    $R = mysqli_fetch_array($Q);

    if(mysqli_num_rows($Q) == NULL) {
        ?>
            <script>
                history.back();
            </script>
        <?php
    }
?>

<div class="containerMargin">

	<div>
		<?php
			echo $swiper->kategorie();
		?>

		<div class="swiperDiv">

			<?php
				echo $functions->getAjaxPageHeadline($categoryId, "categoryId");
			?>

			<div id="resultDiv"></div>

			<?php echo $functions->getLoading("loadingAjax", "Ładuję..."); ?>

		</div>
	</div>


	<script>
		console.log(document.body.scrollHeight);
		console.log(document.body.scrollTop + window.innerHeight);
		var categoryId = '<?php echo $categoryId; ?>';

		$(document).ready(function() {

			$('#loadingAjax').show();

			//Original ajax request for loading first posts 
			$.ajax({
				url: "ajax/ajax_load_category.php",
				type: "POST",
				data: "page=1&categoryId=" + categoryId,
				cache:false,

				success: function(data) {
					$('#loadingAjax').hide();
					$('#resultDiv').html(data);
				}
			});

			$(window).scroll(function() {
				var height = $('#resultDiv').height(); //Div containing posts
				var scroll_top = $(this).scrollTop();
				var page = $('#resultDiv').find('.nextPage').val();
				var noMorePosts = $('#resultDiv').find('.noMorePosts').val();

				console.log(Math.ceil(document.body.scrollTop + window.innerHeight));
				console.log(document.body.scrollHeight);

				var loadFaster;
				if ($(window).width() <= 500) {
					loadFaster = window.innerHeight;
				}else {
					loadFaster = window.innerHeight/3;
				}

				if ((document.body.scrollHeight <= Math.ceil(document.body.scrollTop + window.innerHeight + loadFaster)) && noMorePosts == 'false') {
					$('#loadingAjax').show();

					var ajaxReq = $.ajax({
						url: "ajax/ajax_load_category.php",
						type: "POST",
						data: "page=" + page + "&categoryId=" + categoryId,
						cache:false,
						async : false,

						success: function(response) {
							$('#resultDiv').find('.nextPage').remove(); //Removes current .nextpage 
							$('#resultDiv').find('.noMorePosts').remove(); //Removes current .nextpage 

							$('#loadingAjax').hide();
							$('#resultDiv').append(response);
						}
					});

				} //End if 

				return false;

			}); //End (window).scroll(function())


		});

	</script>

	<?php require_once("includes/footer.php"); ?>

</div>