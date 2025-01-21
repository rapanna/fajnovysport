<?php 
$page_pristupnost = get_page_link(2130); 
$social_media = get_field('social_media', 'option'); 
?>

</main>
<footer>
    <div class="footer__boxs">
        <div class="footer__box">
            <?php
                wp_nav_menu([
                    'theme_location' => 'menu-2',
                ]);
            ?>
        </div>
        <div class="footer__box">
            <?php
                wp_nav_menu([
                    'theme_location' => 'menu-3',
                ]);
            ?>
        </div>
        <div class="footer__box">
            <div class="footer__box__pack">
                <p><strong>Magistrát města Ostravy</strong><br />
                Prokešovo náměstí 8<br>729 30 Ostrava</p>
                <?php
                    if ($social_media) : 
                        if (!empty($social_media['phone'])) {
                            echo '<p><a href="tel:+420' . preg_replace('/[^0-9]/', '', $social_media['phone']) . '" aria-label="Kontaktní číslo: ' . esc_html($social_media['phone']) . '">+420 ' . esc_html($social_media['phone']) . '</a></p>';
                        }

                        if (!empty($social_media['mail'])) {
                            echo '<p><a href="mailto:' . esc_attr($social_media['mail']) . '" aria-label="Kontaktní email: ' . esc_attr($social_media['mail']) . '">' . esc_html($social_media['mail']) . '</a></p>';
                        }
                    endif;
                ?>
            </div>        
        </div>
        <div class="footer__box">
            <div class="footer__box__pack">
                <p><strong>Městské společnosti v oblasti sportu</strong></p>
                <p>OSTRAVAR ARÉNA<BR><a href="https://arena-vitkovice.cz" target="_blank">arena-vitkovice.cz</a></p>
                <p>SAREZA<BR><a href="https://sareza.cz" target="_blank">sareza.cz</a></p>
            </div>          
        </div>
        <div class="footer__box">
            <div class="footer__box__pack">
                <a href="/" aria-label="odkaz na oficiální web prezentaci Ostravy"> 
                    <img src="<?php echo get_template_directory_uri() . '/_statika/img/svg/ostrava-logo.svg' ?>" alt="logo Ostrava">
                </a>          
            </div>          
        </div>
    </div>
    <div class="footer__bottom">
        © 2018 - 2024 Copyright | Všechna práva vyhrazena - použití obsahu nebo jeho částí je možné pouze se souhlasem <a
            href="https://ostrava.cz" aria-label="oficiální stránky" target="_blank">Magistrátu města Ostravy</a>. | <a href="<?php echo $page_pristupnost; ?>">Prohlášení o
            přístupnosti</a>
    </div>
</footer>
<?php
wp_footer();
?>
  <script>
    jQuery('.js-sliders').slick({
      dots: true,
      infinite: true,  
      speed: 300,
      slidesToShow: 1,
      adaptiveHeight: true,
      autoplay: true,      

    });

    jQuery(document).ready(function () {
      jQuery('.slider__block').each(function () {
        var imgHeight = jQuery(this).find('.slider__img').outerHeight();
        var imgWidth = jQuery(this).find('.slider__img').outerWidth();


        if( imgHeight >= 453 ) {
          var fontSize = 31;
          var topHeight = 38;
          var buttonSize = 17;
          var buttonPaddingTop = 10;
        
        } else {
          var fontSize = imgHeight / 453 * 31;       
          if(fontSize < 15) {
            fontSize = 15
          }

          var topHeight = imgHeight / 453 * 38;      
          var buttonSize = imgHeight / 453 * 17;
          if(buttonSize < 12) {
            buttonSize = 12
          }
          var buttonPaddingTop = imgHeight / 453 * 10;

        }
        if( imgWidth >= 1921 ) {
          var leftWidth = 380;      
          var hWidth = 446;
          var buttonPaddingLeft = 36;      
        } else {
          var leftWidth = imgWidth / 1920 * 380;
          var hWidth = imgWidth / 1920 * 446;      
          var buttonPaddingLeft = imgWidth / 1920 * 36;


        }
        jQuery(this).find('.slider__icona').attr('style', 'height: ' + imgHeight + 'px;');
        if( imgWidth <= 1920 ) {    
          jQuery(this).next('.slider__text').attr('style', 'top: ' + topHeight + 'px; left: ' +  leftWidth + 'px; width: ' +  hWidth + 'px; ' );
          jQuery(this).next('.slider__text').find('h2').attr('style', 'font-size: ' + fontSize + 'px;');
          jQuery(this).next('.slider__text').find('.slider__button').attr('style', 'font-size: ' + buttonSize + 'px; padding-left: ' + buttonPaddingLeft + 'px; padding-right: ' + buttonPaddingLeft + 'px; padding-top: ' + buttonPaddingTop + 'px; padding-bottom: ' + buttonPaddingTop + 'px; ');
        }
      });
    });
  </script>
</body>
</html>
