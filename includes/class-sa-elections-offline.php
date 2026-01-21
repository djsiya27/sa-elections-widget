<?php
if (!defined('ABSPATH')) exit;

class SA_Elections_Offline {
    private static $data_file = 'assets/data/lge2021.json';
    private static $logos_url = 'assets/logos/';

    public static function load_data() {
        $path = SA_ELECTIONS_V4_DIR . self::$data_file;
        if (!file_exists($path)) return false;
        $json = file_get_contents($path);
        $data = json_decode($json, true);
        return $data;
    }

    public static function shortcode_offline($atts = []) {
        $atts = shortcode_atts(['title' => 'LGE 2021 Results (National)', 'compact' => 'false'], $atts, 'sa_elections_widget_lge2021');
        $data = self::load_data();
        if (!$data) return '<div class="sa-elections-offline">No data available.</div>';

        // show top 6 by percent
        usort($data, function($a,$b){ return ($b['Percent'] ?? 0) <=> ($a['Percent'] ?? 0); });
        $top = array_slice($data, 0, 6);

        ob_start(); ?>
        <div class="sa-elections-offline">
            <h3><?php echo esc_html($atts['title']); ?></h3>
            <div class="lge-table">
                <table>
                    <thead><tr><th>Party</th><th style="text-align:right">Votes</th><th style="text-align:right">%</th></tr></thead>
                    <tbody>
                        <?php foreach($top as $p): 
                            $logo = SA_ELECTIONS_V4_URL . 'assets/logos/' . sanitize_title($p['Party']) . '.png';
                        ?>
                        <tr>
                            <td><img src="<?php echo esc_url($logo); ?>" class="party-logo" alt=""> <strong><?php echo esc_html($p['Party']); ?></strong>
                                <div class="bar"><span style="--w:<?php echo esc_attr($p['Percent']); ?>%"></span></div>
                            </td>
                            <td style="text-align:right"><?php echo number_format($p['Votes']); ?></td>
                            <td style="text-align:right"><?php echo esc_html($p['Percent']); ?>%</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="footer">Data: LGE 2021</div>
        </div>
        <?php
        return ob_get_clean();
    }
}
