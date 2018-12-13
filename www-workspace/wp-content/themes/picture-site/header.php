<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title><?php echo $sTitle; $sSiteName = get_bloginfo('name'); if ($sSiteName !== '') { echo ' - '.$sSiteName; } ?></title>
		<link href="<?php echo get_bloginfo('template_directory');?>/style.css" rel="stylesheet">
		<?php wp_head();?>
		<link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">

		<script
			src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
			integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
			crossorigin="anonymous"
		></script>

		<script type="text/javascript">
			let aoImages = []
			let iCurrentIndex = -1
			let sLoadingGifUri = '<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif'

			function populateLightboxDataStructure() {
				// look for all images with class 'lightbox-image'
				$('.lightbox-image').each(function() {
					// store their source and title
					aoImages.push({
						src: this.src,
						lightSrc: $(this).attr('lightbox-src'),
						title: this.title
					})
				})

				// apply click event
				$('.lightbox-image').click(function() {
					const sMediumSrc = $(this).attr('src')
					for(let cCheckImage = 0; cCheckImage < aoImages.length; cCheckImage++) {
						if (aoImages[cCheckImage].src === sMediumSrc) {
							iCurrentIndex = cCheckImage
							openLightbox(iCurrentIndex)
						}
					}
				})

				// add lightbox nav buttons
				$('.lightbox-button#close').click(function() {
					closeLightbox()
				})
				$('.lightbox-button#next').click(function() {
					lightboxNav(true)
				})
				$('.lightbox-button#previous').click(function() {
					lightboxNav(false)
				})
			}

			// open lightbox
			function openLightbox(iImage) {
				// set src to image
				updateLightboxSrc()
				// show element
				$('#lightbox-container').removeClass('hide').addClass('show')
			}

			// left/right in lightbox
			function lightboxNav(bForward) {
				// get next/prev image and set it as src
				if (bForward) {
					iCurrentIndex++
				} else {
					iCurrentIndex--
				}
				updateLightboxSrc()
			}

			function iIndexWithinBounds(iIndex) {
				if (iIndex < 0) {
					iIndex = aoImages.length - 1
				} 
				if (iIndex === aoImages.length) {
					iIndex = 0
				}
				return iIndex
			}

			function updateLightboxSrc() {
				// show loading indicator
				$('#lightbox-image-container img').attr('src', sLoadingGifUri);
				
				// set correct url for image
				iCurrentIndex = iIndexWithinBounds(iCurrentIndex);
				$('#lightbox-image-container img').attr('src', aoImages[iCurrentIndex].lightSrc);
				
				let sContent = '';
				if(aoImages[iCurrentIndex].title !== '') {
					sContent = '<hr/>' + aoImages[iCurrentIndex].title;
				}
				$('#lightbox-image-controls #caption').html(sContent);

				// preload neighbors
				let iPrevious = iCurrentIndex - 1;
				let iNext = iCurrentIndex + 1;
				preloadImage(iPrevious);
				preloadImage(iNext);
			}

			function preloadImage(iIndexToPreload) {
				iIndexToPreload = iIndexWithinBounds(iIndexToPreload);
				(new Image()).src = aoImages[iIndexToPreload];
			}

			// close lightbox
			function closeLightbox() {
				iCurrentIndex = -1
				// jquery hide element
				$('#lightbox-container').removeClass('show').addClass('hide')
			}

			$(document).ready(() => populateLightboxDataStructure())
		</script>

		<link rel="alternate" type="application/rss+xml" title="Sam Thomson Travel Pictures RSS Feed" href="/feed/rss.xml" />
	</head>

	<body>
