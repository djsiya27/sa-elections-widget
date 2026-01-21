<?php
if (!defined('ABSPATH')) exit;

class SA_Elections_Slider {
    public static function shortcode_slider($atts = []) {
        $atts = shortcode_atts(['theme' => 'light', 'mode' => 'offline'], $atts, 'sa_elections_slider');
        $mode = $atts['mode'];
        // load offline data
        $data = [];
        $path = SA_ELECTIONS_V4_DIR . 'assets/data/lge2021.json';
        if (file_exists($path)) {
            $json = file_get_contents($path);
            $data = json_decode($json, true);
        }
        if (empty($data)) return '<div class="sa-elections-slider">No data.</div>';
        // top 6
        usort($data, function($a,$b){ return ($b['Percent'] ?? 0) <=> ($a['Percent'] ?? 0); });
        $top = array_slice($data, 0, 6);

        ob_start(); ?>
        <div class="sa-elections-slider <?php echo esc_attr($atts['theme']); ?>" data-mode="<?php echo esc_attr($mode); ?>">
            <div class="slider-region">National</div>
            <div class="slider-bars">
                <?php foreach($top as $p): 
                    $slug = sanitize_title($p['Party']);
                    $logo = SA_ELECTIONS_V4_URL . 'assets/logos/' . $slug . '.svg';
                    $color = isset($p['Color']) ? $p['Color'] : '#b30000';
                ?>
                <div class="party" data-party="<?php echo esc_attr($slug); ?>" data-percent="<?php echo esc_attr($p['Percent']); ?>">
                    <img src="<?php echo esc_url($logo); ?>" class="logo">
                    <div class="meta"><strong><?php echo esc_html($p['Party']); ?></strong><span class="percent"><?php echo esc_html($p['Percent']); ?>%</span></div>
                    <div class="bar" style="--c:<?php echo esc_attr($color); ?>"><span style="--w:<?php echo esc_attr($p['Percent']); ?>%"></span></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
