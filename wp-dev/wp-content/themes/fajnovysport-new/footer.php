<?php
$page_pristupnost = get_page_link(2130);
$social_media = get_field("social_media", "option");
?>

</main>
<footer>
    <div class="footer__boxs">
        <div class="footer__box">
            <?php wp_nav_menu([
            	"theme_location" => "menu-2",
            ]); ?>
        </div>
        <div class="footer__box">
            <?php wp_nav_menu([
            	"theme_location" => "menu-3",
            ]); ?>
        </div>
        <div class="footer__box">
            <div class="footer__box__pack">
                <p><strong>Magistrát města Ostravy</strong><br />
                Prokešovo náměstí 8<br>729 30 Ostrava</p>
                <?php if ($social_media):
                	if (!empty($social_media["phone"])) {
                		echo '<p><a href="tel:+420' .
                			preg_replace(
                				"/[^0-9]/",
                				"",
                				$social_media["phone"]
                			) .
                			'" aria-label="Kontaktní číslo: ' .
                			esc_html($social_media["phone"]) .
                			'">+420 ' .
                			esc_html($social_media["phone"]) .
                			"</a></p>";
                	}

                	if (!empty($social_media["mail"])) {
                		echo '<p><a href="mailto:' .
                			esc_attr($social_media["mail"]) .
                			'" aria-label="Kontaktní email: ' .
                			esc_attr($social_media["mail"]) .
                			'">' .
                			esc_html($social_media["mail"]) .
                			"</a></p>";
                	}
                endif; ?>
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
                    <img src="<?php echo get_template_directory_uri() .
                    	"/images/svg/ostrava-logo.svg"; ?>" alt="logo Ostrava">
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
<?php wp_footer(); ?>
</body>
</html>
