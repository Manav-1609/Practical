<?php
/**
 * Plugin Name: Team Member Spotlight
 * Description: Manage and spotlight team members.
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) exit;

global $team_db_version;
$team_db_version = '1.0';
define('TEAM_TABLE_NAME', $GLOBALS['wpdb']->prefix . 'team_members');

// Plugin Activation - Create DB Table
register_activation_hook(__FILE__, 'team_member_activate');
function team_member_activate() {
    global $wpdb;
    $table = TEAM_TABLE_NAME;

    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        member_name varchar(100) NOT NULL,
        position varchar(100) NOT NULL,
        bio text NOT NULL,
        featured_until datetime NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Plugin Deactivation - Clean up (without deleting data)
register_deactivation_hook(__FILE__, 'team_member_deactivate');
function team_member_deactivate() {
    // Cleanup can be performed here if needed
}

// Admin Page
add_action('admin_menu', function () {
    add_menu_page('Team Member Spotlight', 'Team Spotlight', 'manage_options', 'team-spotlight', 'render_team_admin_page');
});

// Enqueue Scripts
add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook !== 'toplevel_page_team-spotlight') return;

    wp_enqueue_script('team-ajax', plugin_dir_url(__FILE__) . 'team.js', ['jquery'], null, true);
    wp_localize_script('team-ajax', 'team_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('team_member_nonce')
    ]);
});

// AJAX Handler
add_action('wp_ajax_add_team_member', 'handle_add_team_member');
function handle_add_team_member() {
    check_ajax_referer('team_member_nonce', 'nonce');

    $name = sanitize_text_field($_POST['name']);
    $position = sanitize_text_field($_POST['position']);
    $bio = sanitize_textarea_field($_POST['bio']);
    $featured = sanitize_text_field($_POST['featured_until']);

    if (empty($name) || empty($position) || empty($bio) || empty($featured)) {
        wp_send_json_error('All fields are required.');
    }

    if (strtotime($featured) < time()) {
        wp_send_json_error('Featured Until date must be in the future.');
    }

    global $wpdb;
    $inserted = $wpdb->insert(TEAM_TABLE_NAME, [
        'member_name' => $name,
        'position' => $position,
        'bio' => $bio,
        'featured_until' => $featured
    ]);

    if ($inserted) {
        wp_send_json_success('Member added successfully.');
    } else {
        wp_send_json_error('Insert failed.');
    }
}

// Admin Page Render
function render_team_admin_page() {
    global $wpdb;
    $members = $wpdb->get_results("SELECT * FROM " . TEAM_TABLE_NAME . " ORDER BY id DESC");
    ?>
    <div class="wrap">
        <h1>Team Member Spotlight</h1>

        <h2>Add New Member</h2>
        <form id="team-member-form">
            <input type="text" name="name" placeholder="Name" required><br><br>
            <input type="text" name="position" placeholder="Position" required><br><br>
            <textarea name="bio" placeholder="Bio" required></textarea><br><br>
            <input type="datetime-local" name="featured_until" required><br><br>
            <button type="submit" class="button button-primary">Add Member</button>
        </form>

        <div id="team-message" style="margin-top: 10px;"></div>

        <h2 style="margin-top: 40px;">All Team Members</h2>
        <table class="widefat">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Bio</th>
                    <th>Featured Until</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($members) : foreach ($members as $m) : ?>
                    <tr>
                        <td><?php echo esc_html($m->id); ?></td>
                        <td><?php echo esc_html($m->member_name); ?></td>
                        <td><?php echo esc_html($m->position); ?></td>
                        <td><?php echo esc_html($m->bio); ?></td>
                        <td><?php echo esc_html($m->featured_until); ?></td>
                    </tr>
                <?php endforeach; else : ?>
                    <tr><td colspan="5">No members found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}

add_shortcode('team_spotlight', 'render_team_spotlight_shortcode');

function render_team_spotlight_shortcode($atts) {
    global $wpdb;

    $atts = shortcode_atts([
        'count' => 3,
        'position' => ''
    ], $atts, 'team_spotlight');

    $table = TEAM_TABLE_NAME;
    $now = current_time('mysql');
    $count = intval($atts['count']);
    $position = sanitize_text_field($atts['position']);

    if (!empty($position)) {
        $sql = $wpdb->prepare(
            "SELECT * FROM $table WHERE featured_until > %s AND position = %s ORDER BY featured_until DESC LIMIT %d",
            $now,
            $position,
            $count
        );
    } else {
        $sql = $wpdb->prepare(
            "SELECT * FROM $table WHERE featured_until > %s ORDER BY featured_until DESC LIMIT %d",
            $now,
            $count
        );
    }

    $results = $wpdb->get_results($sql);

    if (!$results) {
        return '<p>No featured members.</p>';
    }

    ob_start();
    echo '<div class="team-spotlight">';
    foreach ($results as $member) {
        echo '<div class="team-member">';
        echo '<h3>' . esc_html($member->member_name) . '</h3>';
        echo '<p><strong>Position:</strong> ' . esc_html($member->position) . '</p>';
        echo '<p>' . esc_html($member->bio) . '</p>';
        echo '<p><em>Featured until: ' . esc_html(date('F j, Y', strtotime($member->featured_until))) . '</em></p>';
        echo '</div>';
    }
    echo '</div>';
    return ob_get_clean();
}
