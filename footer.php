</div>
<div id="loading" class="d-none">
    <div><h6>LOADING...</h6></div>
</div>
<footer id="footer" role="contentinfo">
    <div id="disclaimer">
        <div class="container grey_bg">
            <small>
                <?php dynamic_sidebar('disclaimer-area')?>
            </small>
        </div>
    </div>
    <?php
        $my_current_lang = apply_filters( 'wpml_current_language', NULL );
        if($my_current_lang == 'it' || $my_current_lang == 'fr'):
    ?>
    <div id="newsletter" class="py-5 red_bg">
        <div class="container">
            <div class="col offset-0 col-md-6 offset-md-3 mb-3">
                <?php _e('Are you interested in knowing all the news in Metamedicine and in keeping yourself informed about upcoming courses?
                 Sign up for our monthly newsletter!','metamedicina')?>
            </div>
            <div class="col offset-0 col-md-6 offset-md-3 mb-3">
                <input type="text" required placeholder="<?php _e('Name','metamedicina')?>" class="form-control" id="name">
            </div>
            <div class="col offset-0 col-md-6 offset-md-3 mb-3">
                <input type="email" required placeholder="email" class="form-control" id="psw">
            </div>
            <div class="col offset-0 col-md-6 offset-md-3">
                <div class="btn btn-primary"><?php _e('sign up','metamedicina')?></div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div id="copyright" class="grey_bg text-center py-3">
        <div class="container ">
            <div class="custom">
                <a href="/privacy-policy.html">PRIVACY POLICY</a> | <a href="/cookie-policy.html">COOKIE POLICY</a>
                <p >Copyright © 2018 Metamedicina di Claudia Rainville • Tutti i diritti riservati</p>
                <small>Sito web realizzato da <a href="http://wp-admin.it/" target="_blank" rel="noopener noreferrer" title="Siti Web a Reggio Emilia">WP-Admin</a></small>
            </div>
        </div>
    </div>
</footer>
</div>
<?php wp_footer(); ?>
</body>

</html>