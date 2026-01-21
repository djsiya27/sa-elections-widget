<?php
if (!defined('ABSPATH')) exit;

class SA_Elections_API {
    private $base = 'https://api.elections.org.za/';
    private $token_option = 'sa_elections_v4_token';
    private $token_expiry_option = 'sa_elections_v4_token_expiry';

    public static function shortcode_live($atts = []) {
        $atts = shortcode_atts(['title' => 'Live IEC Results'], $atts, 'sa_elections_widget');
        ob_start(); ?>
        <div class="sa-elections-v4-live">
            <h3><?php echo esc_html($atts['title']); ?></h3>
            <div><?php echo esc_html('Live mode — requires IEC API token configured in plugin.'); ?></div>
        </div>
        <?php
        return ob_get_clean();
    }
}
