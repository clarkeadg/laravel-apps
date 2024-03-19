import './bootstrap';

import heroCarousel from './carousel/hero-carousel';
import categoryCarousel from './carousel/category-carousel';
import photosCarousel from './carousel/photos-carousel';
import videoPlayer from './video/video-player';

$(document).ready(()=>{
  heroCarousel();
  categoryCarousel();
  photosCarousel();
  videoPlayer();

  // auto open the file upload menu
  $("body").on("click","#photoUpload",function(e) {   
    const $form = $(this).closest('.tweet-create-form');
    if ($form && $form.length) {
      const hidden = $form.hasClass('hide-photo-upload');
      if (hidden) {
        const $fileUploadButton = $form.find('input[type="file"]');
        if ($fileUploadButton && $fileUploadButton.length) {
          $fileUploadButton.click();
        }
      }
    }
  });
})

// copy text to the clipboard for copy/paste
window.copyToClipboard = async (textToCopy) => {
  // Navigator clipboard api needs a secure context (https)
  if (navigator.clipboard && window.isSecureContext) {
      await navigator.clipboard.writeText(textToCopy);
  } else {
      // Use the 'out of viewport hidden text area' trick
      const textArea = document.createElement("textarea");
      textArea.value = textToCopy;
          
      // Move textarea out of the viewport so it's not visible
      textArea.style.position = "absolute";
      textArea.style.left = "-999999px";
          
      document.body.prepend(textArea);
      textArea.select();

      try {
          document.execCommand('copy');
      } catch (error) {
          console.error(error);
      } finally {
          textArea.remove();
      }
  }
}