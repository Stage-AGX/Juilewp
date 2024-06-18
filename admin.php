<?php

// Security : avoid access on the file from WP settings
if (!defined('ABSPATH')) {
  exit;
}



// Add administration menu
function agerixcarte_add_admin_menu() {
  add_menu_page(
    'Agerix Carte',            // Title of the page
      'Agerix Carte',            // Title of the menu
      'manage_options',                  // Capacity
      'agerixcarte',                     // Id of the menu
      'agerixcarte_dashboard_page',      // function to show the contenu of the page
      plugin_dir_url(__FILE__) . 'assets/petale-agerix.svg', // logo of the menu
        6                             // position 
  ); 


}

add_action('admin_menu', 'agerixcarte_add_admin_menu');


// Afficher la page d'administration
function agerix_admin_page() {
  ?>
  <div class="wrap">
      <h1>Agerix Carte</h1>
      <form method="post" action="options.php">
          <?php
          settings_fields('agerix_options_group');
          do_settings_sections('agerix-carte');
          submit_button();          
          ?>
      </form>
  </div>
  <?php
}
//add_action('admin_page','agerix_admin_page');

// Initialiser les paramètres
function agerix_settings_init() {
  register_setting('agerix_options_group', 'agerix_countries_data');
  register_setting('agerix_options_group', 'agerix_categories_colors', 'agerix_sanitize_colors');

  add_settings_section(
      'agerix_settings_section',
      'Paramètres de la carte',
      'agerix_settings_section_callback',
      'agerix-carte'
  );

  add_settings_field(
      'agerix_countries_data',
      'Données des pays',
      'agerix_countries_data_render',
      'agerix-carte',
      'agerix_settings_section'
  );

  add_settings_field(
      'agerix_categories_colors',
      'Couleurs des catégories',
      'agerix_categories_colors_render',
      'agerix-carte',
      'agerix_settings_section'
  );
}
add_action('admin_init', 'agerix_settings_init');

function agerix_settings_section_callback() {
  echo 'Modifier les catégories des pays et leurs couleurs.';
}


// to change the colors on the back-end
function agerix_countries_data_render() {
  $options = get_option('agerix_countries_data', file_get_contents(plugin_dir_path(__FILE__) . 'assets/js/categories-data.json'));
  ?>
  <textarea name="agerix_countries_data" rows="10" cols="50"><?php echo esc_textarea($options); ?></textarea>
  <?php
}

function agerix_categories_colors_render() {
  $categories_colors = get_option('agerix_categories_colors', [
      'Categorie 1' => '#FF5733',
      'Categorie 2' => '#DAF7A6',
      'Categorie 3' => '#61F9F2',
      'Categorie 4' => '#616DF9',
      'Categorie 5' => '#B13CFD',
      'Categorie 6' => '#FD3CFA',
  ]);
  foreach ($categories_colors as $categorie => $color) {
      ?>
      <p>
          <label for="agerix_categories_colors[<?php echo esc_attr($categorie); ?>]"><?php echo esc_html($categorie); ?>:</label>
          <input type="color" name="agerix_categories_colors[<?php echo esc_attr($categorie); ?>]" value="<?php echo esc_attr($color); ?>">
      </p>
      <?php
  }
}
  function agerix_sanitize_colors($input) {
    $sanitized = [];
    foreach ($input as $key => $value) {
        $sanitized[$key] = sanitize_hex_color($value);
    }
    return $sanitized;
  }
?>